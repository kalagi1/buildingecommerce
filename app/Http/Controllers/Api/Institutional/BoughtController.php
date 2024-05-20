<?php

namespace App\Http\Controllers\Api\Institutional;

use App\Http\Controllers\Controller;
use App\Models\CartOrder;
use Illuminate\Http\Request;

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
}
