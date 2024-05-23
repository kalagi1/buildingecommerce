<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseExport extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'bank_name', 'iban', 
        'account_type', 'amount', 'pay_status', 
        'advert_no', 'advert_date'
    ];
}
