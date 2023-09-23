<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Housing;
use App\Models\Menu;
use App\Models\ProjectHouseSetting;
use Illuminate\Http\Request;

class HousingController extends Controller
{
    public function show($id)
    {
        $menu = Menu::getMenuItems();
        $housing = Housing::with('images')->select(
            'housings.*',
            'housing_types.title as housing_type',
            'housing_types.slug',
            'housing_types.form_json',
            'housing_status.name',
        )->leftJoin('housing_types', 'housing_types.id', '=', 'housings.housing_type_id')
            ->leftJoin('housing_status', 'housing_status.id', '=', 'housings.status_id')
            ->where('housings.id', $id)->first();
            $housingSetting = ProjectHouseSetting::where('housing_type',$housing->housing_type)->get();
        // return $housing;
        return view('client.housings.detail', compact('housing', 'menu','housingSetting'));
    }

    public function list(){
        $housings = Housing::get();
        $menu = Menu::getMenuItems();

        return view('client.housings.list',compact('housings','menu'));
    }
}
