<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Click extends Model
{
    protected $fillable = ['user_id', 'ip_address','collection_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    use HasFactory;
}
