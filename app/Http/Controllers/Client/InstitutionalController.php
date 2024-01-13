<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Housing;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InstitutionalController extends Controller
{
    public function dashboard($slug)
    {

        $users = User::all();
        foreach ($users as $institutional) {
          
            $slugName = Str::slug($institutional->name);
            if ($slugName === $slug) {
                if (!$institutional || $institutional->type !== 2) {
                    abort(404);
                }
                $store = User::where("id", $institutional->id)->with('projects.housings', 'housings', 'city', 'town', 'district', "neighborhood", 'brands', "banners")->first();
                $projects = Project::where("user_id", $store->id)->with("brand", "roomInfo", "housingType", "county", "city", 'user.projects.housings', 'user.brands', 'user.housings', 'images')->orderBy("id", "desc")->where("status", "1")->limit(3)->get();
                
                $finishProjects = Project::whereHas('housingStatus', function ($query) {
                    $query->where('housing_type_id', '2');
                })->with("housings", 'brand', 'roomInfo', 'housingType')->where('status', 1)->orderBy("created_at", "desc")->where("user_id", $store->id)->get();

                $continueProjects = Project::whereHas('housingStatus', function ($query) {
                    $query->where('housing_type_id', '3');
                })->with("housings", 'brand', 'roomInfo', 'housingType')->where('status', 1)->orderBy("created_at", "desc")->where("user_id", $store->id)->get();

                $soilProjects = Project::with("city", "county")->whereHas('housingStatus', function ($query) {
                    $query->where('housing_type_id', '5');
                })->with("housings", 'brand', 'roomInfo', 'housingType')->where('status', 1)->orderBy("created_at", "desc")->where("user_id", $store->id)->get();

                $secondhandHousings = Housing::with('images',"neighborhood")
                ->select(
                    'housings.id',
                    'housings.title AS housing_title',
                    'housings.created_at',
                    'housings.step1_slug',
                    'housings.step2_slug',
                    'housing_types.title as housing_type_title',
                    'housings.housing_type_data',
                    'project_list_items.column1_name as column1_name',
                    'project_list_items.column2_name as column2_name',
                    'project_list_items.column3_name as column3_name',
                    'project_list_items.column4_name as column4_name',
                    'project_list_items.column1_additional as column1_additional',
                    'project_list_items.column2_additional as column2_additional',
                    'project_list_items.column3_additional as column3_additional',
                    'project_list_items.column4_additional as column4_additional',
                    'housings.address',
                        \Illuminate\Support\Facades\DB::raw('(SELECT status FROM cart_orders WHERE JSON_EXTRACT(cart, "$.type") = "housing" AND JSON_EXTRACT(cart, "$.item.id") = housings.id) AS sold'),
                    \Illuminate\Support\Facades\DB::raw('(SELECT created_at FROM stand_out_users WHERE item_type = 2 AND item_id = housings.id AND housing_type_id = 0) as doping_time'),
                    'cities.title AS city_title', // city tablosundan veri çekme
                    'districts.ilce_title AS county_title', // district tablosundan veri çekme
                    'neighborhoods.mahalle_title AS neighborhood_title',

                )
                ->leftJoin('housing_types', 'housing_types.id', '=', 'housings.housing_type_id')
                ->leftJoin('project_list_items', 'project_list_items.housing_type_id', '=', 'housings.housing_type_id')
                ->leftJoin('housing_status', 'housings.status_id', '=', 'housing_status.id')
                ->leftJoin('cities', 'cities.id', '=', 'housings.city_id') // city tablosunu join etme
                ->leftJoin('districts', 'districts.ilce_key', '=', 'housings.county_id') // district tablosunu join etme
                ->leftJoin('neighborhoods', 'neighborhoods.mahalle_id', '=', 'housings.neighborhood_id')
                ->where('housings.status', 1)
                ->where('project_list_items.item_type', 2)
                ->orderByDesc('doping_time')
                ->where("user_id", $store->id)
                ->orderByDesc('housings.created_at')
                ->get();
                


                return view("client.institutional.dashboard", compact("store","slug", "soilProjects", 'projects', 'finishProjects', 'continueProjects', 'secondhandHousings'));
            }
        }
    }

    public function getFilterInstitutionalData(Request $request,$slug){
        $users = User::all();
        foreach ($users as $institutional) {
          
        
            $slugName = Str::slug($institutional->name);
            if ($slugName === $slug) {

                $store = User::where("id", $institutional->id)->with('projects.housings', 'housings', 'city', 'town', 'district', "neighborhood", 'brands', "banners")->first();
                $projects = Project::where("user_id", $store->id)->where('project_title','LIKE','%'.$request->input('text').'%')->with("brand", "roomInfo", "housingType", "county", "city", 'user.projects.housings', 'user.brands', 'user.housings', 'images')->orderBy("id", "desc")->where("status", "1")->limit(3)->get();
                $view = view('client.components.institutional-projects',compact('projects'));
                $projectsRender = $view->render();
                $finishProjects = Project::whereHas('housingStatus', function ($query) {
                    $query->where('housing_type_id', '2');
                })->with("housings", 'brand', 'roomInfo', 'housingType')->where('status', 1)->orderBy("created_at", "desc")->where("user_id", $store->id)->get();

                $finishProjectsView = view('client.components.finished-projects',compact('finishProjects','slug'));
                $finishProjectsViewRender = $finishProjectsView->render();
                $continueProjects = Project::whereHas('housingStatus', function ($query) {
                    $query->where('housing_type_id', '3');
                })->with("housings", 'brand', 'roomInfo', 'housingType')->where('status', 1)->orderBy("created_at", "desc")->where("user_id", $store->id)->get();

                $soilProjects = Project::with("city", "county")->whereHas('housingStatus', function ($query) {
                    $query->where('housing_type_id', '5');
                })->with("housings", 'brand', 'roomInfo', 'housingType')->where('status', 1)->orderBy("created_at", "desc")->where("user_id", $store->id)->get();

                $secondhandHousings = Housing::with('images')
                ->select(
                    'housings.id',
                    'housings.title AS housing_title',
                    'housings.created_at',
                    'housings.step1_slug',
                    'housings.step2_slug',
                    'housing_types.title as housing_type_title',
                    'housings.housing_type_data',
                    'project_list_items.column1_name as column1_name',
                    'project_list_items.column2_name as column2_name',
                    'project_list_items.column3_name as column3_name',
                    'project_list_items.column4_name as column4_name',
                    'project_list_items.column1_additional as column1_additional',
                    'project_list_items.column2_additional as column2_additional',
                    'project_list_items.column3_additional as column3_additional',
                    'project_list_items.column4_additional as column4_additional',
                    'housings.address',
                        \Illuminate\Support\Facades\DB::raw('(SELECT status FROM cart_orders WHERE JSON_EXTRACT(cart, "$.type") = "housing" AND JSON_EXTRACT(cart, "$.item.id") = housings.id) AS sold'),
                    \Illuminate\Support\Facades\DB::raw('(SELECT created_at FROM stand_out_users WHERE item_type = 2 AND item_id = housings.id AND housing_type_id = 0) as doping_time'),
                    'cities.title AS city_title', // city tablosundan veri çekme
                    'districts.ilce_title AS county_title' // district tablosundan veri çekme
                )
                ->leftJoin('housing_types', 'housing_types.id', '=', 'housings.housing_type_id')
                ->leftJoin('project_list_items', 'project_list_items.housing_type_id', '=', 'housings.housing_type_id')
                ->leftJoin('housing_status', 'housings.status_id', '=', 'housing_status.id')
                ->leftJoin('cities', 'cities.id', '=', 'housings.city_id') // city tablosunu join etme
                ->leftJoin('districts', 'districts.ilce_key', '=', 'housings.county_id') // district tablosunu join etme
                ->where('housings.status', 1)
                ->where('project_list_items.item_type', 2)
                ->orderByDesc('doping_time')
                ->where("user_id", $store->id)
                ->orderByDesc('housings.created_at')
                ->get();

               
                return [
                    "store" => $store,
                    "soilProjects" => $soilProjects,
                    "projects" => $projectsRender,
                    "finishProjects" => $finishProjectsViewRender,
                    "continueProjects" => $continueProjects,
                    "secondhandHousings" => $secondhandHousings,
                ];
            }
        }
    }

    public function profile($slug)
    {

        $users = User::all();
        foreach ($users as $institutional) {
            $slugName = Str::slug($institutional->name);
            if ($slugName === $slug) {
                $institutional = User::where("id", $institutional->id)->with('projects.housings', 'town', 'district', "neighborhood", 'housings', 'city', 'brands', "owners.housing")->first();
                return view("client.institutional.detail", compact("institutional"));
            }
        }

    }

    public function housingList($slug)
    {
        $users = User::all();
        foreach ($users as $institutional) {
            $slugName = Str::slug($institutional->name);
            if ($slugName === $slug) {

                $store = User::where("id", $institutional->id)->with('projects.housings', 'housings', 'city', 'town', 'district', "neighborhood", 'brands', "banners")->first();

                $secondhandHousings = Housing::with('images')
                ->select(
                    'housings.id',
                    'housings.title AS housing_title',
                    'housings.created_at',
                    'housings.step1_slug',
                    'housings.step2_slug',
                    'housing_types.title as housing_type_title',
                    'housings.housing_type_data',
                    'project_list_items.column1_name as column1_name',
                    'project_list_items.column2_name as column2_name',
                    'project_list_items.column3_name as column3_name',
                    'project_list_items.column4_name as column4_name',
                    'project_list_items.column1_additional as column1_additional',
                    'project_list_items.column2_additional as column2_additional',
                    'project_list_items.column3_additional as column3_additional',
                    'project_list_items.column4_additional as column4_additional',
                    'housings.address',
                        \Illuminate\Support\Facades\DB::raw('(SELECT status FROM cart_orders WHERE JSON_EXTRACT(cart, "$.type") = "housing" AND JSON_EXTRACT(cart, "$.item.id") = housings.id) AS sold'),
                    \Illuminate\Support\Facades\DB::raw('(SELECT created_at FROM stand_out_users WHERE item_type = 2 AND item_id = housings.id AND housing_type_id = 0) as doping_time'),
                    'cities.title AS city_title', // city tablosundan veri çekme
                    'districts.ilce_title AS county_title' // district tablosundan veri çekme
                )
                ->leftJoin('housing_types', 'housing_types.id', '=', 'housings.housing_type_id')
                ->leftJoin('project_list_items', 'project_list_items.housing_type_id', '=', 'housings.housing_type_id')
                ->leftJoin('housing_status', 'housings.status_id', '=', 'housing_status.id')
                ->leftJoin('cities', 'cities.id', '=', 'housings.city_id') // city tablosunu join etme
                ->leftJoin('districts', 'districts.ilce_key', '=', 'housings.county_id') // district tablosunu join etme
                ->where('housings.status', 1)
                ->where('project_list_items.item_type', 2)
                ->orderByDesc('doping_time')
                ->where("user_id", $store->id)
                ->orderByDesc('housings.created_at')
                ->get();

                return view("client.institutional.housings", compact("secondhandHousings", "store"));
            }
        }
    }

    public function projectDetails($slug)
    {
        $users = User::all();
        foreach ($users as $institutional) {
            $slugName = Str::slug($institutional->name);
            if ($slugName === $slug) {
                $institutional = User::where("id", $institutional->id)->with('projects.housings', 'housings', 'city', 'brands')->first();
                return view("client.institutional.project-detail", compact("institutional"));
            }
        }
    }

    public function search(Request $request)
    {
        return $request->all();
        $query = $request->input('q');
        $brand = $request->input('brand');
        return $query;

        // Arama sorgularını işleyin ve sonuçları alın
        // Örneğin, mağaza adı veya markaya göre filtreleme yapabilirsiniz

        // Sonuçları görünüme aktarın ve görünümü döndürün
        return view('client.search_results', compact('results'));
    }

}
