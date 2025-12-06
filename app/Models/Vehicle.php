<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'brand',
        'type',
        'plate_number',
        'category',
        'price_per_day',
        'status',
        'image',
        'description',
    ];

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}