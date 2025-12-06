<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

/**
 * Controller untuk mengelola data pelanggan (customer)
 * Menangani tampilan daftar pelanggan dan detail pelanggan
 */
class CustomerController extends Controller
{
    /**
     * Menampilkan daftar semua pelanggan
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil data user dengan role 'customer'
        // withCount('rentals') menghitung jumlah rental yang dimiliki
        // latest() mengurutkan berdasarkan data terbaru
        // paginate(10) membagi data menjadi 10 per halaman
        $customers = User::where('role', 'customer')
            ->withCount('rentals')
            ->latest()
            ->paginate(10);

        // Mengirim data customers ke view
        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Menampilkan detail pelanggan tertentu
     * 
     * @param User $customer - Model User yang akan ditampilkan
     * @return \Illuminate\View\View
     */
    public function show(User $customer)
    {
        // Validasi: memastikan user yang diakses adalah customer
        // Jika bukan customer, tampilkan error 404
        if ($customer->role != 'customer') {
            abort(404);
        }

        // Load relasi rentals beserta vehicle-nya untuk menampilkan riwayat rental
        // Eager loading untuk menghindari N+1 query problem
        $customer->load(['rentals.vehicle']);

        // Mengirim data customer ke view detail
        return view('admin.customers.show', compact('customer'));
    }
}