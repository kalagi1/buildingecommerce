<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HousingStatus extends Model
{
    use HasFactory;
    protected $table = 'housing_status';
    public $timestamps = false;
    protected $guarded = [];
}