<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $guarded = [];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    
    public function user()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }

    use HasFactory;
}
