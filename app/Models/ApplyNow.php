<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplyNow extends Model
{
    protected $guarded = [];
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    use HasFactory;
}
