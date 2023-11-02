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

                $store = User::where("id", $institutional->id)->with('projects.housings', 'housings', 'city', 'town', 'district', "neighborhood", 'brands', "banners")->first();
                $projects = Project::where("user_id", $store->id)->with("brand", "roomInfo", "housingType", "county", "city", 'user.projects.housings', 'user.brands', 'user.housings', 'images')->orderBy("id", "desc")->where("status","1")->limit(3)->get();

                $finishProjects = Project::whereHas('housingStatus', function ($query) {
                    $query->where('housing_type_id', '2');
                })->with("housings", 'brand', 'roomInfo', 'housingType')->where('status', 1)->orderBy("created_at", "desc")->where("user_id", $store->id)->get();

                $continueProjects = Project::whereHas('housingStatus', function ($query) {
                    $query->where('housing_type_id', '3');
                })->with("housings", 'brand', 'roomInfo', 'housingType')->where('status', 1)->orderBy("created_at", "desc")->where("user_id", $store->id)->get();

                $secondhandHousings = Housing::with('images')->select(
                    'housings.id',
                    'housings.title AS housing_title',
                    'housings.created_at',
                    'housing_types.title as housing_type_title',
                    'housings.housing_type_data',
                    'housings.address',
                )->leftJoin('housing_types', 'housing_types.id', '=', 'housings.housing_type_id')
                    ->leftJoin('housing_status', 'housings.status_id', '=', 'housing_status.id')
                    ->where('housings.status_id', 1)
                    ->where("user_id", $store->id)
                    ->get();

                return view("client.institutional.dashboard", compact("store", 'projects', 'finishProjects', 'continueProjects', 'secondhandHousings'));
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
