<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Menu extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::created(function () {
            Cache::forget('client_view_data');
        });

        static::updated(function () {
            Cache::forget('client_view_data');
        });

        static::deleted(function () {
            Cache::forget('client_view_data');
        });
    }

    protected $guarded = [];

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public static function getMenuItems()
    {
        $menus = self::whereNull('parent_id')->with(['children' => function($query)
        {
            $query->with(['children' => function($query)
            {
                $query->with('children');
            }]);
        }])->get();

        $menus = $menus->map(function ($menu) {
            if ($menu->children->isEmpty()) {
                unset($menu->children); // Children boş ise çıkar
            }
            return $menu;
        });

        return $menus;
    }
}
