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
        'time' => 'string',
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

    // (Opsional) relasi orders jika dibutuhkan nanti
    // public function orders(): HasManyThrough
    // {
    //     return $this->hasManyThrough(
    //         Order::class,
    //         Seat::class,
    //         'ticket_id',
    //         'id',
    //         'id',
    //         'order_id'
    //     );
    // }

    public function scopeUpcoming($query)
    {
        return $query->where('date', '>=', today());
    }

    public function scopeToday($query)
    {
        return $query->where('date', today());
    }

    public function scopeAvailable($query)
    {
        return $query->whereHas('seats', function($q) {
            $q->where('status', 'available');
        });
    }

    public function getFormattedTimeAttribute(): string
    {
        return $this->time;
    }

    public function getAvailableSeatsCountAttribute(): int
    {
        return $this->seats()->where('status', 'available')->count();
    }
}
