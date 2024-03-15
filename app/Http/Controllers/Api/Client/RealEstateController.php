<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Housing;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RealEstateController extends Controller
{

    public function getRealEstates(){
        $secondhandHousings =  Housing::with('images')
        ->select(
            'housings.id',
            'housings.slug',
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
            'cities.title AS city_title',
            'districts.ilce_title AS county_title',
            'neighborhoods.mahalle_title AS neighborhood_title',
            DB::raw('(SELECT discount_amount FROM offers WHERE housing_id = housings.id AND type = "housing" AND start_date <= "' . date('Y-m-d H:i:s') . '" AND end_date >= "' . date('Y-m-d H:i:s') . '") as discount_amount'),
        )
        ->leftJoin('housing_types', 'housing_types.id', '=', 'housings.housing_type_id')
        ->leftJoin('project_list_items', 'project_list_items.housing_type_id', '=', 'housings.housing_type_id')
        ->leftJoin('housing_status', 'housings.status_id', '=', 'housing_status.id')
        ->leftJoin('cities', 'cities.id', '=', 'housings.city_id')
        ->leftJoin('districts', 'districts.ilce_key', '=', 'housings.county_id')
        ->leftJoin('neighborhoods', 'neighborhoods.mahalle_id', '=', 'housings.neighborhood_id')
        ->where('housings.status', 1)
        ->where('project_list_items.item_type', 2)
        ->orderByDesc('doping_time')
        ->orderByDesc('housings.created_at')
        ->skip(0)
        ->take(4)
        ->get();

        return response()->json($secondhandHousings);
    }
}
