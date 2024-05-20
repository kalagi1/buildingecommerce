<?php

namespace App\Http\Controllers\Api\Institutional;

use App\Http\Controllers\Controller;
use App\Models\CartOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BoughtController extends Controller
{
    public function bougths()
    {
        $cartOrders = CartOrder::where('user_id', auth()->user()->id)->with("invoice")
            ->where("is_disabled", NULL)->orderBy("id", "desc")->get();
        return response()->json([
            "boughts" => $cartOrders
        ]);
    }

    public function solds(){
        $user = User::where("id", Auth::user()->id)->with("projects", "housings")->first();
        $userProjectIds = $user->projects->pluck('id')->toArray();

        // Projects için sorgu
        $projectOrders = CartOrder::select('cart_orders.*')
            ->with("user", "invoice", "reference")
            ->where(function ($query) use ($userProjectIds) {
                $query->whereIn(
                    DB::raw("JSON_UNQUOTE(JSON_EXTRACT(cart, '$.item.id'))"),
                    $userProjectIds
                );
            })
            ->orderBy('created_at', 'DESC')
            ->where("is_disabled", NULL)
            ->get();


        $userHousingIds = $user->housings->pluck('id')->toArray();

        $housingOrders = CartOrder::select('cart_orders.*')
            ->with("user", "invoice", "reference")
            ->where(function ($query) use ($userHousingIds) {
                $query->whereIn(
                    DB::raw("JSON_UNQUOTE(JSON_EXTRACT(cart, '$.item.id'))"),
                    $userHousingIds
                );
            })
            ->orderBy('created_at', 'DESC')
            ->get();


        $cartOrders = $projectOrders->merge($housingOrders);
        return response()->json([
            "cartOrders" => $cartOrders
        ]);
    }
}
