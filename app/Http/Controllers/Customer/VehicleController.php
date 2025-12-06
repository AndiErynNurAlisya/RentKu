<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;

/**
 * Controller untuk mengelola tampilan Kendaraan dari sisi Customer
 * Menangani tampilan detail kendaraan yang tersedia untuk disewa
 */
class VehicleController extends Controller
{
    /**
     * Menampilkan detail kendaraan tertentu
     * Customer dapat melihat informasi lengkap kendaraan sebelum melakukan booking
     * 
     * @param Vehicle $vehicle - Model Vehicle yang akan ditampilkan
     * @return \Illuminate\View\View
     */
    public function show(Vehicle $vehicle)
    {
        // Kirim data vehicle ke view detail kendaraan untuk customer
        return view('customer.vehicles.show', compact('vehicle'));
    }
}