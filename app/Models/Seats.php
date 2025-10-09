<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seats extends Model
{
    protected $fillable = [
        'number',
        'status',
        'ticket_id',
    ];

    protected $casts = [
        'status' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi ke Ticket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    // Relasi ke Orders
    public function order
    ()
    {
        return $this->hasMany(Order::class, 'seat_id');
    }

    // Relasi ke Movie lewat Ticket
    public function movie()
    {
        return $this->hasOneThrough(
            Movie::class,
            Ticket::class,
            'id',         // key di tickets
            'id',         // key di movies
            'ticket_id',  // key di seats
            'movie_id'    // key di tickets
        );
    }

    // Scope helper
    public function scopeBooked($query)
    {
        return $query->where('status', 'booked');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    // Helper method
    public function isBooked(): bool
    {
        return $this->status === 'booked';
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }
}
