<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $guarded = [];

    public function permission_group()
    {
        return $this->belongsTo(PermissionGroup::class);
    }

    public function scopeActive($query)
    {
        $query->where('is_active', 1);
    }
    use HasFactory;
}
