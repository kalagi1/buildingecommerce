<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function housing()
    {
        return $this->belongsTo(Housing::class);
    }
}
