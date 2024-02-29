<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartPrice extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function cart() {
        return $this->belongsTo( CartOrder::class, 'cart_id', 'id' );
    }
}
