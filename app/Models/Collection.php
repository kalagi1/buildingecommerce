<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $fillable = ['name', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clicks()
    {
        return $this->hasMany(Click::class);
    }
    public function uniqueClicks()
    {
        return $this->clicks()->groupBy(['user_id', 'ip_address'])->selectRaw('COUNT(*) as click_count, user_id, ip_address');
    }
    public function links()
    {
        return $this->hasMany(ShareLink::class);
    }
}
