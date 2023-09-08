<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function housings()
    {
        return $this->hasMany(ProjectHousings::class);
    }

    public function images(){
        return $this->hasMany(ProjectImage::class,"project_id","id");
    }

    public function brand(){
        return $this->hasOne(Brand::class,"id","brand_id");
    }

    public function roomInfo(){
        return $this->hasMany(ProjectHousing::class,"project_id","id");
    }

    public function housingType(){
        return $this->hasOne(HousingType::class,"id","housing_type_id");
    }
}