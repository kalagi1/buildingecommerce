<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'project_id', 'housing_id', 'type', 'discount_amount', 'start_date', 'end_date', 'project_housings'];

    function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
