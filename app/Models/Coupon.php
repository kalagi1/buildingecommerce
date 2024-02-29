<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function user(){
        return $this->hasOne(User::class,"id","user_id");
    }

    public function housings(){
        return $this->hasMany(CouponItem::class,"coupon_id","id")->where('item_type',2);
    }

    public function projects(){
        return $this->hasMany(CouponItem::class,"coupon_id","id")->where('item_type',1);
    }
}
