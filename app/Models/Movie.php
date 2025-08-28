<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'duration',
        'age',
        'animation_type',
        'trailer',
        'start_showing',
        'start_selling',
        'synopsis',
        'producer',
        'director',
        'writer',
        'production'
    ];

    public function actors()
    {
        return $this->hasMany(Actor::class);
    }
}
