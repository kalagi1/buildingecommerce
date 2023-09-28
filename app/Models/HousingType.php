<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HousingType extends Model
{
    protected $fillable = ['title', 'slug', 'active','form_json'];
    use HasFactory;
    public function Housings()
    {
        return $this->hasMany(Housing::class);
    }
}