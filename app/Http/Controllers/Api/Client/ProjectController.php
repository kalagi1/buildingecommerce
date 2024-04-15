<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\CartOrder;
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

    public function getMyProjects(Request $request){
        $userId = auth()->guard('api')->user()->id;

        $fullProjectsCount = Project::where('user_id', $userId)->where('status', $request->input('status'))->count();

        $projects = Project::select(DB::raw('*, (select count(*) from project_housings WHERE name = "off_sale[]" AND value != "[]" AND project_id = projects.id) as offSale'))->where('user_id', $userId)
            ->with("housingType", "county", "city", "neighbourhood", "standOut", "standOut.dopingPricePaymentWait", 'standOut.dopingPricePaymentCancel')
            ->orderByDesc('created_at')
            ->where('status', $request->input('status'))
            ->take($request->input('take'))
            ->skip($request->input('start'))
            ->get();

        $userProjectIds = $projects->pluck('id');

        $projectCounts = $this->getProjectCounts($userProjectIds, '1');
        $paymentPendingCounts = $this->getProjectCounts($userProjectIds, '0');


        $projects = $this->mapProjectCounts($projects, $projectCounts, 'cartOrders');
        $projects = $this->mapProjectCounts($projects, $paymentPendingCounts, 'paymentPending');

        
        return json_encode([
            "data" => $projects,
            "total_projects_count" => $fullProjectsCount
        ]);
    }

    protected function getProjectCounts($userProjectIds, $status)
    {
        return CartOrder::selectRaw('COUNT(*) as count, JSON_UNQUOTE(json_extract(cart, "$.item.id")) as project_id, MAX(status) as status')
            ->whereIn(DB::raw('JSON_UNQUOTE(json_extract(cart, "$.item.id"))'), $userProjectIds)
            ->groupBy('project_id')
            ->where('status', $status)
            ->get();
    }


    protected function mapProjectCounts($projects, $counts, $propertyName)
    {
        return $projects->map(function ($project) use ($counts, $propertyName) {
            $project->$propertyName = $counts->where('project_id', $project->id)->first()->count ?? 0;

            if ($propertyName == 'cartOrders') {
                $totalAmount = CartOrder::where(DB::raw('JSON_UNQUOTE(json_extract(cart, "$.item.id"))'), $project->id)
                    ->where("status", "1")->sum("amount");

                $project->totalAmount = number_format($totalAmount, 3, '.', '');
            }

            return $project;
        });
    }
}
