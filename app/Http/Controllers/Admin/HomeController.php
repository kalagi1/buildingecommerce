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
        $secondhandHousings = Housing::with('images')->select(
            'housings.id',
            'housings.title AS housing_title',
            'housings.created_at',
            'housing_types.title as housing_type_title',
            'housings.housing_type_data',
            'housings.address',
        )->leftJoin('housing_types', 'housing_types.id', '=', 'housings.housing_type_id')
            ->leftJoin('housing_status', 'housings.status_id', '=', 'housing_status.id')
            ->where('housings.status', 1)
            ->get();
        return view('admin.home.index', compact("comments", "clients", "institutionals", "projects", "secondhandHousings", 'descProjects'));
    }

}
