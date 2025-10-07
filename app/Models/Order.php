<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'seat_id', 'payment'];

    protected $casts = [
        'payment' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function seat()
    {
        return $this->belongsTo(Seats::class);
    }

    // Ambil tiket lewat seat
    public function ticket()
    {
        return $this->seat ? $this->seat->ticket : null;
    }

    public function scopePending($query)
    {
        return $query->where('payment', 'pending');
    }

    public function scopePaid($query)
    {
        return $query->where('payment', 'paid');
    }

    public function scopeCancelled($query)
    {
        return $query->where('payment', 'cancelled');
    }

    public function canBeCancelled(): bool
    {
        return $this->payment === 'pending';
    }

    public function getTotalPriceAttribute(): float
    {
        return $this->seat && $this->seat->ticket
            ? $this->seat->ticket->price
            : 0;
    }
}
