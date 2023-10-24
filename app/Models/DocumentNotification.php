<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentNotification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'text', 'item_id', 'readed'];
    public function user()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }
}
