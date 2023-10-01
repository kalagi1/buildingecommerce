<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'project_limit',
        'user_limit',
        'housing_limit',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'subscription_plan_id');
    }

    public function userPlans()
    {
        return $this->hasMany(UserPlan::class);
    }
}
