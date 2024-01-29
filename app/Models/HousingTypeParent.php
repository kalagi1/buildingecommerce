<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HousingTypeParent extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function connections()
    {
        return $this->hasMany(HousingTypeParentConnection::class, "parent_id","id");
    }
}
