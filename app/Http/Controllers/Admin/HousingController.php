<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Housing;
use App\Models\HousingImages;
use App\Models\HousingType;
use Illuminate\Http\Request;

class HousingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $housing = Housing::select(
            'housings.title AS housing_title',
            'housings.room_count',
            'housings.square_meter',
            'housings.address',
            'housings.created_at',
            'housing_types.title as housing_type',
            'housing_types.slug',
            'housing_types.form_json'
        )->leftJoin('housing_types', 'housing_types.id', '=', 'housings.housing_type_id')
            ->get();
        return view('admin.housing.index', ['housing' => $housing]);
        //
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $housing_types = HousingType::all();
        return view('admin.housing.create', ['housing_types' => $housing_types]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $postData = $request->all();
        $vData = $request->validate([
            'room_count' => 'required|string|max:4',
            'square_meter' => 'required|integer',
            'title' => 'required|string',
            'address' => 'required|string|max:128',
            'housing_type' => 'required|integer',
            'images' => 'required|array',
            'secondhand' => 'required|in:1,0',
            'price' => 'required|integer'
        ]);

        $room_count = $vData['room_count'];
        $square_meter = $vData['square_meter'];
        $title = $vData['title'];
        $address = $vData['address'];
        $housing_type = $vData['housing_type'];
        $images = $vData['images'];
        $secondhand = $vData['secondhand'];
        $price = $vData['price'];

        unset($postData['_token']); //Housing type için gelen form inputlarını ayırt etmek için
        unset($postData['room_count']);
        unset($postData['housing_type']);
        unset($postData['square_meter']);
        unset($postData['images']);
        unset($postData['address']);
        unset($postData['title']);
        unset($postData['secondhand']);
        unset($postData['price']);

        $lastId = Housing::create(
            [
                'room_count' => $room_count,
                'square_meter' => $square_meter,
                'address' => $address,
                'title' => $title,
                'housing_type_id' => $housing_type,
                'secondhand' => $secondhand,
                'price' => $price,
                'housing_type_data' => json_encode($postData) //dinamik formdan gelen veriler
            ]
        )->id;

        $imageData = [];
        foreach ($images as $image) {

            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image_path = $image->storeAs('housing/images/' . $lastId, $fileName, 'public');
            $imageData[] = [
                'imagepath' => $image_path,
                'housing_id' => $lastId
            ];
        }

        HousingImages::insert($imageData);
        return redirect()->route('admin.housing.create')->with('success', 'Housing created successfully');
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