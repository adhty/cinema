<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    protected $fillable = ['movie_id', 'name', 'character_name', 'photo'];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}

