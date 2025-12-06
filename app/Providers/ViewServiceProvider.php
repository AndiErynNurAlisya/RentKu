<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // Import Facade View
use App\Models\Rental; // Import Model Rental

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // ✅ IMPLEMENTASI VIEW COMPOSER UNTUK DASHBOARD ADMIN
        
        // Komposisi data ini akan dijalankan setiap kali view tertentu dimuat.
        View::composer(['admin.layouts.app', 'admin.dashboard'], function ($view) {
            
            // Hitung jumlah rental yang masih 'pending'
            $pendingRentalsCount = Rental::where('status', 'pending')->count();
            
            // Kirim variabel ini ke view yang ditentukan
            $view->with('pendingRentalsCount', $pendingRentalsCount);
        });
        
        // Catatan: 'admin.layouts.app' adalah asumsi untuk layout utama/sidebar Admin Anda. 
        // Sesuaikan dengan nama view layout utama yang Anda gunakan.
    }
}