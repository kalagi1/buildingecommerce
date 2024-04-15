<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(){
        
    }

    public function show($userID){
        $institutional = User::where("id", $userID)->with('projects.housings', 'town', 'district', "neighborhood", 'housings', 'city', 'brands', "owners.housing")->first();

        return json_encode([
            "data" => $institutional
        ]);
    }
}
