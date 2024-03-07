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
    protected $guarded = [];
    protected $table = 'project_offers';

}