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

    public function housingStatus(){
        return $this->hasMany(HousingStatusConnection::class,"housing_id","id");
    }

    public function brand()
    {
        return $this->hasOne(Brand::class, "id", "brand_id");
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'housing_favorites', 'housing_id', 'user_id');
    }
    public function city()
    {
        return $this->hasOne(City::class, "id", "city_id");
    }

    public function county()
    {
        return $this->hasOne(County::class, "id", "county_id");
    }

    public function rejectedLog(){
        return $this->hasOne(Log::class,'item_id','id')->where('item_type',2)->where('is_rejected',1)->orderByDesc('created_at');
    }
}
