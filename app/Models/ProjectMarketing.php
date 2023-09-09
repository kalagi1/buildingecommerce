<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMarketing extends Model
{
    protected $table = 'projects_marketing';
    protected $guarded = [];
    public $timestamps = false;
    protected $primaryKey = 'sort_order';
    public $incrementing = false;
    use HasFactory;
}