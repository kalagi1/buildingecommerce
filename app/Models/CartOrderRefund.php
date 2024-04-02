<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartOrderRefund extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'content',
        'terms',
        'user_id',
        'cart_order_id',
        'status',
    ];

    // User modeli ile ilişkiyi tanımlayın
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // CartOrder modeli ile ilişkiyi tanımlayın
    public function cartOrder()
    {
        return $this->belongsTo(CartOrder::class);
    }
}
