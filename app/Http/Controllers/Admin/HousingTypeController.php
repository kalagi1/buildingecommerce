<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HousingType;
use Illuminate\Http\Request;

class HousingTypeController extends Controller
{
    public function getHousingTypeForm(Request $req)
    {
        $ht = HousingType::where('id', $req->id)->first();
        return response()->json($ht);
    }
    public function index()
    {
        $housingTypes = HousingType::all();
        return view('admin.housing_types.index', compact('housingTypes'));
    }

    public function create()
    {
        return view('admin.housing_types.create');
    }

    public function store(Request $request)
    { //validation hataları için türkçe dil paketi yüklenecek
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:housing_types',
            'active' => 'required|numeric',
            'form_json' => 'required|string'
        ]);

        HousingType::create($validatedData);

        return redirect()->route('admin.housing_types.create')->with('success', 'Housing type created successfully.');
    }

    public function edit($id)
    {
        $housingType = HousingType::findOrFail($id);
        return view('admin.housing_types.edit', compact('housingType'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:housing_types,slug,' . $id,
            'active' => 'required|numeric',
            'form_json' => 'required|string'
        ]);

        $housingType = HousingType::findOrFail($id);
        $housingType->update($validatedData);

        return redirect()->route('admin.housing_types.index')->with('success', 'Housing type updated successfully.');
    }

    public function destroy($id)
    {
        $housingType = HousingType::findOrFail($id);
        $housingType->delete();

        return redirect()->route('admin.housing_types.index')->with('success', 'Housing type deleted successfully.');
    }
}