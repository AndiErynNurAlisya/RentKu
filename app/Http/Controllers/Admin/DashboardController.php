<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Rental;
use Carbon\Carbon;

/**
 * Controller untuk mengelola Dashboard Admin
 * Menampilkan statistik dan informasi ringkasan sistem rental kendaraan
 */
class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard admin dengan statistik kendaraan dan rental
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Menghitung total semua kendaraan dalam sistem
        $totalVehicles = Vehicle::count();
        
        // Menghitung jumlah kendaraan yang berstatus 'tersedia'
        $availableVehicles = Vehicle::where('status', 'tersedia')->count();
        
        // Menghitung jumlah kendaraan yang berstatus 'disewa'
        $rentedVehicles = Vehicle::where('status', 'disewa')->count();
        
        // Menghitung jumlah rental yang dibuat pada bulan dan tahun berjalan
        // whereMonth: filter berdasarkan bulan saat ini
        // whereYear: filter berdasarkan tahun saat ini
        $monthlyRentals = Rental::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        
        // Mengambil 10 data rental terbaru
        // with(['user', 'vehicle']): eager loading relasi user dan vehicle
        // latest(): mengurutkan berdasarkan data terbaru
        // take(10): membatasi hasil hanya 10 data
        $recentRentals = Rental::with(['user', 'vehicle'])
            ->latest()
            ->take(10)
            ->get();

        // Mengirim semua data statistik ke view dashboard
        return view('admin.dashboard', compact(
            'totalVehicles',
            'availableVehicles',
            'rentedVehicles',
            'monthlyRentals',
            'recentRentals'
        ));
    }
}