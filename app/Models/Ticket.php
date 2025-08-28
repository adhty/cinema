<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'movie_id', 'studio_id', 'city_id', 'cinema_id', 'date', 'time', 'price'
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i',
        'price' => 'decimal:2',
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }

    public function seats()
    {
        return $this->hasMany(Seats::class);
    }

    // Scope for upcoming shows
    public function scopeUpcoming($query)
    {
        return $query->where('date', '>=', today());
    }

    // Scope for today's shows
    public function scopeToday($query)
    {
        return $query->where('date', today());
    }
}
