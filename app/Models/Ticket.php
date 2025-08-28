<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Ticket extends Model
{
    protected $fillable = [
        'movie_id', 'studio_id', 'city_id', 'cinema_id', 'date', 'time', 'price'
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i',
        'price' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    public function studio(): BelongsTo
    {
        return $this->belongsTo(Studio::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function cinema(): BelongsTo
    {
        return $this->belongsTo(Cinema::class);
    }

    public function seats(): HasMany
    {
        return $this->hasMany(Seats::class);
    }

    public function orders(): HasManyThrough
    {
        return $this->hasManyThrough(Order::class, Seats::class, 'ticket_id', 'seat_id');
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

    // Scope for available tickets (with available seats)
    public function scopeAvailable($query)
    {
        return $query->whereHas('seats', function($q) {
            $q->where('status', 'available');
        });
    }

    // Accessor untuk format waktu yang lebih readable
    public function getFormattedTimeAttribute(): string
    {
        return $this->time->format('H:i');
    }

    // Accessor untuk menghitung seat yang tersedia
    public function getAvailableSeatsCountAttribute(): int
    {
        return $this->seats()->where('status', 'available')->count();
    }
}
