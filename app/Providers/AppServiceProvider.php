<?php

namespace App\Providers;

use App\Models\FooterLink;
use App\Models\Menu;
use App\Models\SocialMediaIcon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

// Kullanıcı modelinizin namespace'ini ekleyin

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot()
    {

        View::composer("client*", function ($view) {
            $footerLinks = FooterLink::all();
            $socialMediaIcons = SocialMediaIcon::all();
            $menu = Menu::getMenuItems();
            $widgetGroups = FooterLink::select('widget')
                ->distinct()
                ->get();
            $view->with('footerLinks', $footerLinks);
            $view->with('widgetGroups', $widgetGroups);
            $view->with("socialMediaIcons", $socialMediaIcons);
            $view->with("menu", $menu);
        });

        View::composer(["admin*"], function ($view) {

            if (Auth::check()) {
                $user = User::with('role.rolePermissions.permissions')->find(Auth::user()->id);
                if ($user) {
                    $permissions = $user->role->rolePermissions->flatMap(function ($rolePermission) {
                        return $rolePermission->permissions->pluck('key');
                    })->unique()->toArray();

                    $jsonFilePath = base_path('admin_menu.json');

                    // JSON dosyasının varlığını kontrol etmek için File sınıfını kullanabilirsiniz
                    if (File::exists($jsonFilePath)) {
                        $menuJson = File::get($jsonFilePath); // JSON dosyasını oku
                        $menuData = json_decode($menuJson, true); // JSON verisini bir diziye çevir

                        // Her menü öğesinin izinlerini kontrol et ve "visible" değerini ayarla
                        foreach ($menuData as &$menuItem) {
                            if (in_array($menuItem['key'], $permissions)) {
                                $menuItem['visible'] = true;
                            } else {
                                $menuItem['visible'] = false;
                            }

                            // Alt menü öğelerini kontrol et
                            if (isset($menuItem['subMenu'])) {
                                foreach ($menuItem['subMenu'] as &$subMenuItem) {
                                    if (in_array($subMenuItem['key'], $permissions)) {
                                        $subMenuItem['visible'] = true;
                                    } else {
                                        $subMenuItem['visible'] = false;
                                    }
                                }
                            }
                        }

                        $view->with('menuData', $menuData);

                    }

                    // View'a kullanıcıyı, izinleri ve güncellenmiş JSON verisini taşı
                    $view->with('user', $user);
                    $view->with('userPermissions', $permissions);
                }
            } 
        });

        View::composer(["client*"], function ($view) {

            if (Auth::check()) {
                $user = User::with('role.rolePermissions.permissions')->find(Auth::user()->id);

                if ($user) {
                    $permissions = $user->role->rolePermissions->flatMap(function ($rolePermission) {
                        return $rolePermission->permissions->pluck('key');
                    })->unique()->toArray();

                    $jsonFilePath = base_path('client_menu.json');

                    // JSON dosyasının varlığını kontrol etmek için File sınıfını kullanabilirsiniz
                    if (File::exists($jsonFilePath)) {
                        $menuJson = File::get($jsonFilePath); // JSON dosyasını oku
                        $menuData = json_decode($menuJson, true); // JSON verisini bir diziye çevir

                        // Her menü öğesinin izinlerini kontrol et ve "visible" değerini ayarla
                        foreach ($menuData as &$menuItem) {
                            if (in_array($menuItem['key'], $permissions)) {
                                $menuItem['visible'] = true;
                            } else {
                                $menuItem['visible'] = false;
                            }

                            // Alt menü öğelerini kontrol et
                            if (isset($menuItem['subMenu'])) {
                                foreach ($menuItem['subMenu'] as &$subMenuItem) {
                                    if (in_array($subMenuItem['key'], $permissions)) {
                                        $subMenuItem['visible'] = true;
                                    } else {
                                        $subMenuItem['visible'] = false;
                                    }
                                }
                            }
                        }

                        $view->with('menuData', $menuData);

                    }

                    // View'a kullanıcıyı, izinleri ve güncellenmiş JSON verisini taşı
                    $view->with('user', $user);
                    $view->with('userPermissions', $permissions);
                }
            }
        });

        View::composer(["institutional*"], function ($view) {

            if (Auth::check()) {
                $user = User::with('role.rolePermissions.permissions')->find(Auth::user()->id);

                if ($user) {
                    $permissions = $user->role->rolePermissions->flatMap(function ($rolePermission) {
                        return $rolePermission->permissions->pluck('key');
                    })->unique()->toArray();

                    $jsonFilePath = base_path('institutional_menu.json');

                    // JSON dosyasının varlığını kontrol etmek için File sınıfını kullanabilirsiniz
                    if (File::exists($jsonFilePath)) {
                        $menuJson = File::get($jsonFilePath); // JSON dosyasını oku
                        $menuData = json_decode($menuJson, true); // JSON verisini bir diziye çevir

                        // Her menü öğesinin izinlerini kontrol et ve "visible" değerini ayarla
                        foreach ($menuData as &$menuItem) {
                            if (in_array($menuItem['key'], $permissions)) {
                                $menuItem['visible'] = true;
                            } else {
                                $menuItem['visible'] = false;
                            }

                            // Alt menü öğelerini kontrol et
                            if (isset($menuItem['subMenu'])) {
                                foreach ($menuItem['subMenu'] as &$subMenuItem) {
                                    if (in_array($subMenuItem['key'], $permissions)) {
                                        $subMenuItem['visible'] = true;
                                    } else {
                                        $subMenuItem['visible'] = false;
                                    }
                                }
                            }
                        }

                        $view->with('menuData', $menuData);

                    }

                    // View'a kullanıcıyı, izinleri ve güncellenmiş JSON verisini taşı
                    $view->with('user', $user);
                    $view->with('userPermissions', $permissions);
                }
            }
        });
    }

}
