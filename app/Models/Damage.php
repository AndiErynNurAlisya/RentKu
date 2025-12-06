<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Damage extends Model
{
    protected $fillable = [
        'rental_id',
        'description',
        'damage_cost',
        'image',
        'reported_at',
    ];

    protected $casts = [
        'reported_at' => 'datetime',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }
}