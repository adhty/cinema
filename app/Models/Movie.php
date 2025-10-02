<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    // 🎭 Relasi aktor (many-to-many)
    public function actors(): BelongsToMany
    {
        return $this->belongsToMany(Actor::class, 'actor_movie', 'movie_id', 'actor_id');
    }

    // 🎟️ Relasi tiket (one-to-many)
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'movie_id');
    }

    // 🎦 Relasi cinema 
    public function cinemas(): BelongsToMany
    {
        return $this->belongsToMany(Cinema::class, 'cinema_movie', 'movie_id', 'cinema_id');
    }



    // 📌 Scope film yang sedang tayang
    public function scopeNowShowing($query)
    {
        return $query->where('start_showing', '<=', now())
            ->whereDate('start_showing', '>=', now()->subMonths(3));
    }

    // 📌 Scope film yang akan tayang
    public function scopeComingSoon($query)
    {
        return $query->where('start_showing', '>', now());
    }

    // 📌 Scope film yang sudah bisa dijual tiketnya
    public function scopeAvailableForSale($query)
    {
        return $query->where('start_selling', '<=', now());
    }

    // ⏳ Accessor durasi dalam format jam:menit
    public function getDurationFormattedAttribute(): string
    {
        $hours = intval($this->duration / 60);
        $minutes = $this->duration % 60;

        return $hours > 0 ? "{$hours}h {$minutes}m" : "{$minutes}m";
    }

    // 🎬 Accessor rating usia
    public function getAgeRatingAttribute(): string
    {
        return $this->age === 0 ? 'SU' : "{$this->age}+";
    }
}
