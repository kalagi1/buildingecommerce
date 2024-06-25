<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function project(){
        return $this->hasOne(Project::class,"id","interested_project");
    }

    public function meets(){
        return $this->hasMany(Meet::class,"customer_id","id");
    }
}
