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
        $projects = Project::get();
        return view('admin.projects.index',compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $housing_types = HousingType::all();
        $housing_status = HousingStatus::all();
        return view('admin.projects.create', ['housing_types' => $housing_types, 'housing_status' => $housing_status]);
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
            'projectData.status' => 'required|in:1,2,3',
        ]);
        $dynamicDatas = $request->dynamicData;
        $projectId = Project::create($vData);
        foreach ($dynamicDatas as $data) {
            $data[] = ['project_id' => $projectId];
        }
        ProjectHousings::insert($dynamicDatas);
        return redirect()->route('admin.projects.create')->with('success', 'Project and housings created successfully');
    }

    public function detail($id){
        $project = Project::where('id',$id)->first();
        $housingTypeData = HousingType::where('id',$project->housing_type_id)->first();
        $housingTypeData = json_decode($housingTypeData->form_json);
        $housingData = $project->roomInfo->keyBy('name');
        return view('admin.projects.detail',compact('project','housingTypeData','housingData'));
    }

    public function setStatus($projectId){
        $project = Project::where('id',$projectId)->firstOrFail();
        Project::where('id',$projectId)->update([
            "status" => !$project->status
        ]);

        return redirect()->route('admin.projects.detail',$projectId);
    }

    public function logs(){
        
    }
}
