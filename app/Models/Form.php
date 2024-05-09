<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function city()
    {
        return $this->belongsTo(City::class, 'sehir', 'id');
    }

    public function county()
    {
        return $this->belongsTo(County::class, 'ilce', 'key_x');
    }
}
