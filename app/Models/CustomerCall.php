<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCall extends Model
{
    use HasFactory;
    protected $table = 'customer_calls';

    protected $guarded = [];

}