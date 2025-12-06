<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Controller untuk mengelola Profil Customer
 * Menangani tampilan dan update data profil pengguna yang login
 */
class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil customer
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil data user yang sedang login
        $user = auth()->user();
        
        // Kirim data user ke view profil
        return view('customer.profile', compact('user'));
    }

    /**
     * Mengupdate data profil customer
     * 
     * @param Request $request - Request yang berisi data update profil
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // Ambil data user yang sedang login
        $user = auth()->user();

        // Validasi input data profil
        $validated = $request->validate([
            'name' => 'required|string|max:255', // Nama lengkap wajib diisi
            'phone' => 'required|string|max:20', // Nomor telepon wajib diisi
            'address' => 'required|string', // Alamat lengkap wajib diisi
            // Nomor identitas (KTP/SIM) harus unik, kecuali untuk user yang sedang diedit
            'identity_number' => 'required|string|unique:users,identity_number,' . $user->id,
            'driver_license' => 'required|string', // Nomor SIM wajib diisi
        ]);

        // Update data user di database dengan data yang sudah divalidasi
        $user->update($validated);

        // Redirect kembali ke halaman profil dengan pesan sukses
        return back()->with('success', 'Profil berhasil diupdate!');
    }
}