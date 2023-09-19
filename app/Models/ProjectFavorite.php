<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectFavorite extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
