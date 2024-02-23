<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NeighborView extends Model {
    protected $guarded = [];
    use HasFactory;

    public function user() {
        return $this->hasOne( User::class, 'id', 'user_id' );
    }

    public function owner() {
        return $this->hasOne( User::class, 'id', 'owner_id' );
    }

    public function project() {
        return $this->hasOne( Project::class, 'id', 'project_id' );
    }

}
