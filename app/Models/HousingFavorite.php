<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HousingFavorite extends Model
{
    use HasFactory;
    public function housing()
    {
        return $this->belongsTo(Housing::class);
    }
}
