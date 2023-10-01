<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model
{
    protected $guarded = [];

    public function permissions()
    {
        return $this->hasMany(Permission::class, "permission_group_id", "id");
    }

    
    public function scopeActive($query)
    {
        $query->where('is_Active', 1);
    }
    use HasFactory;
}
