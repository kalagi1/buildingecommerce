<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\HousingStatus;
use App\Models\Project;
use Illuminate\Http\Request;

class HousingController extends Controller
{
   public function getDashboardStatuses(){

    $dashboardStatuses = HousingStatus::where('in_dashboard', 1)->orderBy("dashboard_order")->where("status", "1")->get();
    return response()->json($dashboardStatuses);

   }//End
}
