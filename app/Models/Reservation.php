<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $guarded = [];

    public function housing()
    {
        return $this->belongsTo(Housing::class);
    }
    public function bank()
    {
        return $this->belongsTo(BankAccount::class, 'bank_id');
    }
    public function user()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }

    public function owner()
    {
        return $this->hasOne(User::class, "id", "owner_id");
    }
    public function reference()
    {
        return $this->belongsTo(User::class, 'reference_id');
    }

    public function price()
    {
        return $this->belongsTo(CartPrice::class, 'id', 'reservation_id');
    }
    public function share()
    {
        return $this->belongsTo(SharerPrice::class, 'id', 'reservation_id');
    }


    public function sharer()
    {
        return $this->hasOne(SharerPrice::class, "reservation_id", "id");
    }

    public function cartPrice()
    {
        return $this->hasOne(CartPrice::class, "reservation_id", "id");
    }

    public function cancelRequest()
    {
        return $this->hasOne(CancelRequest::class, "reservation_id", "id")->where('item_type', 1);
    }

    public function refund()
    {
        return $this->hasOne(ReservationRefund::class);
    }
}
