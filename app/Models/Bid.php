<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    protected $fillable = ['user_id', 'housing_id', 'bid_amount','status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function housing()
    {
        return $this->belongsTo(Housing::class);
    }

    public function acceptedBid()
    {
        return $this->hasOne(AcceptedBid::class);
    }
}
