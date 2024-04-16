<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
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

    public function getCountiesByCityId($cityId){
        $counties = District::select(DB::raw('ilce_title as label , ilce_key as value'))->where('ilce_sehirkey',$cityId)->get();
        
        return json_encode([
            "data" => $counties
        ]);
    }

    public function getNeighborhoodsByCountyId($countyId){
        $counties = District::select(DB::raw('mahalle_title as label , mahalle_key as value'))->where('mahalle_ilcekey',$countyId)->get();
        
        return json_encode([
            "data" => $counties
        ]);
    }
}
