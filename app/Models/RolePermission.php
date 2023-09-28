<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    protected $guarded = [];

    public function permissions()
    {
        return $this->hasMany(Permission::class, "id", "permission_id");
    }

    public function roles()
    {
        return $this->hasMany(Role::class, "id", "role_id");
    }

    use HasFactory;
}
