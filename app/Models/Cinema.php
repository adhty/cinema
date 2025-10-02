<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Facades\Storage;

class Cinema extends Model
{
    protected $fillable = [
        'name',
        'address',
        'city_id',
        'image'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = ['image_url'];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function studios(): HasMany
    {
        return $this->hasMany(Studio::class);
    }

    public function movies()
    {
        return $this->hasMany(Movie::class);
    }

    public function tickets(): HasManyThrough
    {
        return $this->hasManyThrough(Ticket::class, Studio::class);
    }

    // Accessor untuk gambar
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::url($this->image) : null;
    }

    // Scope untuk filter berdasarkan kota
    public function scopeInCity($query, $cityId)
    {
        return $query->where('city_id', $cityId);
    }

    // Scope untuk cinema yang memiliki studio
    public function scopeWithStudios($query)
    {
        return $query->has('studios');
    }
}
