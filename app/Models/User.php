<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, LogsActivity;

    protected $guarded = [];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'order' => 'integer',
    ];
    protected static $logAttributes = ['name', 'email', 'status']; // Loglanacak alanlar

    // Implementing the required method for Spatie's Activity Log
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('user_activities')
            ->logOnlyDirty() // Only log changes
            ->dontSubmitEmptyLogs() // Avoid empty logs
            ->logAll(); // Logs all attributes
    }

    // Relationships
    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function comments()
    {
        return $this->hasMany(HousingComment::class, 'user_id');
    }

    public function owners()
    {
        return $this->hasMany(HousingComment::class, 'owner_id');
    }

    public function consultans()
    {
        return $this->hasMany(Housing::class, 'consultant_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'type');
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function child()
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    public function hasPermission($permission)
    {
        $role = $this->role;

        if (!$role) {
            return false;
        }

        foreach ($role->rolePermissions as $rolePermission) {
            if ($rolePermission->permissions->contains('key', $permission)) {
                return true;
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
        return $this->hasMany(Project::class, 'user_id')->whereNull('deleted_at');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function town()
    {
        return $this->belongsTo(Town::class, 'city_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'county_id');
    }

    public function neighborhood()
    {
        return $this->belongsTo(Neighborhood::class, 'neighborhood_id');
    }

    public function housings()
    {
        return $this->hasMany(Housing::class, 'user_id');
    }

    public function brands()
    {
        return $this->hasMany(Brand::class, 'user_id');
    }

    public function collections()
    {
        return $this->hasMany(Collection::class, 'user_id');
    }

    public function shares()
    {
        return $this->hasMany(SharerPrice::class, 'user_id');
    }

    public function banners()
    {
        return $this->hasMany(StoreBanner::class, 'user_id')->orderBy('order', 'asc');
    }

    public function housingFavorites()
    {
        return $this->hasMany(HousingFavorite::class);
    }

    public function projectFavorites()
    {
        return $this->hasMany(ProjectFavorite::class);
    }

    public function plan()
    {
        return $this->belongsTo(UserPlan::class, 'user_id');
    }

    public function phoneNumbers()
    {
        return $this->hasMany(PhoneNumber::class);
    }
}
