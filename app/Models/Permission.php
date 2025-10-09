<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_id',
        'menu_name',
        'can_view',
        'can_create',
        'can_update',
        'can_delete',
        'can_approve',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
