<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VehicleController as AdminVehicleController;
use App\Http\Controllers\Admin\RentalController as AdminRentalController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\VehicleController as CustomerVehicleController;
use App\Http\Controllers\Customer\RentalController as CustomerRentalController;
use App\Http\Controllers\Customer\ProfileController as CustomerProfileController;
use Illuminate\Support\Facades\Route;

// Root route - Redirect ke dashboard jika sudah login, jika belum redirect ke login
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isAdmin() 
            ? redirect()->route('admin.dashboard')
            : redirect()->route('customer.home');
    }
    return redirect()->route('login');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Vehicles
    Route::resource('vehicles', AdminVehicleController::class);
    
    // Rentals
    Route::get('rentals', [AdminRentalController::class, 'index'])->name('rentals.index');
    Route::get('rentals/{rental}', [AdminRentalController::class, 'show'])->name('rentals.show');
    Route::post('rentals/{rental}/approve', [AdminRentalController::class, 'approve'])->name('rentals.approve');
    Route::post('rentals/{rental}/complete', [AdminRentalController::class, 'complete'])->name('rentals.complete');
    Route::post('rentals/{rental}/cancel', [AdminRentalController::class, 'cancel'])->name('rentals.cancel');
    Route::post('rentals/{rental}/damages', [AdminRentalController::class, 'addDamage'])->name('rentals.damages');
    
    // Customers
    Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
});

// Customer Routes
Route::middleware(['auth', 'customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // Vehicles
    Route::get('vehicles/{vehicle}', [CustomerVehicleController::class, 'show'])->name('vehicles.show');
    
    // Rentals
    Route::get('rentals', [CustomerRentalController::class, 'index'])->name('rentals.index');
    Route::get('rentals/create/{vehicle}', [CustomerRentalController::class, 'create'])->name('rentals.create');
    Route::post('rentals', [CustomerRentalController::class, 'store'])->name('rentals.store');
    Route::get('rentals/{rental}', [CustomerRentalController::class, 'show'])->name('rentals.show');
    Route::post('rentals/{rental}/cancel', [CustomerRentalController::class, 'cancel'])->name('rentals.cancel');

    // Profile
    Route::get('profile', [CustomerProfileController::class, 'index'])->name('profile');
    Route::put('profile', [CustomerProfileController::class, 'update'])->name('profile.update');
});

require __DIR__.'/auth.php';