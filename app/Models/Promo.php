<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Promo extends Model
{
    use HasFactory;

    protected $fillable = [
        'cover',
        'title',
        'deadline',
        'description',
        'term_condition',
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];
}
