<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seats extends Model
{
    // Fillable untuk mass assignment
    protected $fillable = [
        'movie_id',
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
    
    // Relasi ke Movie
    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id');
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
