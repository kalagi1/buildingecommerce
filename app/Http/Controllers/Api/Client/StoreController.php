<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function getFeaturedStores()
    {
        // $featuredProjects = Project::select('projects.*')
        // ->with("city", "county",'user',"neighbourhood")
        // ->with( 'brand', 'roomInfo','listItemValues', 'housingType')
        // ->orderBy("created_at", "desc")
        // ->where('projects.status', 1)
        // ->get();
        // return response()->json($featuredProjects);

        $brands = User::where("type", "2")->where("status", "1")->where("is_show", "yes")->where("corporate_account_status", "1")->orderBy("order", "asc")->get();

        return response()->json($brands);
    }
}
