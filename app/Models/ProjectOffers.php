<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectOffers extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'store_id',
        'project_id',
        'room_id',
        'email',
        'offer_price_range',
        'offer_description',
        'approval_status',
        'response_status',
        'sales_status'
    ];
    protected $table = 'project_offers';

}