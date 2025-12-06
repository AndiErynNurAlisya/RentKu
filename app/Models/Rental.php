<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $fillable = [
        'rental_code',
        'user_id',
        'vehicle_id',
        'start_date',
        'end_date',
        'actual_return_date',
        'total_days',
        'price_per_day',
        'total_price',
        'deposit',
        'status',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'actual_return_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function damages()
    {
        return $this->hasMany(Damage::class);
    }
}