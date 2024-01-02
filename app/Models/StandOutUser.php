<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandOutUser extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function project(){
        return $this->hasOne(Project::class,"id","item_id");
    }

    public function dopingPricePaymentWait(){
        return $this->hasOne(DopingOrder::class,"project_id","item_id")->where(function ($query) {
            $query->where('status', '=', 0);
        });
    }

    public function dopingPricePaymentCancel(){
        return $this->hasOne(DopingOrder::class,"project_id","item_id")->where(function ($query) {
            $query->where('status', '=', 2);
        });
    }
}
