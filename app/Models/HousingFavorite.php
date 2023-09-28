<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HousingFavorite extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function housing()
    {
        return $this->belongsTo(Housing::class);
    }

    // Housing.php modeli içinde
    public function users()
    {
        return $this->belongsTo(User::class);
    }

}
