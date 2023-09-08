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
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index($slug){
        $menu = Menu::getMenuItems();
        $project = Project::where('slug',$slug)->firstOrFail();
        return view('client.project.index',compact('menu','project'));
    }

    public function brandProjects($id){
        $menu = Menu::getMenuItems();
        $brand = Brand::where('id',$id)->first();
        return view('client.project.brand_projects',compact('menu','brand'));
    }

    public function projectList(Request $request){
        $projects = Project::orderBy('view_count');
        if($request->input("search")){
            $projects = $projects->where('project_title','LIKE','%'.$request->input('search').'%');
        }

        if($request->input("city_id")){
            $projects = $projects->where('city_id',$request->input("city_id"));
        }

        if($request->input("housing_type_id")){
            $projects = $projects->where('housing_type_id',$request->input("housing_type_id"));
        }

        $housingTypes = HousingType::where('active',1)->get();
        $housingStatus = HousingStatus::get();
        $cities = City::get();
        $projects = $projects->get();
        $menu = Menu::getMenuItems();
        return view('client.project.list',compact('menu','projects','housingTypes','housingStatus','cities'));
    }
    
    public function projectHousingDetail($projectSlug,$housingOrder){
        $menu = Menu::getMenuItems();
        $project = Project::where('slug',$projectSlug)->firstOrFail();
        return view('client.project.project_housing',compact('menu','project','housingOrder'));
    }
}
