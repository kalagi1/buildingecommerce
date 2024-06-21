<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcceptedBid extends Model
{
    protected $fillable = ['housing_id', 'bid_id', 'expires_at'];

    public function bid()
    {
        return $this->belongsTo(Bid::class);
    }

    public function housing()
    {
        return $this->belongsTo(Housing::class);
    }
}
