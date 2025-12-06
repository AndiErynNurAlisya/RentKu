<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate; // Digunakan untuk mendefinisikan Gate/Aktor

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        
        // Contoh untuk sistem rental Anda:
        // Kebijakan untuk model Rental, untuk menentukan siapa yang bisa 'view', 'update', 'delete', dll.
        // \App\Models\Rental::class => \App\Policies\RentalPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        // Panggil method induk untuk mendaftarkan kebijakan secara otomatis
        $this->registerPolicies(); 

        // ----------------------------------------------------
        // Contoh Mendefinisikan Gate (Aktor/Permission Sederhana)
        // ----------------------------------------------------
        
        // Gate untuk Hak Akses Admin
        Gate::define('manage-rentals', function ($user) {
            // Asumsi: Anda memiliki kolom is_admin di tabel users
            return $user->is_admin; 
        });

        // Gate untuk Hak Akses Customer (Bisa mengelola rental miliknya sendiri)
        Gate::define('access-customer-portal', function ($user) {
            return !$user->is_admin;
        });
    }
}