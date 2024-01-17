<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharerPrice extends Model {
    use HasFactory;

    protected $guarded = [];

    public function cart() {
        return $this->belongsTo( CartOrder::class, 'cart_id', 'id' );
    }

    public function user() {
        return $this->belongsTo( User::class, 'user_id', 'id' );
    }

}
