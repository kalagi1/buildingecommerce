<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\County;
use App\Models\District;
use App\Models\Neighborhood;

class CountyController extends Controller
{
    public function getCounties($city)
    {
        $counties = District::where('ilce_sehirkey', $city)->get();
        return response()->json($counties);
    }
    public function getCountiesForClient($city)
    {
        $counties = County::where('city_id', $city)->get();
        return response()->json($counties);
    }
    public function getNeighborhoods($county)
    {
        $neighborhoods = Neighborhood::where('mahalle_ilcekey', $county)->get();
        return response()->json($neighborhoods);
    }
    public function getNeighborhoodsForClient($county)
    {
        $neighborhoods = Neighborhood::whereRaw("mahalle_ilcekey = (SELECT key_x FROM districts WHERE id = ?)", [$county])
            ->get();
        return response()->json($neighborhoods->map(fn($item) => ['id' => $item->mahalle_id, 'title' => $item->mahalle_title]));
    }   
}
