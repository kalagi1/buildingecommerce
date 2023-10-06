<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offer;

class OfferController extends Controller
{
    
    function index()
    {
        $offers = Offer::where("user_id", auth()->user()->id)->get();
        return view('institutional.offers.index', compact('offers'));
    }

}
