<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Housing;
use App\Models\HousingComment;
use App\Models\Project;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $comments = HousingComment::with("user", "housing")->get();
        $clients = User::where("type", "1")->get();
        $institutionals = User::where("type", "2")->get();
        $projects = Project::all();
        $descProjects = Project::orderBy("id", "desc")->with("user")->limit(4)->get();
        $secondhandHousings = Housing::all();
        return view('admin.home.index', compact("comments", "clients", "institutionals", "projects", "secondhandHousings", 'descProjects'));
    }

}
