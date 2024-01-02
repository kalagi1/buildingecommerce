<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HousingComment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'housing_id', 'comment', 'rate', 'images', 'status','owner_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function housing()
    {
        return $this->belongsTo(Housing::class, 'housing_id');
    }
}
