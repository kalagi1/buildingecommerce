<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Housing;
use App\Models\HousingStatus;
use App\Models\Menu;
use App\Models\Project;
use App\Models\Slider;
use App\Models\StandOutUser;

class HomeController extends Controller
{
    public function index()
    {
        $menu = Menu::getMenuItems();

        $secondhandHousings = Housing::with('images')->select(
            'housings.id',
            'housings.title AS housing_title',
            'housings.created_at',
            'housing_types.title as housing_type_title',
            'housings.housing_type_data',
            'housings.address',
        )->leftJoin('housing_types', 'housing_types.id', '=', 'housings.housing_type_id')
            ->leftJoin('housing_status', 'housings.status_id', '=', 'housing_status.id')
            ->where('housings.status',1)
            ->get();

        $dashboardProjects = StandOutUser::where('start_date', "<=", date("Y-m-d"))->where('end_date', ">=", date("Y-m-d"))->orderBy("item_order")->get();
        $dashboardStatuses = HousingStatus::where('in_dashboard', 1)->orderBy("dashboard_order")->where("status", "1")->get();
        $brands = Brand::where('status', 1)->get();
        $sliders = Slider::all();

        $finishProjects = Project::whereHas('housingStatus', function ($query) {
            $query->where('housing_type_id', '2');
        })->with("housings", 'brand', 'roomInfo', 'housingType')->orderBy("created_at", "desc")->where('status',1)->get();

        $continueProjects = Project::whereHas('housingStatus', function ($query) {
            $query->where('housing_type_id', '3');
        })->with("housings", 'brand', 'roomInfo', 'housingType')->where('status',1)->orderBy("created_at", "desc")->get();

        return view('client.home.index', compact('menu', 'finishProjects', 'continueProjects', 'sliders', 'secondhandHousings', 'brands', 'dashboardProjects', 'dashboardStatuses'));
    }
}
