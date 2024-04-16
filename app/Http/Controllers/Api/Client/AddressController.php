<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function cities(){
        $cities = City::get();

        return json_encode([
            "data" => $cities
        ]);
    }
}
