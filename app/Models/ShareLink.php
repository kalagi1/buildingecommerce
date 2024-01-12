<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShareLink extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function project(){
        return $this->hasOne(Project::class,"id","item_id");
    }

    public function projectHousingData($projectId){
        return $this->hasMany(ProjectHousing::class, 'room_order', 'room_order')->where('project_id',$projectId)->get();
    }

    public function housing(){
        return $this->hasOne(Housing::class,"id","item_id");
    }

}
