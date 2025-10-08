<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Studio extends Model
{
    use HasFactory;

        protected $fillable = ['cinema_id', 'name', 'type', 'weekday_price', 'friday_price', 'weekend_price'];


    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function cinema(): BelongsTo
    {
        return $this->belongsTo(Cinema::class);
    }

    public function cinemaPrice(): HasOne
    {
        return $this->hasOne(CinemaPrice::class, 'studio_id');
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function seats(): HasMany
    {
        return $this->hasManyThrough(Seats::class, Ticket::class, 'studio_id', 'ticket_id');
    }

    // Scope untuk filter berdasarkan tipe
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Scope untuk studio dengan harga
    public function scopeWithPrice($query)
    {
        return $query->has('cinemaPrice');
    }

    // Accessor untuk label tipe studio
    public function getTypeLabelAttribute(): string
    {
        $labels = [
            'xxi' => 'Cinema XXI',
            'premiere' => 'The Premiere',
            'imax' => 'IMAX'
        ];

        return $labels[$this->type] ?? strtoupper($this->type);
    }
}
