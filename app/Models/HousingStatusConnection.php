<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HousingStatusConnection extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function housingStatus(){
        return $this->hasOne(HousingStatus::class,"id","housing_status_id");
    }
}
