<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Housing;
use App\Models\Menu;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $menu = Menu::getMenuItems();
        $housings = Housing::select(
            'housings.title AS housing_title',
            'housings.room_count',
            'housings.square_meter',
            'housings.created_at',
            'housing_types.title as housing_type_title',
            'housings.address'
        )->leftJoin('housing_types', 'housing_types.id', '=', 'housings.housing_type_id')
            ->limit(10)->get();
        return view('client.home.index', compact('menu', 'housings'));
    }
}