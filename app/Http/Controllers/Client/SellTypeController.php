<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SellTypeController extends Controller
{
    public function getSellType(Request $request)
    {
        $sellType = $request->session()->get('sell_type');
        
        return response()->json(['sell_type' => $sellType]);
    }

    public function updateSellType(Request $request)
    {
        $sellType = $request->input('sell_type');
    
        $request->session()->put('sell_type', $sellType);

        return response()->json(['success' => true]);
    }
}
