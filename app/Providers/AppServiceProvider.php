<?php

namespace App\Providers;

use App\Models\AdBanner;
use App\Models\CartItem;
use App\Models\FooterLink;
use App\Models\Menu;
use App\Models\Page;
use App\Models\ShareLink;
use App\Models\SocialMediaIcon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
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
        $this->extendValidator();
    }

    private function composeAdminView()
    {
        View::composer(["admin*"], function ($view) {
            $this->composeView($view, 'admin_menu.json');
        });
    }

    private function composeClientView()
    {
        dd("dassds");
        View::composer([
            "client.layouts.partials.header",
            "client.layouts.partials.footer",
            "client.layouts.partials.cart_icon",
            "client.client-panel*"
        ], function ($view) {
            $cachedData = Cache::remember('client_view_data', now()->addHours(1), function () {
                return [
                    'fl' => FooterLink::all(),
                    'widgetGroups' => FooterLink::select('widget')->distinct()->get(),
                    'socialMediaIcons' => SocialMediaIcon::all(),
                    'headerLinks' => Page::where('location', 'header')->get(),
                    'footerLinks' => FooterLink::all(),
                    'adBanners' => AdBanner::where("is_visible", "1")->get(),
                ];
            });

            dd($cachedData);

            if (Auth::check()) {
                $sharerLinks = ShareLink::where("user_id", Auth::user()->id)->get();
                $view->with("sharerLinks", $sharerLinks);
                $cartItemCount = CartItem::where('user_id', Auth::user()->id)->count();
                $view->with("cartItemCount", $cartItemCount);
            }

            $menu = Menu::getMenuItems();
            $view->with("menu", $menu);
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
                $permissions = $this->getUserPermissions($user);

                $jsonFilePath = base_path($jsonFileName);

                if (File::exists($jsonFilePath)) {
                    $menuJson = File::get($jsonFilePath);
                    $menuData = json_decode($menuJson, true);

                    $this->filterMenuPermissions($menuData, $permissions);

                    $view->with('menuData', $menuData);
                }

                $view->with([
                    'user' => $user,
                    'userPermissions' => $permissions,
                ]);
            }
        }
    }

    private function getUserPermissions($user)
    {
        $permissions = $user->role->rolePermissions->flatMap(function ($rolePermission) {
            return $rolePermission->permissions->pluck('key');
        })->unique()->toArray();

        if ($user->type != "1" || $user->type != "3") {
            if ($user->corporate_type != null && $user->corporate_type == 'Emlak Ofisi') {
                $permissions = array_diff($permissions, ['Projects', "CreateProject", "GetReceivedOffers",  "GetProjects", "DeleteProject", "UpdateProject", 'GetProjectById']);
            }

            if ($user->corporate_type != null && $user->corporate_type != 'İnşaat Ofisi') {
                $permissions = array_diff($permissions, [
                    "Offers",
                    "CreateOffer",
                    "Offers",
                    "DeleteOffer",
                    "GetOfferById",
                    "UpdateOffer",
                    "GetOffers"
                ]);
            }

            if ($user->corporate_type != null && $user->corporate_type != 'Turizm Amaçlı Kiralama') {
                $permissions = array_diff($permissions, ['GetReservations', "CreateReservation", "GetReservations", "DeleteReservation", "UpdateReservation", 'GetReservationById']);
            }
        }

        return $permissions;
    }

    private function filterMenuPermissions(&$menuData, $permissions)
    {
        foreach ($menuData as &$menuItem) {
            $this->setMenuVisibility($menuItem, $permissions);

            if (isset($menuItem['subMenu'])) {
                foreach ($menuItem['subMenu'] as &$subMenuItem) {
                    $this->setMenuVisibility($subMenuItem, $permissions);
                }
            }
        }
    }

    private function setMenuVisibility(&$menuItem, $permissions)
    {
        if (isset($menuItem['subMenu'])) {
            $subMenuKeys = collect($menuItem['subMenu'])->pluck('key');
            $menuItem['visible'] = $subMenuKeys->intersect($permissions)->isNotEmpty();
        } else {
            $menuItem['visible'] = in_array($menuItem['key'], $permissions);
        }
    }

    private function extendValidator()
    {
        Validator::extend('iban', function ($attribute, $value, $parameters, $validator) {
            return strpos($value, 'TR') === 0;
        });
    }
}
