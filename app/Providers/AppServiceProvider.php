<?php

namespace App\Providers;

use App\Models\AdBanner;
use App\Models\FooterLink;
use App\Models\Menu;
use App\Models\Page;
use App\Models\ShareLink;
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

        View::composer("client.*", function ($view) {
            if(auth()->user()){
                $sharerLinks = array_values(array_keys(ShareLink::where('user_id',auth()->user()->id)->where('item_type',2)->get()->keyBy('item_id')->toArray()));
                $sharerLinksProjects = ShareLink::select('room_order','item_id')->where('user_id',auth()->user()->id)->where('item_type',1)->get()->keyBy('item_id')->toArray();
            }else{
                $sharerLinks = [];
                $sharerLinksProjects = [];
            }
            $footerLinks = FooterLink::all();
            $socialMediaIcons = SocialMediaIcon::all();
            $menu = Menu::getMenuItems();
            $adBanners = AdBanner::where("is_visible", "1")->get();
            $widgetGroups = FooterLink::select('widget')
                ->distinct()
                ->get();
            $headerLinks = Page::where('location', 'header')->get();
            $fl = Page::where('location', 'footer')->get();
            $view->with('fl', $fl);
            $view->with('widgetGroups', $widgetGroups);
            $view->with("socialMediaIcons", $socialMediaIcons);
            $view->with("headerLinks", $headerLinks);
            $view->with("footerLinks", $footerLinks);
            $view->with("menu", $menu);
            $view->with("adBanners", $adBanners);
            $view->with('sharerLinks', $sharerLinks);
            $view->with('sharerLinksProjects', $sharerLinksProjects);
        });
        
        if(request('sharer_username')){
            session()->put('sharer_username',request('sharer_username'));
        }

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
