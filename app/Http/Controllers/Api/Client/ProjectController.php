<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\HousingStatus;
use App\Models\Offer;
use App\Models\Project;
use App\Models\ProjectHousing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ProjectController extends Controller
{
    public function getFeaturedProjects()
    {
        $featuredProjects = Project::select('projects.*')
        ->with("city", "county",'user',"neighbourhood")
        ->with( 'brand', 'roomInfo','listItemValues', 'housingType')
        ->orderBy("created_at", "desc")
        ->where('projects.status', 1)
        ->get();
        return response()->json($featuredProjects);
    }

    public function show($id){
        $project = Project::where('id', $id)->with("brand", "roomInfo", "neighbourhood", "housingType", "county", "city", 'user.projects.housings', 'user.brands', 'user.housings', 'images')->firstOrFail();
        $project->roomInfo = $project->roomInfo;
        $project->brand = $project->brand;
        $project->housingType = $project->housingType;
        $project->county = $project->county;
        $project->city = $project->city;
        $project->user = $project->user;
        $project->user->housings = $project->user->housings;
        $project->user->brands = $project->user->brands;
        $project->images = $project->images;
        $project->listItemValues = $project->listItemValues;

        $projectHousings = ProjectHousing::where('project_id', $project->id)->get();
        $projectHousingsList = [];
        $combinedValues = $projectHousings->map(function ($item) use (&$projectHousingsList) {
            $projectHousingsList[$item->room_order][$item->name] = $item->value;
        });

        $offer = Offer::where('project_id', $project->id)->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))->first();
        if ($project->status == 0) {
            return Response::json([
                'error' => "Proje yayından kaldırılmıştır"
            ], 201); // Status code here
        }

        $statusID = $project->housingStatus->where('housing_type_id', '<>', 1)->first()->housing_type_id ?? 1;
        $status = HousingStatus::find($statusID);
        return json_encode([
            "project" => $project,
            "projectHousingsList" => $projectHousingsList,
            "offer" => $offer,
            "status" => $status
        ]);
    }
}
