<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectOffers extends Model
{
    use HasFactory;
    public function project(){
        return $this->hasOne(Project::class,"id","project_id");
    }

    public function user(){
        return $this->hasOne(User::class,"id","user_id");
    }
    protected $fillable = [
        'user_id',
        'store_id',
        'project_name',
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