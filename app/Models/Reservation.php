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
}
