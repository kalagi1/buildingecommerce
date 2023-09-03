<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Housing;
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
            'housing_type' => 'required|integer'
        ]);

        $room_count = $vData['room_count'];
        $square_meter = $vData['square_meter'];
        $title = $vData['title'];
        $housing_type = $vData['housing_type'];
        unset($postData['_token']);
        unset($postData['room_count']);
        unset($postData['housing_type']);
        unset($postData['square_meter']);
        unset($postData['title']);
        Housing::create(
            [
                'room_count' => $room_count,
                'square_meter' => $square_meter,
                'title' => $title,
                'housing_type_id' => $housing_type,
                'housing_type_data' => json_encode($postData)
            ]
        );
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