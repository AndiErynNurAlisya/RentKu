<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Controller untuk mengelola data Kendaraan (Vehicle) dari sisi Admin
 * Menangani CRUD (Create, Read, Update, Delete) kendaraan
 */
class VehicleController extends Controller
{
    /**
     * Menampilkan daftar semua kendaraan
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil semua kendaraan, urutkan dari yang terbaru, pagination 10 per halaman
        $vehicles = Vehicle::latest()->paginate(10);
        
        // Kirim data vehicles ke view
        return view('admin.vehicles.index', compact('vehicles'));
    }

    /**
     * Menampilkan form untuk menambah kendaraan baru
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.vehicles.create');
    }

    /**
     * Menyimpan data kendaraan baru ke database
     * 
     * @param Request $request - Request yang berisi data kendaraan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input data kendaraan
        $validated = $request->validate([
            'brand' => 'required|string|max:255', // Merek kendaraan wajib diisi
            'type' => 'required|string|max:255', // Tipe/model kendaraan wajib diisi
            'plate_number' => 'required|string|unique:vehicles,plate_number', // Nomor plat harus unik
            'category' => 'required|in:motor,mobil', // Kategori hanya boleh 'motor' atau 'mobil'
            'price_per_day' => 'required|numeric|min:0', // Harga sewa per hari harus angka positif
            'status' => 'required|in:tersedia,disewa,maintenance', // Status kendaraan
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Gambar optional, max 2MB
            'description' => 'nullable|string', // Deskripsi optional
        ]);

        // Upload gambar jika ada file yang diupload
        if ($request->hasFile('image')) {
            // Simpan gambar ke storage/app/public/vehicles
            $validated['image'] = $request->file('image')->store('vehicles', 'public');
        }

        // Simpan data kendaraan ke database
        Vehicle::create($validated);

        // Redirect ke halaman daftar kendaraan dengan pesan sukses
        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Kendaraan berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail kendaraan tertentu
     * 
     * @param Vehicle $vehicle - Model Vehicle yang akan ditampilkan
     * @return \Illuminate\View\View
     */
    public function show(Vehicle $vehicle)
    {
        return view('admin.vehicles.show', compact('vehicle'));
    }

    /**
     * Menampilkan form untuk mengedit data kendaraan
     * 
     * @param Vehicle $vehicle - Model Vehicle yang akan diedit
     * @return \Illuminate\View\View
     */
    public function edit(Vehicle $vehicle)
    {
        return view('admin.vehicles.edit', compact('vehicle'));
    }

    /**
     * Mengupdate data kendaraan yang sudah ada
     * 
     * @param Request $request - Request yang berisi data update
     * @param Vehicle $vehicle - Model Vehicle yang akan diupdate
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        // Validasi input data kendaraan
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            // Validasi unique kecuali untuk kendaraan yang sedang diedit (menggunakan ID kendaraan ini)
            'plate_number' => 'required|string|unique:vehicles,plate_number,' . $vehicle->id,
            'category' => 'required|in:motor,mobil',
            'price_per_day' => 'required|numeric|min:0',
            'status' => 'required|in:tersedia,disewa,maintenance',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
        ]);

        // Jika ada gambar baru yang diupload
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($vehicle->image) {
                Storage::disk('public')->delete($vehicle->image);
            }
            // Upload gambar baru
            $validated['image'] = $request->file('image')->store('vehicles', 'public');
        }

        // Update data kendaraan di database
        $vehicle->update($validated);

        // Redirect ke halaman daftar kendaraan dengan pesan sukses
        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Kendaraan berhasil diupdate!');
    }

    /**
     * Menghapus data kendaraan dari database
     * 
     * @param Vehicle $vehicle - Model Vehicle yang akan dihapus
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Vehicle $vehicle)
    {
        // Validasi - Cek apakah ada rental aktif atau pending untuk kendaraan ini
        // Kendaraan tidak boleh dihapus jika sedang dalam status sewa
        if ($vehicle->rentals()->whereIn('status', ['pending', 'active'])->exists()) {
            return back()->with('error', 'Tidak dapat menghapus kendaraan yang sedang disewa!');
        }

        // Hapus gambar dari storage jika ada
        if ($vehicle->image) {
            Storage::disk('public')->delete($vehicle->image);
        }

        // Hapus data kendaraan dari database
        $vehicle->delete();

        // Redirect ke halaman daftar kendaraan dengan pesan sukses
        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Kendaraan berhasil dihapus!');
    }
}