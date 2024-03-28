<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartOrder extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function reference()
    {
        return $this->belongsTo(User::class, 'reference_id');
    }


    public function isReference()
    {
        return $this->belongsTo(User::class, 'is_reference');
    }

    public function share()
    {
        return $this->belongsTo(SharerPrice::class, 'id', 'cart_id');
    }


    public function price()
    {
        return $this->belongsTo(CartPrice::class, 'id', 'cart_id');
    }

    public function bank()
    {
        return $this->belongsTo(BankAccount::class, 'bank_id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, "id", "order_id");
    }

    public function coupon(){
        return $this->hasOne(UseCoupon::class,"order_id","id");
    }

    public function store()
    {
        return $this->belongsTo(User::class, 'store_id');
    }
}
