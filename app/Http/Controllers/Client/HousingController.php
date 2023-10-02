<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Housing;
use App\Models\HousingComment;
use App\Models\HousingType;
use App\Models\Menu;
use App\Models\ProjectHouseSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HousingController extends Controller
{
    public function sendComment(Request $request, $id)
    {

        $validator = Validator::make($request->all(),
            [
                'rate' => 'required|string|in:1,2,3,4,5',
                'comment' => 'required|string',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $rate = $request->input('rate');
        $comment = $request->input('comment');

        $images = [];
        if (is_array($request->images)) {
            foreach ($request->images as $image) {
                $images[] = $image->store('public/housing-comment-images');
            }
        }

        HousingComment::create(
            [
                'user_id' => auth()->user()->id,
                'housing_id' => $id,
                'comment' => $comment,
                'rate' => $rate,
                'images' => json_encode($images),
            ]
        );

        return redirect()->back();
    }

    public function show($id)
    {
        $menu = Menu::getMenuItems();
        $housing = Housing::with('images', "user", "brand", "city", "county")->where("id", $id)->first();
        $housingSetting = ProjectHouseSetting::where('house_type', $housing->housing_type_id)->get();

        $housingComments = HousingComment::where('housing_id', $id)->where('status', 1)->with('user')->get();
        return view('client.housings.detail', compact('housing', 'menu', 'housingSetting', 'id', 'housingComments'));
    }

    public function list(Request $request)
    {
        $housings = Housing::query();
        if ($request->input('search')) {
            $housings = $housings->where('title', 'LIKE', '%' . $request->input('search') . '%');
        }

        if ($request->input('city')) {
            $housings = $housings->where('city_id', $request->input('city'));
        }

        if ($request->input('housing_type')) {
            $housings = $housings->where('housing_type_id', $request->input('housing_type'));
        }

        $housings = $housings->get();
        if ($request->input('min-price') != "" && $request->input('max-price') != "") {
            $housingsTemp = [];
            $maxPrice = intval(str_replace(",", "", $request->input('max-price')));
            $minPrice = intval(str_replace(",", "", $request->input('min-price')));
            foreach ($housings as $housing) {
                $housingTypeData = json_decode($housing->housing_type_data);
                $housingPrice = floatval($housingTypeData->price[0]);
                if ($housingPrice >= $minPrice && $housingPrice <= $maxPrice) {
                    array_push($housingsTemp, $housing);
                }
            }

            $housings = $housingsTemp;
        }

        if ($request->input('min-square-meters') != "" && $request->input('max-square-meters') != "") {
            $housingsTemp = [];
            $maxSquareMeters = intval(str_replace(",", "", $request->input('max-square-meters')));
            $minSquareMeters = intval(str_replace(",", "", $request->input('min-square-meters')));
            foreach ($housings as $housing) {
                $housingTypeData = json_decode($housing->housing_type_data);
                $housingSquareMeters = floatval($housingTypeData->squaremeters[0]);
                if ($housingSquareMeters >= $minSquareMeters && $housingSquareMeters <= $maxSquareMeters) {
                    array_push($housingsTemp, $housing);
                }
            }
            $housings = $housingsTemp;
        }

        if ($request->input('room_count') != "") {
            $housingsTemp = [];
            foreach ($housings as $housing) {
                $housingTypeData = json_decode($housing->housing_type_data);
                $housingRoomCount = $housingTypeData->room_count[0];
                if ($request->input('room_count') == $housingRoomCount) {
                    array_push($housingsTemp, $housing);
                }
            }
            $housings = $housingsTemp;
        }

        $menu = Menu::getMenuItems();
        $cities = City::get();
        $housingTypes = HousingType::get();

        return view('client.housings.list', compact('housings', 'menu', 'cities', 'housingTypes'));
    }
}
