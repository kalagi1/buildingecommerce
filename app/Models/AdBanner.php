<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class AdBanner extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::created(function () {
            Cache::forget('client_view_data');
        });

        static::updated(function () {
            Cache::forget('client_view_data');
        });

        static::deleted(function () {
            Cache::forget('client_view_data');
        });
    }

    protected $guarded = [];
    use HasFactory;
}
