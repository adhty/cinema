<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'movie_id',
        'cinema_id',
        'studio_id',
        'show_date',
        'show_time',
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }

    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }
}
