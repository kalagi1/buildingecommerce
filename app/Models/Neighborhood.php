<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Neighborhood extends Model
{
    protected $guarded = [];
    use HasFactory;
    protected $primaryKey = 'mahalle_id';
    public $incrementing = false;

    public function housings()
{
    return $this->hasMany(Housing::class, 'neighborhood_id', 'mahalle_id');
}
}
