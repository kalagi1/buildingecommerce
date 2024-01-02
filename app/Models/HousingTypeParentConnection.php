<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HousingTypeParentConnection extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function housingType(){
        return $this->hasOne(HousingType::class,"id","housing_type_id");
    }
}
