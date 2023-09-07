<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HousingStatus;
use App\Models\HousingType;
use App\Models\Project;
use App\Models\ProjectHousings;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.project.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $housing_types = HousingType::all();
        $housing_status = HousingStatus::all();
        return view('admin.project.create', ['housing_types' => $housing_types, 'housing_status' => $housing_status]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $allDatas = $request->all();
        return $allDatas;
        $vData = $request->validate([
            'projectData.project_title' => 'required|string',
            'projectData.address' => 'required|string|max:128',
            'projectData.housing_type' => 'required|integer',
            'projectData.image' => 'required',
            'projectData.status' => 'required|in:1,2,3',
        ]);
        return $vData;
        $dynamicDatas = $request->dynamicData;
        $projectId = Project::create($vData);
        foreach ($dynamicDatas as $data) {
            $data[] = ['project_id' => $projectId];
        }
        return $dynamicDatas;
        ProjectHousings::insert($dynamicDatas);
        return redirect()->route('admin.project.create')->with('success', 'Project and housings created successfully');
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