<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpgradeLog extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'plan_id'];
}
