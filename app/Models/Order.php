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
        return $this->belongsTo(Seats::class, 'seat_id');
    }

    // Get ticket through seat relationship
    public function ticket()
    {
        return $this->hasOneThrough(Ticket::class, Seats::class, 'id', 'id', 'seat_id', 'ticket_id');
    }

    // Scope for pending orders
    public function scopePending($query)
    {
        return $query->where('payment', 'pending');
    }

    // Scope for paid orders
    public function scopePaid($query)
    {
        return $query->where('payment', 'paid');
    }

    // Scope for cancelled orders
    public function scopeCancelled($query)
    {
        return $query->where('payment', 'cancelled');
    }

    // Check if order can be cancelled
    public function canBeCancelled()
    {
        return $this->payment === 'pending';
    }

    // Get total price from seat's ticket
    public function getTotalPriceAttribute()
    {
        return $this->seat->ticket->price ?? 0;
    }
}
