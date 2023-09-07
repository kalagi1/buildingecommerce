<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMarketing extends Model
{
    protected $table = 'projects_marketing';
    protected $fillable = ['order', 'price'];
    public $timestamps = false;
    use HasFactory;
}