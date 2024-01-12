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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        $this->composeAdminView();
        $this->composeClientView();
        $this->composeInstitutionalView();
    }

    private function composeAdminView()
    {
        View::composer(["admin*"], function ($view) {
            $this->composeView($view, 'admin_menu.json');
        });
    }

    private function composeClientView()
    {
        $cacheKey = 'client_view_data';
    
        $cachedData = Cache::get($cacheKey);
    
        if (!$cachedData) {
            $cachedData = [
                'fl' => FooterLink::all(),
                'widgetGroups' => FooterLink::select('widget')->distinct()->get(),
                'socialMediaIcons' => SocialMediaIcon::all(),
                'headerLinks' => Page::where('location', 'header')->get(),
                'footerLinks' => FooterLink::all(),
                'menu' => Menu::getMenuItems(),
                'adBanners' => AdBanner::where("is_visible", "1")->get(),
            ];
    
            Cache::put($cacheKey, $cachedData, now()->addHours(1));
        }
    
        View::composer(["client.layouts.partials.header","client.layouts.partials.footer", "client.client-panel*"], function ($view) use ($cachedData) {
            if (Auth::check()) {
                $sharerLinks = ShareLink::where("user_id",Auth::user()->id)->get();
                $view->with("sharerLinks", $sharerLinks);

            }
            $view->with($cachedData);
            $this->composeView($view, 'client_menu.json');
        });
    }
    

    private function composeInstitutionalView()
    {
        View::composer(["institutional*"], function ($view) {
            $this->composeView($view, 'institutional_menu.json');
        });
    }

    private function composeView($view, $jsonFileName)
    {
        if (Auth::check()) {
            $user = User::with('role.rolePermissions.permissions')->find(Auth::user()->id);

            if ($user) {
                $permissions = $user->role->rolePermissions->flatMap(function ($rolePermission) {
                    return $rolePermission->permissions->pluck('key');
                })->unique()->toArray();

                $jsonFilePath = base_path($jsonFileName);

                if (File::exists($jsonFilePath)) {
                    $menuJson = File::get($jsonFilePath);
                    $menuData = json_decode($menuJson, true);

                    foreach ($menuData as &$menuItem) {
                        $this->setMenuVisibility($menuItem, $permissions);

                        if (isset($menuItem['subMenu'])) {
                            foreach ($menuItem['subMenu'] as &$subMenuItem) {
                                $this->setMenuVisibility($subMenuItem, $permissions);
                            }
                        }
                    }

                    $view->with('menuData', $menuData);
                }

                $view->with([
                    'user' => $user,
                    'userPermissions' => $permissions,
                ]);
            }
        }
    }

    private function setMenuVisibility(&$menuItem, $permissions)
    {
        $menuItem['visible'] = in_array($menuItem['key'], $permissions);
    }
}
