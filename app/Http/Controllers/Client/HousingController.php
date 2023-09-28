<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Housing;
use App\Models\HousingType;
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
            'housing_types.id as housing_type_id',
            'housing_status.name',
        )->leftJoin('housing_types', 'housing_types.id', '=', 'housings.housing_type_id')
            ->leftJoin('housing_status', 'housing_status.id', '=', 'housings.status_id')
            ->where('housings.id', $id)->first();
            $housingSetting = ProjectHouseSetting::where('house_type',$housing->housing_type_id)->get();
        // return $housing;
        return view('client.housings.detail', compact('housing', 'menu','housingSetting'));
    }

    public function list(Request $request){
        $housings = Housing::query();
        if($request->input('search')){
            $housings = $housings->where('title','LIKE','%'.$request->input('search').'%');
        }

        if($request->input('city')){
            $housings = $housings->where('city_id',$request->input('city'));
        }

        if($request->input('housing_type')){
            $housings = $housings->where('housing_type_id',$request->input('housing_type'));
        }

        $housings = $housings->get();
        if($request->input('min-price') != "" && $request->input('max-price') != ""){
            $housingsTemp = [];
            $maxPrice = intval(str_replace(",", "", $request->input('max-price')));
            $minPrice = intval(str_replace(",", "", $request->input('min-price')));
            foreach($housings as $housing){
                $housingTypeData = json_decode($housing->housing_type_data);
                $housingPrice = floatval($housingTypeData->price[0]);
                if($housingPrice >= $minPrice && $housingPrice <= $maxPrice){
                    array_push($housingsTemp,$housing);
                }
            }

            $housings = $housingsTemp;
        }

        if($request->input('min-square-meters') != "" && $request->input('max-square-meters') != ""){
            $housingsTemp = [];
            $maxSquareMeters = intval(str_replace(",", "", $request->input('max-square-meters')));
            $minSquareMeters = intval(str_replace(",", "", $request->input('min-square-meters')));
            foreach($housings as $housing){
                $housingTypeData = json_decode($housing->housing_type_data);
                $housingSquareMeters = floatval($housingTypeData->squaremeters[0]);
                if($housingSquareMeters >= $minSquareMeters && $housingSquareMeters <= $maxSquareMeters){
                    array_push($housingsTemp,$housing);
                }
            }
            $housings = $housingsTemp;
        }


        if($request->input('room_count') != ""){
            $housingsTemp = [];
            foreach($housings as $housing){
                $housingTypeData = json_decode($housing->housing_type_data);
                $housingRoomCount = $housingTypeData->room_count[0];
                if($request->input('room_count') == $housingRoomCount){
                    array_push($housingsTemp,$housing);
                }
            }
            $housings = $housingsTemp;
        }

        $menu = Menu::getMenuItems();
        $cities = City::get();
        $housingTypes = HousingType::get();

        return view('client.housings.list',compact('housings','menu','cities','housingTypes'));
    }
}
