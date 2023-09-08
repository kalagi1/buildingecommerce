<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\HousingType;
use App\Models\Menu;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index($slug){
        $menu = Menu::getMenuItems();
        $project = Project::where('slug',$slug)->firstOrFail();
        return view('client.projects.index',compact('menu','project'));
    }

    public function brandProjects($id){
        $menu = Menu::getMenuItems();
        $brand = Brand::where('id',$id)->first();
        return view('client.projects.brand_projects',compact('menu','brand'));
    }

    public function projectList(){
        $menu = Menu::getMenuItems();
        return view('client.projects.list',compact('menu'));
    }
}
