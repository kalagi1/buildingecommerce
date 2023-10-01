<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\County;

class CountyController extends Controller
{
    public function getCounties($city)
    {
        $counties = County::where('city_id', $city)->get();
        return response()->json($counties);
    }
}
