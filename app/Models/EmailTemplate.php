<?php

namespace App\Models;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{

    protected $guarded = [];
    use HasFactory;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($template) {
            $template->slug = Str::slug($template->name);
        });
    }
}
