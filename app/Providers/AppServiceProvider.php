<?php

namespace App\Providers;

use App\Models\AdBanner;
use App\Models\FooterLink;
use App\Models\Menu;
use App\Models\Page;
use App\Models\SocialMediaIcon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
        View::composer(["client*"], function ($view) {
            $footerLinks = FooterLink::all();
            $socialMediaIcons = SocialMediaIcon::all();
            $menu = Menu::getMenuItems();
            $adBanners = AdBanner::where("is_visible", "1")->get();
            $widgetGroups = FooterLink::select('widget')->distinct()->get();
            $headerLinks = Page::where('location', 'header')->get();
            $fl = Page::where('location', 'footer')->get();

            $view->with([
                'fl' => $fl,
                'widgetGroups' => $widgetGroups,
                'socialMediaIcons' => $socialMediaIcons,
                'headerLinks' => $headerLinks,
                'footerLinks' => $footerLinks,
                'menu' => $menu,
                'adBanners' => $adBanners,
            ]);

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
