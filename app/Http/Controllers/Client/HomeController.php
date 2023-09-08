<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Housing;
use App\Models\Menu;
use App\Models\Project;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $menu = Menu::getMenuItems();
        $secondhandHousings = Housing::with('images')->select(
            'housings.id',
            'housings.title AS housing_title',
            'housings.room_count',
            'housings.square_meter',
            'housings.created_at',
            'housing_types.title as housing_type_title',
            'housings.address',
            'housings.price'
        )->leftJoin('housing_types', 'housing_types.id', '=', 'housings.housing_type_id')
            ->leftJoin('housing_status', 'housings.status_id', '=', 'housing_status.id')
            ->where('housings.status_id', 1)
            ->get();

        $projects = Project::listForMarketing();
        return view('client.home.index', compact('menu', 'secondhandHousings','projects'));
    }
}