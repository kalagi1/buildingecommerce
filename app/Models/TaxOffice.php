<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxOffice extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'taxOfficeCity');
    }
}
