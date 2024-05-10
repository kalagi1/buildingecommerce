<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];

    public function rolePermissions()
    {
        return $this->hasMany(RolePermission::class, "role_id", "id");
    }

    
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    use HasFactory;
}
