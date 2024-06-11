<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
    }

    public function show($userID)
    {
        $institutional = User::where("id", $userID)
        ->with([
            'projects.housings',
            'projects.city',
            'projects.county',
            'banners',
            'town',
            'district',
            'neighborhood',
            'housings' => function ($query) {
                $query->where('status', 1);
            },
            'housings.listItems',
            'housings.city',
            'housings.county',
            'housings.neighborhood',
            'city',
            'brands',
            'owners.housing' => function ($query) {
                $query->where('status', 1);
            },
        ])
        ->first();
    
        return response()->json([
            "data" => $institutional
        ]);
    }
}
