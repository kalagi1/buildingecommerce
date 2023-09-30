<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\City;
use App\Models\Housing;
use App\Models\HousingStatus;
use App\Models\HousingType;
use App\Models\Menu;
use App\Models\Project;
use App\Models\ProjectHouseSetting;
use App\Models\StandOutUser;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index($slug)
    {
        $menu = Menu::getMenuItems();
        $project = Project::where('slug', $slug)->with("brand", "roomInfo", "housingType", "county", "city", 'user.projects.housings', 'user.brands', 'user.housings', 'images')->firstOrFail();
        return view('client.projects.index', compact('menu', 'project'));
    }

    public function detail($slug)
    {
        $menu = Menu::getMenuItems();
        $project = Project::where('slug', $slug)->with("brand", "roomInfo", "housingType", "county", "city", 'user.projects.housings', 'user.brands', 'user.housings', 'images')->firstOrFail();
        return view('client.projects.detail', compact('menu', 'project'));
    }

    public function brandProjects($id)
    {
        $menu = Menu::getMenuItems();
        $brand = Brand::where('id', $id)->first();
        return view('client.projects.brand_projects', compact('menu', 'brand'));
    }

    public function projectList(Request $request)
    {
        $projects = Project::orderBy('view_count');
        if ($request->input("search")) {
            $projects = $projects->where('project_title', 'LIKE', '%' . $request->input('search') . '%');
        }

        if ($request->input("city_id")) {
            $projects = $projects->where('city_id', $request->input("city_id"));
        }

        if ($request->input("housing_type_id")) {
            $projects = $projects->where('housing_type_id', $request->input("housing_type_id"));
        }

        $housingTypes = HousingType::where('active', 1)->get();
        $housingStatus = HousingStatus::get();
        $cities = City::get();
        $projects = $projects->get();
        $menu = Menu::getMenuItems();
        return view('client.projects.list', compact('menu', 'projects', 'housingTypes', 'housingStatus', 'cities'));
    }

    public function allProjects($slug)
    {
        // HousingStatus modelini kullanarak slug'a göre durumu bulun
        $status = HousingStatus::where('slug', $slug)->first();

        // HousingStatus bulunamazsa hata sayfasına yönlendirin
        if (!$status) {
            abort(404); // Veya başka bir hata işleme yöntemi kullanabilirsiniz.
        }

        $secondhandHousings = [];
        if ($status->id == 1) {
            // HousingStatus ID'sine sahip projeleri alın
            $projects = Project::all();

        } elseif ($status->id == 4) {
            $projects = [];
            $secondhandHousings = Housing::with('images')->get();
        } else {
            $oncelikliProjeler = StandOutUser::where('housing_status_id',$status->id)->pluck('project_id')->toArray();
            $firstProjects = Project::whereIn('id', $oncelikliProjeler)->get();

            $anotherProjects = Project::whereNotIn('id', $oncelikliProjeler)
            ->orderBy('created_at', 'desc') // Eklenme tarihine göre sırala (en son eklenenler en üstte olur)
            ->get();

            $projects = StandOutUser::join("projects",'projects.id','=','stand_out_users.project_id')->select("projects.*")->whereIn('project_id', $oncelikliProjeler)
            ->orderBy('item_order', 'asc') // Öne çıkarılma sırasına göre sırala
            ->get()
            ->concat($anotherProjects);
        }

        $housingTypes = HousingType::where('active', 1)->get();
        $housingStatuses = HousingStatus::get();
        $cities = City::get();
        $menu = Menu::getMenuItems();

        return view('client.all-projects.list', compact('menu', 'projects', 'secondhandHousings', 'housingTypes', 'housingStatuses', 'cities', 'status'));
    }

    public function projectHousingDetail($projectSlug, $housingOrder)
    {
        $menu = Menu::getMenuItems();
        $project = Project::where('slug', $projectSlug)->firstOrFail();
        $projectHousing = $project->roomInfo->keyBy('name');
        $projectHousingSetting = ProjectHouseSetting::where('house_type', $project->housing_type_id)->orderBy('order')->get();
        return view('client.projects.project_housing', compact('menu', 'project', 'housingOrder', 'projectHousingSetting', 'projectHousing'));
    }

    public function propertyProjects(Request $request, $property)
    {
        $housingStatus = HousingStatus::where('slug', $property)->first();
        $projects = Project::whereHas('housingStatus', function ($query) use ($housingStatus) {
            $query->where('housing_type_id', $housingStatus->id);
        })->orderBy('view_count');
        if ($request->input("search")) {
            $projects = $projects->where('project_title', 'LIKE', '%' . $request->input('search') . '%');
        }

        if ($request->input("city_id")) {
            $projects = $projects->where('city_id', $request->input("city_id"));
        }

        if ($request->input("housing_type_id")) {
            $projects = $projects->where('housing_type_id', $request->input("housing_type_id"));
        }

        $housingTypes = HousingType::where('active', 1)->get();
        $housingStatus = HousingStatus::get();
        $cities = City::get();
        $projects = $projects->get();
        $menu = Menu::getMenuItems();
        return view('client.projects.list', compact('menu', 'projects', 'housingTypes', 'housingStatus', 'cities'));
    }
}
