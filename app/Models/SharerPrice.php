<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharerPrice extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function project(){
        return $this->hasOne(Project::class,"id","item_id");
    }

    public function housing(){
        return $this->hasOne(Housing::class,"id","item_id");
    }
}
