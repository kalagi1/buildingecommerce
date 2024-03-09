<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectOffers extends Model
{
    use HasFactory;
    public function project(){
        return $this->hasOne(Project::class,"id","project_id");
    }

    public function user(){
        return $this->hasOne(User::class,"id","user_id");
    }

    public function city()
    {
        return $this->hasOne(City::class, "id", "city_id");
    }

    public function town()
    {
        return $this->belongsTo(Town::class, 'city_id', 'sehir_key');
    }

    public function district()
    {
        return $this->belongsTo(District::class, "county_id", 'ilce_key');
    }
    protected $guarded = [];
    protected $table = 'project_offers';

}