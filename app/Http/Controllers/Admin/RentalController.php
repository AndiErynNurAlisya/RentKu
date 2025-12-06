<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\Vehicle;
use App\Models\Damage;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Notifications\RentalApprovedNotification; 
use Illuminate\Support\Facades\Notification; 
use App\Jobs\SendWhatsAppNotification; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Controller untuk mengelola Rental (Penyewaan Kendaraan) dari sisi Admin
 * Menangani persetujuan, penyelesaian, pembatalan rental, dan pencatatan kerusakan
 */
class RentalController extends Controller
{
    /**
     * Menampilkan daftar semua rental dengan filter status
     * 
     * @param Request $request - Request yang berisi parameter filter (optional)
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Query rental dengan eager loading relasi user dan vehicle
        $query = Rental::with(['user', 'vehicle']);

        // Filter berdasarkan status jika parameter 'status' diisi
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Urutkan berdasarkan data terbaru dan pagination 10 data per halaman
        $rentals = $query->latest()->paginate(10);

        // Kirim data rentals ke view
        return view('admin.rentals.index', compact('rentals'));
    }

    /**
     * Menampilkan detail rental tertentu beserta informasi kerusakan
     * 
     * @param Rental $rental - Model Rental yang akan ditampilkan
     * @return \Illuminate\View\View
     */
    public function show(Rental $rental)
    {
        // Load relasi user, vehicle, dan damages untuk menghindari N+1 query
        $rental->load(['user', 'vehicle', 'damages']);

        // Hitung total biaya kerusakan dari semua entri di tabel damages
        $damageCost = $rental->damages->sum('damage_cost');

        // Kirimkan data rental dan damageCost ke view
        return view('admin.rentals.show', compact('rental', 'damageCost'));
    }

    /**
     * Menyetujui rental yang berstatus 'pending'
     * Mengubah status rental menjadi 'active' dan status kendaraan menjadi 'dipinjam'
     * 
     * @param Rental $rental - Model Rental yang akan disetujui
     * @param Request $request - Request data
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(Rental $rental, Request $request)
    {
        // 1. Validasi Status Awal - Hanya rental berstatus 'pending' yang bisa disetujui
        if ($rental->status != 'pending') {
            return back()->with('error', 'Hanya rental berstatus PENDING yang bisa disetujui.');
        }

        // 2. Proses Transaksi (Menggunakan Database Transaction untuk keamanan data)
        DB::beginTransaction();
        try {
            // A. Update Status Rental menjadi 'active'
            $rental->update([
                'status' => 'active',
                'admin_approval_date' => now(), // Catat waktu persetujuan admin
                // Anda bisa menambahkan kolom 'approved_by' untuk mencatat ID admin yang menyetujui
            ]);

            // B. Update Status Kendaraan menjadi 'dipinjam'
            $rental->vehicle->update(['status' => 'dipinjam']);

            // C. Dispatch Job WhatsApp ke Queue untuk mengirim notifikasi ke customer
            // Mengirim 3 argumen: User (customer), Rental, dan Type notifikasi
            $customer = $rental->user;
            SendWhatsAppNotification::dispatch($customer, $rental, 'customer_rental_approved'); 
            
            // Commit transaksi jika semua proses berhasil
            DB::commit();

            return back()->with('success', "Rental ID: {$rental->id} berhasil disetujui dan notifikasi telah dikirim!");

        } catch (\Exception $e) {
            // Rollback jika terjadi error untuk mengembalikan data ke kondisi semula
            DB::rollBack();
            
            // Catat error ke log untuk debugging
            \Log::error('Persetujuan Rental GAGAL (Approve Error): ' . $e->getMessage()); 
            
            return back()->with('error', 'Gagal menyetujui rental karena kesalahan sistem.')->withInput();
        }
    }

    /**
     * Menyelesaikan rental yang berstatus 'active'
     * Menghitung denda keterlambatan dan biaya kerusakan, lalu mengupdate total biaya
     * 
     * @param Rental $rental - Model Rental yang akan diselesaikan
     * @param Request $request - Request data
     * @return \Illuminate\Http\RedirectResponse
     */
    public function complete(Rental $rental, Request $request)
    {
        // 1. Validasi Status Awal - Hanya rental 'active' yang bisa diselesaikan
        if ($rental->status != 'active') {
            return back()->with('error', 'Hanya rental yang AKTIF yang bisa diselesaikan.');
        }

        // 2. Tentukan Tanggal Pengembalian Aktual (saat ini)
        $actualReturnDate = now(); 
        $expectedEndDate = $rental->end_date; 

        // 3. Hitung Denda Keterlambatan
        $penaltyCost = 0;
        $lateDays = 0;

        // Cek apakah ada keterlambatan pengembalian
        if ($actualReturnDate->greaterThan($expectedEndDate)) {
            // Hitung selisih waktu dalam jam
            $diffInHours = $actualReturnDate->diffInHours($expectedEndDate);
            
            // Konversi ke hari (pembulatan ke atas)
            $lateDays = (int) ceil($diffInHours / 24); 
            
            // Hitung denda: jumlah hari terlambat × harga sewa per hari
            $penaltyCost = $lateDays * $rental->price_per_day; 
            
            // Log informasi keterlambatan
            Log::info("Rental RNT-{$rental->id} terlambat {$lateDays} hari ({$diffInHours} jam). Denda: Rp {$penaltyCost}");
        }

        // 4. Hitung Total Biaya Kerusakan dari tabel damages
        $damageCost = $rental->damages()->sum('damage_cost');
        
        // 5. Proses Transaksi (Dalam Database Transaction)
        try {
            DB::beginTransaction();
            
            // Hitung total harga baru: harga sewa awal + denda + biaya kerusakan
            $originalBasePrice = $rental->total_days * $rental->price_per_day; // Harga sewa awal
            $newTotal = $originalBasePrice + $penaltyCost + $damageCost;

            // Update data rental
            $rental->update([
                'status' => 'completed',
                'actual_return_date' => $actualReturnDate,
                'penalty_cost' => $penaltyCost, 
                'total_price' => $newTotal,
            ]);
            
            // Update Status Kendaraan menjadi 'tersedia' kembali
            $rental->vehicle->update(['status' => 'tersedia']);

            // Dispatch Notifikasi WhatsApp ke Customer (Rental Selesai)
            $customer = $rental->user;
            SendWhatsAppNotification::dispatch($customer, $rental, 'customer_rental_completed'); 

            // Commit transaksi hanya jika semua proses berhasil
            DB::commit(); 
            
            // 6. Siapkan Pesan Sukses dengan Detail Biaya
            $message = 'Rental berhasil diselesaikan!';
            if ($penaltyCost > 0) {
                $message .= " Denda Keterlambatan: Rp " . number_format($penaltyCost, 0, ',', '.') . " ({$lateDays} hari).";
            }
            if ($damageCost > 0) {
                $message .= " Biaya Kerusakan: Rp " . number_format($damageCost, 0, ',', '.') . ".";
            }
            $message .= " Total Biaya Akhir: Rp " . number_format($newTotal, 0, ',', '.');
            
            return back()->with('success', $message);

        } catch (\Exception $e) {
            // Rollback jika terjadi error
            DB::rollBack();
            
            // Log error untuk debugging
            Log::error('Penyelesaian Rental GAGAL (Complete Error): ' . $e->getMessage() . ' for RNT-' . $rental->id); 
            
            return back()->with('error', 'Gagal menyelesaikan rental karena kesalahan sistem. Detail error telah dicatat.')->withInput();
        }
    }

    /**
     * Membatalkan rental
     * Mengubah status rental menjadi 'cancelled' dan mengembalikan status kendaraan
     * 
     * @param Rental $rental - Model Rental yang akan dibatalkan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel(Rental $rental)
    {
        // 1. Validasi - Rental yang sudah selesai tidak bisa dibatalkan
        if ($rental->status == 'completed') {
            return back()->with('error', 'Rental yang sudah selesai tidak bisa dibatalkan!');
        }

        // Simpan status kendaraan saat ini
        $currentVehicleStatus = $rental->vehicle->status;

        // 2. Update status rental menjadi 'cancelled'
        $rental->update(['status' => 'cancelled']);
        
        // 3. Kembalikan status kendaraan ke 'tersedia' jika sedang dipinjam atau di-hold
        if ($currentVehicleStatus == 'dipinjam' || $currentVehicleStatus == 'on_hold') {
            $rental->vehicle->update(['status' => 'tersedia']);
        }

        return back()->with('success', 'Rental berhasil dibatalkan dan kendaraan telah dikembalikan ke status tersedia!');
    }

    /**
     * Menambahkan catatan kerusakan pada rental tertentu
     * 
     * @param Request $request - Request yang berisi data kerusakan
     * @param Rental $rental - Model Rental terkait
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addDamage(Request $request, Rental $rental)
    {
        // Validasi input data kerusakan
        $validated = $request->validate([
            'description' => 'required|string', // Deskripsi kerusakan wajib diisi
            'damage_cost' => 'required|numeric|min:0', // Biaya kerusakan harus angka dan minimal 0
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Gambar optional, max 2MB
        ]);

        // Tambahkan rental_id dan waktu pelaporan
        $validated['rental_id'] = $rental->id;
        $validated['reported_at'] = now();

        // Upload gambar jika ada
        if ($request->hasFile('image')) {
            // Simpan gambar ke storage/app/public/damages
            $validated['image'] = $request->file('image')->store('damages', 'public');
        }

        // Simpan data kerusakan ke database
        Damage::create($validated);

        return back()->with('success', 'Kerusakan berhasil ditambahkan!');
    }
}