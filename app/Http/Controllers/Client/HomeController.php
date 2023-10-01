<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Housing;
use App\Models\HousingStatus;
use App\Models\Menu;
use App\Models\Project;
use App\Models\Slider;
use App\Models\FooterSlider;
use App\Models\StandOutUser;

class HomeController extends Controller
{
    public function index()
    {
        $menu = Menu::getMenuItems();

        $secondhandHousings = Housing::with('images')->get();

        $dashboardProjects = StandOutUser::where('start_date', "<=", date("Y-m-d"))->where('end_date', ">=", date("Y-m-d"))->orderBy("item_order")->get();
        $dashboardStatuses = HousingStatus::where('in_dashboard', 1)->orderBy("dashboard_order")->where("status", "1")->get();
        $brands = Brand::where('status', 1)->get();
        $projects = Project::listForMarketing();
        $sliders = Slider::all();
        $footerSlider = FooterSlider::all();

        $finishProjects = Project::whereHas('housingStatus', function ($query) {
            $query->where('housing_type_id', '2');
        })->with("housings", 'brand', 'roomInfo', 'housingType')->orderBy("created_at", "desc")->get();

        $continueProjects = Project::whereHas('housingStatus', function ($query) {
            $query->where('housing_type_id', '3');
        })->with("housings", 'brand', 'roomInfo', 'housingType')->orderBy("created_at", "desc")->get();

        return view('client.home.index', compact('menu', 'finishProjects', 'continueProjects', 'sliders', 'secondhandHousings', 'projects', 'brands', 'dashboardProjects', 'dashboardStatuses', 'footerSlider'));
    }
}
