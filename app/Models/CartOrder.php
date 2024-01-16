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

    public function share()
    {
        return $this->belongsTo(SharerPrice::class, 'id', 'cart_id');
    }

    public function bank()
    {
        return $this->belongsTo(BankAccount::class, 'bank_id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, "id", "order_id");
    }
}
