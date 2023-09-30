<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function projects()
    {
        return $this->hasMany(Project::class, "brand_id", "id")->orderBy('order');
    }
    public function user()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }
}
