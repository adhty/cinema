<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seats extends Model
{
    protected $fillable = ['ticket_id', 'number', 'status'];

    protected $casts = [
        'status' => 'string',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function order()
    {
        return $this->hasOne(Order::class, 'seat_id');
    }

    // Check if seat is available
    public function isAvailable()
    {
        return $this->status === 'available' && !$this->order;
    }

    // Mark seat as booked
    public function markAsBooked()
    {
        $this->update(['status' => 'booked']);
    }

    // Mark seat as available
    public function markAsAvailable()
    {
        $this->update(['status' => 'available']);
    }

    // Scope for available seats
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    // Scope for booked seats
    public function scopeBooked($query)
    {
        return $query->where('status', 'booked');
    }
}
