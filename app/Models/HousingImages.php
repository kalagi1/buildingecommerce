<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HousingImages extends Model
{
    protected $fillable = ['imagepath', 'housing_id'];
    public $timestamps = false;
    use HasFactory;
    public function housing()
    {
        return $this->belongsTo(Housing::class);
    }
}