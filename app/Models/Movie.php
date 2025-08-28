<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'duration',
        'age',
        'animation_type',
        'trailer',
        'start_showing',
        'start_selling',
        'synopsis',
        'producer',
        'director',
        'writer',
        'production'
    ];

    protected $casts = [
        'start_showing' => 'date',
        'start_selling' => 'date',
        'duration' => 'integer',
        'age' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function actors(): HasMany
    {
        return $this->hasMany(Actor::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    // Scope untuk film yang sedang tayang
    public function scopeNowShowing($query)
    {
        return $query->where('start_showing', '<=', now())
                    ->whereDate('start_showing', '>=', now()->subMonths(3));
    }

    // Scope untuk film yang akan tayang
    public function scopeComingSoon($query)
    {
        return $query->where('start_showing', '>', now());
    }

    // Scope untuk film yang sudah bisa dijual tiketnya
    public function scopeAvailableForSale($query)
    {
        return $query->where('start_selling', '<=', now());
    }

    // Accessor untuk durasi dalam format jam:menit
    public function getDurationFormattedAttribute(): string
    {
        $hours = intval($this->duration / 60);
        $minutes = $this->duration % 60;

        if ($hours > 0) {
            return "{$hours}h {$minutes}m";
        }

        return "{$minutes}m";
    }

    // Accessor untuk rating usia
    public function getAgeRatingAttribute(): string
    {
        return $this->age === 0 ? 'SU' : "{$this->age}+";
    }
}
