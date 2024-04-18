<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'old_phone_number',
        'new_phone_number',
        'image_path',
        'file_name',
        'phone_number_changed',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
