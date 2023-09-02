<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HousingType;
use Illuminate\Http\Request;

class HousingTypeController extends Controller
{
    public function index()
    {
        $housingTypes = HousingType::all();
        return view('admin.housing_type.index', compact('housingTypes'));
    }

    public function create()
    {
        return view('admin.housing_type.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:housing_types',
            'active' => 'required|numeric',
        ]);

        HousingType::create($validatedData);

        return redirect()->route('admin.housing_type.index')->with('success', 'Housing type created successfully.');
    }

    public function edit($id)
    {
        $housingType = HousingType::findOrFail($id);
        return view('admin.housing_type.edit', compact('housingType'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:housing_types,slug,' . $id,
            'active' => 'required|numeric',
        ]);

        $housingType = HousingType::findOrFail($id);
        $housingType->update($validatedData);

        return redirect()->route('admin.housing_types.index')->with('success', 'Housing type updated successfully.');
    }

    public function destroy($id)
    {
        $housingType = HousingType::findOrFail($id);
        $housingType->delete();

        return redirect()->route('admin.housing_type.index')->with('success', 'Housing type deleted successfully.');
    }
}
