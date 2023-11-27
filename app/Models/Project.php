<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function housings()
    {
        return $this->hasMany(ProjectHousings::class);
    }

    
    public function images()
    {
        return $this->hasMany(ProjectImage::class, "project_id", "id");
    }

    public function brand()
    {
        return $this->hasOne(Brand::class, "id", "brand_id");
    }
    public function user()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }

    public function roomInfo()
    {
        return $this->hasMany(ProjectHousing::class, "project_id", "id");
    }

    public function roomInfoKeyBy()
    {
        return $this->hasMany(ProjectHousing::class, "project_id", "id")->keyBy('name');
    }

    public function housingType()
    {
        return $this->hasOne(HousingType::class, "id", "housing_type_id");
    }

    public function housingTypes()
    {
        return $this->hasMany(ProjectHousingType::class, "project_id", "id");
    }
    
    public static function listForMarketing()
    {

        return self::leftJoin('marketed_projects', 'marketed_projects.project_id', '=', 'projects.id')
            ->orderByRaw('CASE WHEN marketed_projects.sort_order IS NULL THEN 1 ELSE 0 END, marketed_projects.sort_order')
            ->orderBy('projects.view_count', 'DESC')
            ->get();
    }

    public function city()
    {
        return $this->hasOne(City::class, "id", "city_id");
    }

    public function county()
    {
        return $this->hasOne(District::class, "ilce_key", "county_id");
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'project_favorites', 'project_id', 'user_id');
    }

    public function housingStatus(){
        return $this->hasMany(ProjectHousingType::class,"project_id","id");
    }

    public function housingStatusIds(){
        return $this->hasMany(ProjectHousingType::class,"project_id","id")->select(DB::raw('housing_type_id as id'));
    }

    public function rejectedLog(){
        return $this->hasOne(Log::class,'item_id','id')->where('item_type',1)->where('is_rejected',1)->orderByDesc('created_at');
    }

    public function listItemValues(){
        return $this->hasOne(ProjectListItem::class,"housing_type_id",'housing_type_id');
    }

    public function dopingOrder(){
        return $this->hasMany(DopingOrder::class,"project_id","id");
    }

    public function confirmDopingOrder(){
        return $this->hasOne(DopingOrder::class,"project_id","id")->where('status',0);
    }

    public function blocks(){
        return $this->hasMany(Block::class,"project_id","id");
    }
}
