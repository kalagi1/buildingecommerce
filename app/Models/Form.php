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
    public function acity()
    {
        return $this->belongsTo(City::class, 'arsa_il', 'id');
    }

    public function acounty()
    {
        return $this->belongsTo(County::class, 'arsa_ilce', 'key_x');
    }
    public function aneighborhood()
    {
        return $this->belongsTo(Neighborhood::class, 'arsa_mahalle', 'mahalle_key');
    }
}
