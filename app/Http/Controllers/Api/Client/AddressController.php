<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function cities(){
        $cities = City::select(DB::raw('title as label , id as value'))->get();

        return json_encode([
            "data" => $cities
        ]);
    }
}
