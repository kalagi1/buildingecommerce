<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Housing extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function housing_type()
    {
        return $this->belongsTo(HousingType::class);
    }
    public function images()
    {
        return $this->hasMany(HousingImages::class);
    }

    public function brand()
    {
        return $this->hasOne(Brand::class, "id", "brand_id");
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'housing_favorites', 'housing_id', 'user_id');
    }
}
