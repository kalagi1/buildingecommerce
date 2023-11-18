<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DopingOrder extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function standOut(){
        return $this->hasOne(StandOutUser::class,"id","stand_out_id");
    }

    public function user(){
        return $this->hasOne(User::class,"id","user_id");
    }

    public function bank(){
        return $this->hasOne(BankAccount::class,"id","bank_id");
    }
}
