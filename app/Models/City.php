<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class City extends Model
{
    protected $fillable = ['name'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        ];

    public function cinemas(): HasMany
    {
        return $this->hasMany(Cinema::class);
    }

    public function studios(): HasManyThrough
    {
        return $this->hasManyThrough(Studio::class, Cinema::class);
    }

    public function tickets(): HasManyThrough
    {
        return $this->hasManyThrough(Ticket::class, Cinema::class, 'city_id', 'cinema_id');
    }

    // Scope untuk kota yang memiliki cinema
    public function scopeWithCinemas($query)
    {
        return $query->has('cinemas');
    }

    // Scope untuk pencarian berdasarkan nama
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%");
    }
}

