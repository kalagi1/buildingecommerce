<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CookiePreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'cookie_name',
        'site_domain',
        'description',
        'expiry_duration',
        'cookie_type',
    ];
}

