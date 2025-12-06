<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Rental;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Hanya tampilkan kendaraan yang secara default 'tersedia'
        $query = Vehicle::where('status', 'tersedia'); 

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        // Logika Pencarian Berdasarkan Tanggal (Mengecualikan yang Overlap)
        if ($request->filled(['start_date', 'end_date'])) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            // Dapatkan ID kendaraan yang BERKONFLIK (pending atau active)
            $conflictingVehicleIds = Rental::whereIn('status', ['active', 'pending'])
                ->where(function ($q) use ($startDate, $endDate) {
                    // Logic Overlap: End Lama >= Start Baru AND Start Lama <= End Baru
                    $q->where('end_date', '>=', $startDate)
                      ->where('start_date', '<=', $endDate);
                })
                ->pluck('vehicle_id'); 

            // Kecualikan kendaraan yang bentrok
            $query->whereNotIn('id', $conflictingVehicleIds);
        }

        $vehicles = $query->latest()->get();

        return view('customer.home', compact('vehicles'));
    }
}