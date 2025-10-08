<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seats extends Model
{
    // Fillable untuk mass assignment
    protected $fillable = [
        'number',
        'status',
        'ticket_id',
        'order_id',
    ];

    // Casts
    protected $casts = [
        'status' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    // Relasi ke Movie melalui Ticket
    public function movie()
    {
        return $this->hasOneThrough(
            Movie::class,        // Final target model
            Ticket::class,       // Intermediate model
            'ticket_id',         // Foreign key on seats table (to tickets)
            'id',                // Foreign key on movies table
            'id',                // Local key on seats table
            'movie_id'          // Foreign key on tickets table (to movies)
        );
    }

    // Relasi ke Order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // Relasi ke Ticket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function scopeBooked($query)
    {
        return $query->where('status', 'booked');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function isBooked(): bool
    {
        return $this->status === 'booked';
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }
}
