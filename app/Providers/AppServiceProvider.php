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
        Validator::extend('iban', function ($attribute, $value, $parameters, $validator) {
            return strpos($value, 'TR') === 0;
        });
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
                'adBanners' => AdBanner::where("is_visible", "1")->get(),
            ];

            Cache::put($cacheKey, $cachedData, now()->addHours(1));
        }

        View::composer([
            "client.layouts.partials.header", "client.layouts.partials.footer",
            "client.layouts.partials.cart_icon", "client.client-panel*"
        ], function ($view) use ($cachedData) {
            if (Auth::check()) {
                $sharerLinks = ShareLink::where("user_id", Auth::user()->id)->get();
                $view->with("sharerLinks", $sharerLinks);
                // $cartItemCount = request()->session()->get('cart');
                $cartItemCount = CartItem::where('user_id', Auth::user()->id)->first();
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
                $permissions = $user->role->rolePermissions->flatMap(function ($rolePermission) {
                    return $rolePermission->permissions->pluck('key');
                })->unique()->toArray();

                if ($user->corporate_type != null && $user->corporate_type == 'Emlak Ofisi') {
                    $permissions = array_diff($permissions, ['Projects', "CreateProject", "GetProjects", "DeleteProject", "UpdateProject", 'GetProjectById']);
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

                if ($user->corporate_type != null && $user->corporate_type != 'Turizm Amaçlı Kiralama' ) {
                    $permissions = array_diff($permissions, ['GetReservations', "CreateReservation", "GetReservations", "DeleteReservation", "UpdateReservation", 'GetReservationById']);
                }


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
      dd($permissions);
        if (isset($menuItem['subMenu'])) {
            // Alt menü anahtarlarını pluck et ve kontrol et
            $subMenuKeys = collect($menuItem['subMenu'])->pluck('key');
    
            // Alt menülerde izinlerle kesişen varsa, ana menüyü görünür yap
            $menuItem['visible'] = $subMenuKeys->intersect($permissions)->isNotEmpty();
        } else {
            // Ana menüyü izinlerde olup olmadığını kontrol et
            $menuItem['visible'] = in_array($menuItem['key'], $permissions);
        }
    }
}
