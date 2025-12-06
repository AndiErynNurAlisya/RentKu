<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; 
use App\Jobs\SendWhatsAppNotification; 
use Illuminate\Support\Facades\Log;
use App\Notifications\Notifiables\AdminNotifiable;

/**
 * Controller untuk mengelola Rental dari sisi Customer
 * Menangani proses booking, melihat riwayat rental, dan pembatalan rental
 */
class RentalController extends Controller
{
    /**
     * Mengecek apakah profil customer sudah lengkap
     * Customer harus melengkapi phone, address, identity_number, dan driver_license
     * 
     * @return bool - true jika profil lengkap, false jika belum
     */
    private function checkProfileComplete()
    {
        $user = auth()->user();

        // Cek apakah semua field profil penting sudah diisi
        if (!$user->phone || !$user->address || !$user->identity_number || !$user->driver_license) {
            return false;
        }
        
        return true;
    }

    /**
     * Menampilkan daftar riwayat rental customer yang sedang login
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil semua rental milik user yang login
        // Eager load relasi vehicle untuk menghindari N+1 query
        // Urutkan dari yang terbaru, pagination 10 per halaman
        $rentals = Rental::where('user_id', auth()->id())
            ->with('vehicle')
            ->latest()
            ->paginate(10);

        return view('customer.rentals.index', compact('rentals'));
    }

    /**
     * Menampilkan form booking untuk kendaraan tertentu
     * 
     * @param Vehicle $vehicle - Model Vehicle yang akan dibooking
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create(Vehicle $vehicle)
    {
        // 1. Pengecekan status ketersediaan kendaraan
        if ($vehicle->status != 'tersedia') {
            return back()->with('error', 'Kendaraan tidak tersedia!');
        }

        // 2. Cek apakah profil customer sudah lengkap
        if (!$this->checkProfileComplete()) {
            return redirect()->route('customer.profile')
                ->with('error', 'Lengkapi profil Anda terlebih dahulu (Telepon, Alamat, NIK, dan SIM) sebelum melakukan booking!');
        }

        // Tampilkan form booking dengan data kendaraan
        return view('customer.rentals.create', compact('vehicle'));
    }

    /**
     * Menampilkan detail rental tertentu
     * 
     * @param Rental $rental - Model Rental yang akan ditampilkan
     * @return \Illuminate\View\View
     */
    public function show(Rental $rental)
    {
        // Validasi - Pastikan hanya pemilik rental yang bisa melihat detail
        if ($rental->user_id != auth()->id()) {
            abort(403);
        }

        // Load relasi vehicle dan damages untuk ditampilkan di view
        $rental->load(['vehicle', 'damages']);

        return view('customer.rentals.show', compact('rental'));
    }

    /**
     * Menyimpan data booking rental baru
     * Melakukan validasi, cek konflik jadwal, dan mengirim notifikasi
     * 
     * @param Request $request - Request yang berisi data booking
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 1. Cek kelengkapan profil customer
        if (method_exists($this, 'checkProfileComplete') && !$this->checkProfileComplete()) {
            return redirect()->route('customer.profile')
                ->with('error', 'Lengkapi profil Anda terlebih dahulu sebelum melakukan booking!');
        }

        // Validasi input data booking
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id', // Kendaraan harus ada di database
            'start_date' => 'required|date|after_or_equal:today', // Tanggal mulai minimal hari ini
            'end_date' => 'required|date|after_or_equal:start_date', // Tanggal selesai >= tanggal mulai
            'notes' => 'nullable|string|max:500', // Catatan optional
        ]);

        // Ambil data kendaraan
        $vehicle = Vehicle::findOrFail($validated['vehicle_id']);
        
        // Parse tanggal dan hitung total hari rental
        $startDateCarbon = Carbon::parse($validated['start_date']);
        $endDateCarbon = Carbon::parse($validated['end_date']);
        $totalDays = $startDateCarbon->diffInDays($endDateCarbon) + 1; // +1 karena termasuk hari pertama

        // 2. Cek konflik jadwal - Apakah kendaraan sudah dibooking di tanggal yang sama
        $conflictingRental = Rental::where('vehicle_id', $vehicle->id)
            ->whereIn('status', ['pending', 'active']) // Hanya cek rental yang masih aktif
            ->where(function ($query) use ($startDateCarbon, $endDateCarbon) {
                // Cek apakah ada overlap tanggal
                $query->where('end_date', '>=', $startDateCarbon)
                    ->where('start_date', '<=', $endDateCarbon);
            })
            ->first();

        // Jika ada konflik, batalkan booking
        if ($conflictingRental) {
            $conflictStart = $conflictingRental->start_date->format('d/m/Y');
            $conflictEnd = $conflictingRental->end_date->format('d/m/Y');
            
            return back()->with('error', "Maaf, kendaraan ini sudah dibooking/proses dari tanggal {$conflictStart} sampai {$conflictEnd}. Silakan pilih tanggal lain.")->withInput();
        }
        
        // 3. Proses Penyimpanan Data (Menggunakan DB Transaction + Row Locking)
        try {
            DB::beginTransaction();

            // Lock kendaraan untuk mencegah double booking (race condition)
            $vehicleLock = Vehicle::where('id', $vehicle->id)->lockForUpdate()->first();

            // Cek ketersediaan kendaraan di dalam lock
            if ($vehicleLock->status != 'tersedia' && $vehicleLock->status != 'on_hold') {
                DB::rollBack();
                return back()->with('error', 'Kendaraan tidak tersedia saat transaksi diproses. Silakan coba lagi.')->withInput();
            }

            // Generate kode rental unik
            $rentalCode = 'RNT-' . strtoupper(substr($vehicle->plate_number, 0, 3)) . '-' . time();
            
            // Ambil harga per hari dari kendaraan
            $pricePerDay = $vehicleLock->price_per_day ?? $vehicleLock->price ?? 0;

            // Simpan data rental ke database
            $rental = Rental::create([
                'rental_code' => $rentalCode,
                'user_id' => auth()->id(),
                'vehicle_id' => $validated['vehicle_id'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'total_days' => $totalDays,
                'price_per_day' => $pricePerDay,
                'total_price' => $totalDays * $pricePerDay,
                'status' => 'pending', // Status awal pending, menunggu approval admin
                'notes' => $validated['notes'] ?? null,
            ]);
            
            // 4. Update status kendaraan menjadi 'on_hold' (sedang dalam proses booking)
            $vehicleLock->update(['status' => 'on_hold']);

            // ==================================================
            // 5. DISPATCH NOTIFIKASI WHATSAPP (SEBELUM DB::commit)
            // ==================================================
            
            // Kirim notifikasi ke Customer (Konfirmasi Booking Pending)
            SendWhatsAppNotification::dispatch($rental->user, $rental, 'customer_new_order');
            
            // Kirim notifikasi ke Admin (Ada Booking Baru yang Perlu Disetujui)
            $admin = new AdminNotifiable();
            SendWhatsAppNotification::dispatch($admin, $rental, 'admin_new_pending_order'); 

            // 6. Finalisasi Transaksi Database - Commit jika semua berhasil
            DB::commit(); 
            
            // 7. Redirect ke halaman detail rental dengan pesan sukses
            return redirect()->route('customer.rentals.show', $rental)
                ->with('success', 'Booking berhasil! Menunggu konfirmasi Admin.');

        } catch (\Exception $e) {
            // Rollback jika terjadi error
            DB::rollBack();
            
            // Log error untuk debugging
            Log::error('Rental booking failed for User ' . auth()->id() . ': ' . $e->getMessage()); 
            
            return back()->with('error', 'Terjadi kesalahan sistem saat memproses booking. Silakan coba lagi.')->withInput();
        }
    }

    /**
     * Membatalkan rental yang masih berstatus 'pending'
     * 
     * @param Rental $rental - Model Rental yang akan dibatalkan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel(Rental $rental)
    {
        // 1. Validasi kepemilikan - Hanya pemilik rental yang bisa membatalkan
        if ($rental->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki izin untuk membatalkan rental ini.');
        }

        // 2. Validasi status - Hanya rental 'pending' yang boleh dibatalkan
        if ($rental->status !== 'pending') {
            return back()->with('error', "Rental hanya bisa dibatalkan jika statusnya 'pending'. Status saat ini: {$rental->status}.");
        }

        try {
            DB::beginTransaction();
            
            // A. Update status rental menjadi 'cancelled'
            $rental->update(['status' => 'cancelled']);
            
            // B. Kembalikan status kendaraan dari 'on_hold' menjadi 'tersedia'
            // Gunakan lockForUpdate untuk keamanan ekstra saat mengupdate kendaraan
            $vehicleLock = $rental->vehicle()->lockForUpdate()->first();

            if ($vehicleLock->status == 'on_hold') {
                $vehicleLock->update(['status' => 'tersedia']);
            }

            // Commit transaksi
            DB::commit();
            
            return back()->with('success', 'Pemesanan rental berhasil dibatalkan.');

        } catch (\Exception $e) {
            // Rollback jika terjadi error
            DB::rollBack();
            
            // Log error untuk debugging
            Log::error('Customer cancel failed: ' . $e->getMessage()); 
            
            return back()->with('error', 'Gagal membatalkan pemesanan. Silakan coba lagi.');
        }
    }
}