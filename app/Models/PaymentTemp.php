<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTemp extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(){
        return $this->hasOne(User::class,"id","user_id");
    }

    public $transactionTypes = [
        1 => "İlan süresi uzatma işlemi"
    ];
}
