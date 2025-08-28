<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Cinema extends Model
{
    protected $fillable = [
        'name',
        'address',
        'city_id',
        'image'
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function studios()
    {
        return $this->hasMany(Studio::class);
    }

    // Accessor untuk gambar
    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::url($this->image) : asset('test-image.jpg');
    }
}
