<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DefaultMessage;
use App\Models\HousingStatus;
use App\Models\HousingType;
use App\Models\Log;
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
        $projectStatuses = [
            1 => "Aktif",
            0 => "Pasif",
            2 => "Admin Onayı Bekliyor",
            3 => "Admin Tarafından Reddedildi"
        ];
        $projects = Project::orderByDesc('created_at')->get();
        return view('admin.projects.index',compact('projects','projectStatuses'));
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
        $defaultMessages = DefaultMessage::get();
        $project = Project::where('id',$id)->first();
        $housingTypeData = HousingType::where('id',$project->housing_type_id)->first();
        $housingTypeData = json_decode($housingTypeData->form_json);
        $housingData = $project->roomInfo->keyBy('name');
        return view('admin.projects.detail',compact('project','housingTypeData','housingData','defaultMessages'));
    }

    public function setStatus($projectId,Request $request){
        $reason = "";
        $isRejected = 0;
        if($request->input('status') == 3){
            $isRejected = 1;
            $reason = $request->input('reason');
        }else if($request->input('status') == 1){
            $reason = "Başarıyla projeniz aktife alındı";
        }else{
            $reason = "Projeniz pasife alındı";
        }
        $project = Project::where('id',$projectId)->firstOrFail();
        Project::where('id',$projectId)->update([
            "status" => $request->input('status')
        ]);

        Log::create([
            "item_type" => 1,
            "item_id" => $projectId,
            "reason" => $reason,
            "is_rejected" => $isRejected,
            "user_id" => auth()->user()->id,
        ]);

        return json_encode([
            "status" => true
        ]);
    }

    public function setStatusGet($projectId){
        $project = Project::where('id',$projectId)->firstOrFail();
        if($project->status == 0 || $project->status == 2){
            Project::where('id',$projectId)->update([
                "status" => 1
            ]);
        }else{
            Project::where('id',$projectId)->update([
                "status" => 0
            ]);
        }
        

        if($project->status == 1){
            Log::create([
                "item_type" => 1,
                "item_id" => $projectId,
                "reason" => "Admin tarafından pasife alındı",
                "is_rejected" => 0,
                "user_id" => auth()->user()->id,
            ]);
        }else{
            Log::create([
                "item_type" => 1,
                "item_id" => $projectId,
                "reason" => "Admin tarafından aktife alındı",
                "is_rejected" => 0,
                "user_id" => auth()->user()->id,
            ]);
        }

        return redirect()->route('admin.projects.detail',$projectId);
    }

    public function logs($projectId){
        $logs = Log::where('item_type',1)->where('item_id',$projectId)->orderByDesc('created_at')->with('user')->get();
        return view('admin.projects.logs',compact('logs'));
    }
}
