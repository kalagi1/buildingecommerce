<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\City;
use App\Models\Housing;
use App\Models\HousingStatus;
use App\Models\HousingType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class HousingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $housing = Housing::select(
            'housings.id',
            'housings.title AS housing_title',
            'housings.address',
            'housings.created_at',
            'housing_types.title as housing_type',
            'housing_types.slug',
            'housing_types.form_json'
        )->leftJoin('housing_types', 'housing_types.id', '=', 'housings.housing_type_id')
            ->get();
        return view('admin.housings.index', ['housing' => $housing]);
        //
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $brands = Brand::where('user_id', Auth::user()->id)->where('status', 1)->get();
        $cities = City::get();
        $housing_types = HousingType::all();
        $housing_status = HousingStatus::all();
        return view('admin.housings.create', ['housing_types' => $housing_types, 'housing_status' => $housing_status, 'cities' => $cities, 'brands' => $brands]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $postData = $request->all();
        $vData = $request->validate([
            'title' => 'required|string',
            'address' => 'required|string|max:128',
            'housing_type' => 'required|integer',
            'status' => 'required|in:1,2,3',
            'location' => 'required|string',
            "brand_id" => "required",
            "city_id" => "required",
            "county_id" => "required",
        ]);

        $title = $vData['title'];
        $address = $vData['address'];
        $housing_type = $vData['housing_type'];
        $status = $vData['status'];
        $location = explode(',', $vData['location']);
        $latitude = $location[0];
        $longitude = $location[1];

        $unsetKeys = [
            //Housing type için gelen form inputlarını ayırt etmek için
            '_token',
            'housing_type',
            'address',
            'title',
            'status',
            'location',
            'description',
            'brand_id',
            'city_id',
            "county_id",
        ];

        $files = [];

        for ($k = 0; $k < count($request->file('images')); $k++) {
            $image = $request->file('images')[$k][0];
            $imageName = Str::slug(Str::slug($request->input('title'))) . '-' . $k . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/housing_images'), $imageName);
            array_push($files, $imageName);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image')[0];
            $imageName = Str::slug($request->input('title')) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/housing_images'), $imageName);
        }

        $postData['images'] = json_encode($files);
        $postData['image'] = $imageName;

        foreach ($unsetKeys as $key) {
            unset($postData[$key]);
        }

        $lastId = Housing::create(
            [
                'address' => $address,
                'title' => $title,
                'housing_type_id' => $housing_type,
                'status_id' => $status,
                'housing_type_data' => json_encode($postData),
                'user_id' => 1,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'brand_id' => $request->input('brand_id'),
                'city_id' => $request->input('city_id'),
                'county_id' => $request->input('county_id'),
                'description' => $request->input('description'),
            ]
        )->id;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
