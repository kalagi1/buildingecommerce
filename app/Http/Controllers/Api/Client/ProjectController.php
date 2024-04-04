<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\HousingStatus;
use App\Models\HousingTypeParent;
use App\Models\Offer;
use App\Models\Project;
use App\Models\ProjectHouseSetting;
use App\Models\ProjectHousing;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function show($projectID){
        $project = Project::where('id', $projectID)->where("status", 1)->with("brand", "blocks", "neighbourhood", "housingType", "county", "city",'listItemValues', 'user.brands', 'user.housings', 'images')->first();
        if (!$project) {
            return Response::json([
                'error' => "Proje yayından kaldırılmıştır"
            ], 201); // Status code here
        }

        $turkishAlphabet = [
            'A', 'B', 'C', 'Ç', 'D', 'E', 'F', 'G', 'Ğ', 'H', 'I', 'İ', 'J', 'K', 'L',
            'M', 'N', 'O', 'Ö', 'P', 'R', 'S', 'Ş', 'T', 'U', 'Ü', 'V', 'Y', 'Z'
        ];


        if ($project) {
            $projectHousingSetting = ProjectHouseSetting::orderBy('order')->get();


            $projectCartOrders = DB::table('cart_orders')
                ->select(
                    DB::raw('JSON_EXTRACT(cart, "$.item.housing") as housing_id'),
                    DB::raw('JSON_EXTRACT(cart, "$.item.qt") as qt'),
                    DB::raw('JSON_EXTRACT(cart, "$.item.qt") as qt_total'), // Added for total qt
                    'cart_orders.status',
                    'cart_orders.user_id',
                    'cart_orders.store_id',
                    'cart_orders.is_show_user',
                    'cart_orders.id',
                    'users.name',
                    'users.mobile_phone',
                    'users.phone'
                )
                ->leftJoin('users', 'cart_orders.user_id', '=', 'users.id')
                ->where(DB::raw('JSON_EXTRACT(cart, "$.type")'), 'project')
                ->where(DB::raw('JSON_EXTRACT(cart, "$.item.id")'), $project->id)
                ->orderByRaw('CAST(housing_id AS SIGNED) ASC')
                ->get()
                ->keyBy("housing_id");

            $sumCartOrderQt = DB::table('cart_orders')
                ->select(
                    DB::raw('JSON_EXTRACT(cart, "$.item.housing") as housing_id'),
                    DB::raw('JSON_EXTRACT(cart, "$.item.qt") as qt')
                )
                ->leftJoin('users', 'cart_orders.user_id', '=', 'users.id')
                ->where(DB::raw('JSON_EXTRACT(cart, "$.type")'), 'project')
                ->where(DB::raw('JSON_EXTRACT(cart, "$.item.id")'), $project->id)
                ->orderByRaw('CAST(housing_id AS SIGNED) ASC')
                ->get();


            $sumCartOrderQt = $sumCartOrderQt->groupBy('housing_id')
                ->mapWithKeys(function ($group) {
                    return [
                        $group->first()->housing_id => [
                            'housing_id' => $group->first()->housing_id,
                            'qt_total' => $group->sum('qt'),
                        ]
                    ];
                })
                ->all();

            $offer = Offer::where('project_id', $project->id)->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))->first();
            
            $projectHousings = ProjectHousing::where('project_id', $project->id)->where('room_order','>',0)->where('room_order','<=',10)->get();
            $projectHousingsList = [];
            $projectHousings->map(function ($item) use (&$projectHousingsList) {
                $projectHousingsList[$item->room_order][$item->name] = $item->value;
            });


            $parent = HousingTypeParent::where("slug", $project->step1_slug)->first();
            
        } else {
            return redirect('/')
                ->with('error', 'İlan yayından kaldırıldı veya bulunamadı.');
        }

        return json_encode([
            "project" => $project,
            "offer" => $offer,
            "projectCartOrders" => $projectCartOrders,
            "projectHousingsList" => $projectHousingsList,
            "sumCartOrderQt" => $sumCartOrderQt,
            "parent" => $parent,
            "projectHousingSetting" => $projectHousingSetting
        ]);
    }

    public function getRooms($projectId,Request $request){
        $projectHousings = ProjectHousing::where('project_id', $projectId)->where('room_order','>',$request->input('start'))->where('room_order','<=',$request->input('end'))->get();
        $projectHousingsList = [];
        $projectHousings->map(function ($item) use (&$projectHousingsList) {
            $projectHousingsList[$item->room_order][$item->name] = $item->value;
        });
        return json_encode([
            "housings" => $projectHousingsList
        ]);
    }

    public function getFullProjects(Request $request){
        $request->validate([
            "start" => "required",
            "end" => "required"
        ]);

        $projectCount = Project::count();

        $projects = Project::query();

        if($request->input('start')){
            $projects = $projects->skip($request->input('start'));
        }

        if($request->input('end')){
            $projects = $projects->take($request->input('end') - $request->input('start'));
        }

        $projects = $projects->get();

        return json_encode([
            "data" => $projects,
            "count" => $projectCount
        ]);
    }
}
