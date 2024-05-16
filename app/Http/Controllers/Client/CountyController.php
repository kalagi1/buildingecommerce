<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\County;
use App\Models\District;
use App\Models\Neighborhood;

class CountyController extends Controller
{
    public function getCounties($city)
    {
        $city = City::where("id", $city)->first();
        $counties = District::where('ilce_sehirkey', $city->id)->get();
        return response()->json([
            "counties" => $counties,
            "cityName" => $city->title
        ]);
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
        $neighborhoods = Neighborhood::whereRaw("mahalle_ilcekey = ?", [$county])
            ->get();
        return response()->json($neighborhoods->map(fn ($item) => ['id' => $item->mahalle_id, 'title' => $item->mahalle_title]));
    }
}
