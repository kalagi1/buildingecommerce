<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'ilce_id';
    public $incrementing = false;
    use HasFactory;
}
