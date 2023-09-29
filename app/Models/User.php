<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class, "type");
    }

    public function hasPermission($permission)
    {
        foreach ($this->role->rolePermissions as $rolePermission) {
            foreach ($rolePermission->permissions as $perm) {
                if ($perm->key === $permission) {
                    return true;
                }
            }
        }

        return false;
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'user_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function housings()
    {
        return $this->hasMany(Housing::class, 'user_id');
    }

    public function brands()
    {
        return $this->hasMany(Brand::class, 'user_id');
    }

    public function housingFavorites()
    {
        return $this->hasMany(HousingFavorite::class);
    }

    public function plan()
    {
        return $this->hasOne(UserPlan::class);
    }

}
