<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    use HasFactory;

    protected $fillable = [
        'cinema_id',
        'name',
    ];

    public function cinema() {
        return $this->belongsTo(Cinema::class);
    }

    // Tiered pricing relation (one price set per studio)
    public function cinemaPrice()
    {
        return $this->hasOne(CinemaPrice::class, 'studio_id');
    }

    // Alias to match potential plural accessors
    public function cinema_prices()
    {
        return $this->hasOne(CinemaPrice::class, 'studio_id');
    }
}
