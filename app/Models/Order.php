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

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function seats()
    {
        return $this->belongsToMany(Seats::class, 'order_seat', 'order_id', 'seat_id')
            ->withTimestamps();
    }



    // Opsional → bisa diakses lewat $order->seat->ticket
    public function ticket()
    {
        return $this->hasOneThrough(
            Ticket::class,
            Seats::class,
            'id',        // Primary key seats
            'id',        // Primary key tickets
            'seat_id',   // FK di orders
            'ticket_id'  // FK di seats
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
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

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */
    public function canBeCancelled()
    {
        return $this->payment === 'pending';
    }

    public function getTotalPriceAttribute()
    {
        return $this->seat->ticket->price ?? 0;
    }
}
