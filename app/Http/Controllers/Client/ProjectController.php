<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\Brand;
use App\Models\CartOrder;
use App\Models\City;
use App\Models\Filter;
use App\Models\Housing;
use App\Models\HousingStatus;
use App\Models\HousingType;
use App\Models\HousingTypeParent;
use App\Models\Menu;
use App\Models\Offer;
use App\Models\Project;
use App\Models\ProjectHouseSetting;
use App\Models\ProjectHousing;
use App\Models\ProjectImage;
use App\Models\StandOutUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function index($slug,$id,Request $request)
    {
        $menu = Cache::rememberForever('menu', function() {
            return Menu::getMenuItems();
        });

        $project = Project::where('slug', $slug)->where("id",$id)
        ->with("brand","blocks",'listItemValues', "neighbourhood","roomInfo", "housingType", "county", "city", 'user.brands', 'user.housings', 'images')
        ->firstOrFail();
        $projectHousing = $project->roomInfo->keyBy('name');


        $projectCartOrders = DB::table('cart_orders')
        ->select(DB::raw('JSON_EXTRACT(cart, "$.item.housing") as housing_id , status'))
        ->where(DB::raw('JSON_EXTRACT(cart, "$.type")'), 'project')
        ->where(DB::raw('JSON_EXTRACT(cart, "$.item.id")'), $project->id)
        ->orderByRaw('CAST(housing_id AS SIGNED) ASC')
        ->get()
        ->keyBy("housing_id");

        $salesCloseProjectHousingCount = ProjectHousing::where('name','off_sale[]')->where('project_id',$project->id)->where('value','!=','[]')->count();
        $lastHousingCount = 0;

        $projectHousings = ProjectHousing::where('project_id',$project->id)->get();
        $projectHousingsList = [];
        $combinedValues = $projectHousings->map(function ($item) use(&$projectHousingsList) {
            $projectHousingsList[$item->room_order][$item->name] = $item->value;
        });


        $offer = Offer::where('project_id', $project->id)->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))->get();
        $projectCounts = CartOrder::selectRaw('COUNT(*) as count, JSON_UNQUOTE(json_extract(cart, "$.item.id")) as project_id, MAX(status) as status')
            ->where(DB::raw('JSON_UNQUOTE(json_extract(cart, "$.item.id"))'), $project->id)
            ->groupBy('project_id')
            ->where("status", "1")
            ->get();

            $projectHousingSetting = ProjectHouseSetting::orderBy('order')->get();

        $project->cartOrders = $projectCounts->where('project_id', $project->id)->first()->count ?? 0;
        $selectedPage = $request->input('selected_page') ?? 0;
        $blockIndex = $request->input('block_id') ?? 0;
        $startIndex = 0;

        if($project->have_blocks){
            $currentBlockHouseCount = $project->blocks[$blockIndex]->housing_count;
        }else{
            $currentBlockHouseCount = 0;
        }
        for($i = 0; $i < $blockIndex; $i++){
            $startIndex += $project->blocks[$i]->housing_count;
        }
        $endIndex = 20 + $startIndex;
        $parent = HousingTypeParent::where("slug",$project->step1_slug)->first();
        $status = HousingStatus::where("id", $project->status_id)->first();

        return view('client.projects.index', compact('projectHousingsList','projectHousing','projectHousingSetting','parent','status','salesCloseProjectHousingCount','lastHousingCount','currentBlockHouseCount','menu', "offer", 'project','projectCartOrders','startIndex','blockIndex','endIndex'));

    }
    
    public function ajaxIndex($slug,Request $request){
        $menu = Cache::rememberForever('menu', function() {
            return Menu::getMenuItems();
        });

        $project = Project::where('slug', $slug)
        ->with("brand","blocks",'listItemValues', "roomInfo", "housingType", "county", "city", 'user.brands', 'user.housings', 'images')
        ->firstOrFail();

        $projectCartOrders = DB::table('cart_orders')
        ->select(DB::raw('JSON_EXTRACT(cart, "$.item.housing") as housing_id , status'))
        ->where(DB::raw('JSON_EXTRACT(cart, "$.type")'), 'project')
        ->where(DB::raw('JSON_EXTRACT(cart, "$.item.id")'), $project->id)
        ->orderByRaw('CAST(housing_id AS SIGNED) ASC')
        ->get()
        ->keyBy("housing_id");


        $offer = Offer::where('project_id', $project->id)->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))->first();
        $projectCounts = CartOrder::selectRaw('COUNT(*) as count, JSON_UNQUOTE(json_extract(cart, "$.item.id")) as project_id, MAX(status) as status')
            ->where(DB::raw('JSON_UNQUOTE(json_extract(cart, "$.item.id"))'), $project->id)
            ->groupBy('project_id')
            ->where("status", "1")
            ->get();

        $project->cartOrders = $projectCounts->where('project_id', $project->id)->first()->count ?? 0;
        $selectedPage = $request->input('selected_page') ?? 0;
        $blockIndex = $request->input('block_id') ?? 0;
        $startIndex = 0;
        $lastHousingCount = 0;
        for($i = 0; $i < $blockIndex; $i++){
            $startIndex += $project->blocks[$i]->housing_count;
            $lastHousingCount += $project->blocks[$i]->housing_count;
        }
        $blockHousingCount = 0;
        for($i = 0; $i < $blockIndex + 1; $i++){
            $blockHousingCount += $project->blocks[$i]->housing_count;
        }
        $startIndex = $startIndex + ($selectedPage * 20);
        $endIndex = $startIndex + 20;
        if($endIndex > $blockHousingCount ){
            $endIndex = $blockHousingCount;
        }
        $salesCloseProjectHousingCount = ProjectHousing::where('name','off_sale[]')->where('project_id',$project->id)->where('value','!=','[]')->count();
        $currentBlockHouseCount = $project->blocks[$blockIndex]->housing_count;
        return view('client.projects.index', compact('salesCloseProjectHousingCount','currentBlockHouseCount','lastHousingCount','menu', "offer", 'project','projectCartOrders','endIndex','blockIndex','startIndex'))->render();
    }

    public function detail($slug)
    {
        $menu = Menu::getMenuItems();
        $project = Project::where('slug', $slug)->with("brand", "roomInfo","neighbourhood", "housingType", "county", "city", 'user.projects.housings', 'user.brands', 'user.housings', 'images')->firstOrFail();
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

        $projectHousings = ProjectHousing::where('project_id',$project->id)->get();
        $projectHousingsList = [];
        $combinedValues = $projectHousings->map(function ($item) use(&$projectHousingsList) {
            $projectHousingsList[$item->room_order][$item->name] = $item->value;
        });

        $offer = Offer::where('project_id', $project->id)->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))->first();
        if ($project->status == 0) {
            return view('client.projects.product_not_found', compact('menu', 'project'));
        }

        return view('client.projects.detail', compact('menu','projectHousingsList', 'project', 'offer'));
    }

    public function projectPaymentPlan(Request $request)
    {
        $project = Project::with("roomInfo")->where('id', $request->input('project_id'))->first();
        return $project;
    }

    public function brandProjects($id)
    {
        $menu = Menu::getMenuItems();
        $brand = Brand::where('id', $id)->with("user", "projects", "housings")->first();
        return view('client.projects.brand_projects', compact('menu', 'brand'));
    }

    public function projectList(Request $request)
    {
        $projects = Project::where('status', 1)->orderBy('view_count');
        if ($request->input("search")) {
            $projects = $projects->where('project_title', 'LIKE', '%' . $request->input('search') . '%');
        }

        if ($request->input("city_id")) {
            $projects = $projects->where('city_id', $request->input("city_id"));
        }

        if ($request->input("housing_type_id")) {
            $projects = $projects->where('housing_type_id', $request->input("housing_type_id"));
        }

        $housingTypes = HousingType::where('active', 1)->get();
        $housingStatus = HousingStatus::get();
        $cities = City::get();
        $projects = $projects->get();
        $menu = Menu::getMenuItems();
        return view('client.projects.list', compact('menu', 'projects', 'housingTypes', 'housingStatus', 'cities'));
    }

    public function allMenuProjects($slug = null, $type = null, $optional = null, $title = null, $check = null)
    {
        $deneme = null;
        if ($slug == "al-sat-acil") {
            $deneme = "al-sat-acil";
        }

        $nslug = HousingType::where('slug', ['konut' => 'daire'][$slug] ?? $slug)->first()->id ?? 0;

        $parameters = [$slug, $type, $optional, $title, $check];
        $secondhandHousings = [];
        $projects = [];
        $slug = [];
        $slugName = [];

        $housingTypeSlug = [];
        $housingTypeSlugName = [];
        $housingTypeParentSlug = [];

        $housingType = [];
        $housingTypeName = [];
        $housingTypeSlug = [];

        $opt = null;
        $checkTitle = null;
        $is_project = null;

        $optName = [];

        if ($deneme) {
            $slug = "al-sat-acil";
            $slugName = "Al Sat Acil";
            $secondhandHousings = Housing::with('images')
                ->select(
                    'housings.id',
                    'housings.title AS housing_title',
                    'housings.created_at',
                    'housings.step1_slug',
                    'housings.step2_slug',
                    'housing_types.title as housing_type_title',
                    'housings.housing_type_data',
                    'project_list_items.column1_name as column1_name',
                    'project_list_items.column2_name as column2_name',
                    'project_list_items.column3_name as column3_name',
                    'project_list_items.column4_name as column4_name',
                    'project_list_items.column1_additional as column1_additional',
                    'project_list_items.column2_additional as column2_additional',
                    'project_list_items.column3_additional as column3_additional',
                    'project_list_items.column4_additional as column4_additional',
                    'housings.address',
                        \Illuminate\Support\Facades\DB::raw('(SELECT status FROM cart_orders WHERE JSON_EXTRACT(cart, "$.type") = "housing" AND JSON_EXTRACT(cart, "$.item.id") = housings.id) AS sold'),
                    'cities.title AS city_title', // city tablosundan veri çekme
                    'districts.ilce_title AS county_title' // district tablosundan veri çekme
                )
                ->leftJoin('housing_types', 'housing_types.id', '=', 'housings.housing_type_id')
                ->leftJoin('project_list_items', 'project_list_items.housing_type_id', '=', 'housings.housing_type_id')
                ->leftJoin('housing_status', 'housings.status_id', '=', 'housing_status.id')
                ->leftJoin('cities', 'cities.id', '=', 'housings.city_id') // city tablosunu join etme
                ->leftJoin('districts', 'districts.ilce_key', '=', 'housings.county_id') // district tablosunu join etme
                ->where('housings.status', 1)
                ->whereJsonContains('housings.housing_type_data->buysellurgent1', 'Evet')
                ->where('project_list_items.item_type', 2)
                ->orderByDesc('housings.created_at')
                ->get();

        }

        foreach ($parameters as $index => $paramValue) {
            if ($paramValue) {

                if ($paramValue == "satilik" || $paramValue == "kiralik" || $paramValue == "gunluk-kiralik") {
                    $opt = $paramValue;
                    if ($opt) {
                        $opt = $opt;
                        if ($opt == "kiralik") {
                            $optName = "Kiralık";
                        }elseif ($opt == "satilik")  {
                            $optName = "Satılık";
                        }else {
                            $optName = "Günlük Kiralık";
                        }
                    }
                } else {
                    $item1 = HousingStatus::where('slug', $paramValue)->first();
                    $housingTypeParent = HousingTypeParent::where('slug', $paramValue)->first();
                    $housingType = HousingType::where('slug', $paramValue)->first();


                    if ($item1) {
                        $is_project = $item1->is_project;
                        $slugName = $item1->name;
                        $slug = $item1->id;
                    }

                    if ($housingTypeParent) {
                        $housingTypeSlugName = $housingTypeParent->title;
                        $housingTypeParentSlug = $housingTypeParent->slug;
                    }

                    if ($housingType) {
                        $housingTypeName = $housingType->title;
                        $housingTypeSlug = $housingType->slug;
                        $housingType = $housingType->id;
                        $newHousingType = $housingType;
                    }

                    
                }

                             
                if ($housingTypeParent && $housingTypeParent->slug === "arsa") {
                    $checkTitle = isset($parameters[count($parameters) - 2]) ? $parameters[count($parameters) - 2] : null;
                }
                

            }
        }

        if ($slug) {
            if ($is_project) {
                $oncelikliProjeler = StandOutUser::where('housing_type_id', $slug)->pluck('item_id')->toArray();
                $firstProjects = Project::with("city", "county")->whereIn('id', $oncelikliProjeler)->get();

                $query = Project::query()->where('status', 1)->whereNotIn('id', $oncelikliProjeler)->orderBy('created_at', 'desc');

                if ($housingTypeParentSlug) {
                    $query->where("step1_slug", $housingTypeParentSlug);
                }

                if ($opt) {
                    $query->where("step2_slug", $opt);
                }

                if ($housingType) {
                    $query->where('housing_type_id', $housingType);
                }

                $query->whereHas('housingTypes', function ($query) use ($slug) {
                    $query->where('housing_type_id', $slug);
                });

                $anotherProjects = $query->get();
                $projects = StandOutUser::join("projects", 'projects.id', '=', 'stand_out_users.item_id')->select("projects.*")->whereIn('item_id', $oncelikliProjeler)
                    ->orderBy('id', 'asc')
                    ->get()
                    ->concat($anotherProjects);

            } else {
                $query = Housing::with('images', "city", "county");

                if ($housingTypeParentSlug) {
                    $query->where("step1_slug", $housingTypeParentSlug);
                }

                if ($housingType) {
                    $query->where('housing_type_id', $housingType);
                }

                if ($opt) {
                    $query->where('step2_slug', $opt);
                }

                $query->whereHas('housingStatus', function ($query) use ($slug) {
                    $query->where('housing_status_id', $slug);
                });
                $secondhandHousings = $query->get();
            }

        } else {
            $query = Housing::with('images', "city", "county");

            if ($housingTypeParentSlug) {
                $query->where("step1_slug", $housingTypeParentSlug);
            }

            if ($housingType) {
                $query->where('housing_type_id', $newHousingType);
            }

            if ($opt) {
                $query->where('step2_slug', $opt);
            }
            if ($checkTitle) {
                $query->where(function ($q) use ($checkTitle) {
                    $q->orWhereJsonContains('housing_type_data->room_count', $checkTitle)
                      ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(housing_type_data, '$.room_count[0]')) = ?", [$checkTitle]);
                });
            }
            
            $secondhandHousings = $query->get();
        }
        
        $filters = [];

        $housingStatuses = HousingStatus::get();
        $cities = City::get();
        $menu = Menu::getMenuItems();
        $newHousingType = HousingType::where('slug',$housingTypeSlug)->first();
        if ($projects) {
            if ($housingTypeSlug && $newHousingType) {
                $filtersDb = Filter::where('item_type', 1)->where('housing_type_id', $newHousingType->id)->get()->keyBy('filter_name')->toArray();
                $filtersDbx = array_keys($filtersDb);
                $housingTypeData = json_decode($newHousingType->form_json);
        
                foreach ($housingTypeData as $data) {
                    if (in_array(str_replace('[]', '', $data->name), $filtersDbx)) {
                        $filterItem = [
                            "label" => $data->label,
                            "type" => $data->type,
                            "name" => str_replace('[]', '', $data->name),
                        ];
        
                        if ($data->type == "select" || $data->type == "checkbox-group") {
                            $filterItem["values"] = $data->values;
                        } else if ($data->type == "text") {
                            $filterItem['text_style'] = $filtersDb[str_replace('[]', '', $data->name)]['text_style'];
                        }
        
                        // Eğer toggle varsa, toggle değerini ekleyin
                        if (isset($data->toggle)) {
                            $filterItem['toggle'] = $data->toggle;
                        }
        
                        array_push($filters, $filterItem);
                    }
                }
            }
        } else {
            if ($housingTypeSlug && $newHousingType) {
                $filtersDb = Filter::where('item_type', 2)->where('housing_type_id', $newHousingType->id)->get()->keyBy('filter_name')->toArray();
                $filtersDbx = array_keys($filtersDb);
                $housingTypeData = json_decode($newHousingType->form_json);
        
                foreach ($housingTypeData as $data) {
                    if (in_array(str_replace('[]', '', $data->name), $filtersDbx)) {
                        $filterItem = [
                            "label" => $data->label,
                            "type" => $data->type,
                            "name" => str_replace('[]', '', $data->name),
                        ];
        
                        if ($data->type == "select" || $data->type == "checkbox-group") {
                            $filterItem["values"] = $data->values;
                        } else if ($data->type == "text") {
                            $filterItem['text_style'] = $filtersDb[str_replace('[]', '', $data->name)]['text_style'];
                        }
        
                        // Eğer toggle varsa, toggle değerini ekleyin
                        if (isset($data->toggle)) {
                            $filterItem['toggle'] = $data->toggle;
                        }
        
                        array_push($filters, $filterItem);
                    }
                }
            }
        }
        


        return view('client.all-projects.menu-list', compact('filters','nslug','checkTitle', 'menu', "opt", "housingTypeSlug", "housingTypeParentSlug", "optional", "optName", "housingTypeName", "housingTypeSlug", "housingTypeSlugName", "slugName", "housingTypeParent", "housingType", 'projects', "slug", 'secondhandHousings', 'housingStatuses', 'cities', 'title', 'type'));
    }

    public function allProjects($slug)
    {

        // HousingStatus modelini kullanarak slug'a göre durumu bulun
        $status = HousingStatus::where('slug', $slug)->first();
        $secondhandHousings = [];
        $projects = [];

        // HousingStatus bulunamazsa hata sayfasına yönlendirin
        if (!$status) {
            $type = HousingType::where('slug', $slug)->first();
            if (!$type) {
                abort(404); // Eğer HousingType bulunamazsa 404 hatası döndürün veya başka bir işlem yapabilirsiniz.
            }
            $title = $type->title;
            $projects = Project::with("city", "county")->where("housing_type_id", $type->id)->get();

        } else {
            if (!$status) {
                abort(404); // Eğer HousingType bulunamazsa 404 hatası döndürün veya başka bir işlem yapabilirsiniz.
            }
            $title = $status->name;
            if ($status->id == 1) {
                $projects = Project::all();
            } elseif ($status->id == 4) {
                $projects = [];
                $secondhandHousings = Housing::with('images', "city", "county")->get();
            } else {
                $oncelikliProjeler = StandOutUser::where('housing_type_id', $status->id)->pluck('item_id')->toArray();
                $firstProjects = Project::with("city", "county")->whereIn('id', $oncelikliProjeler)->get();

                $anotherProjects = Project::with("city", "county")->whereNotIn('id', $oncelikliProjeler)
                    ->orderBy('created_at', 'desc') 
                    ->get();

                $projects = StandOutUser::join("projects", 'projects.id', '=', 'stand_out_users.item_id')->select("projects.*")->whereIn('project_id', $oncelikliProjeler)
                    ->orderBy('id', 'asc')
                    ->get()
                    ->concat($anotherProjects);
            }
        }

        $housingTypes = HousingType::where('active', 1)->get();
        $housingStatuses = HousingStatus::get();
        $cities = City::get();
        $menu = Menu::getMenuItems();

        return view('client.all-projects.list', compact('menu', 'projects', 'secondhandHousings', 'housingTypes', 'housingStatuses', 'cities', 'title'));
    }

    public function projectHousingDetail($projectSlug, $housingOrder,Request $request)
    {
        $menu = Menu::getMenuItems();
        $project = Project::where('slug', $projectSlug)->with("brand","neighbourhood", "housingType", "county", "city", 'user.brands', 'user.housings', 'images')->firstOrFail();
        $projectHousing = $project->roomInfo->keyBy('name');
        $projectImages = ProjectImage::where('project_id', $project->id)->get();
        $projectHousingSetting = ProjectHouseSetting::orderBy('order')->get();
        $projectCartOrders = DB::table('cart_orders')
        ->select(DB::raw('JSON_EXTRACT(cart, "$.item.housing") as housing_id , status'))
        ->where(DB::raw('JSON_EXTRACT(cart, "$.type")'), 'project')
        ->where(DB::raw('JSON_EXTRACT(cart, "$.item.id")'), $project->id)
        ->orderByRaw('CAST(housing_id AS SIGNED) ASC')
        ->get()
        ->keyBy("housing_id");
        $offer = Offer::where('project_id', $project->id)->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))->first();
        $selectedPage = $request->input('selected_page') ?? 0;
        $blockIndex = $request->input('block_id') ?? 0;
        $startIndex = 0;
        $lastHousingCount = 0;
        if($project->have_blocks){
            $currentBlockHouseCount = $project->blocks[$blockIndex]->housing_count;
        }else{
            $currentBlockHouseCount = 0;
        }
        for($i = 0; $i < $blockIndex; $i++){
            $startIndex += $project->blocks[$i]->housing_count;
        }
        $projectHousings = ProjectHousing::where('project_id',$project->id)->get();
        $projectHousingsList = [];
        $combinedValues = $projectHousings->map(function ($item) use(&$projectHousingsList) {
            $projectHousingsList[$item->room_order][$item->name] = $item->value;
        });

        $endIndex = $project->house_count;

        $parent = HousingTypeParent::where("slug",$project->step1_slug)->first();

        return view('client.projects.project_housing', compact('projectHousingsList','blockIndex',"parent",'lastHousingCount','projectCartOrders','offer','endIndex','startIndex','currentBlockHouseCount','menu', 'project', 'housingOrder', 'projectHousingSetting', 'projectHousing'));
    }

    public function projectHousingDetailAjax($projectSlug,$housingOrder,Request $request)
    {
        $menu = Menu::getMenuItems();
        $project = Project::where('slug', $projectSlug)->with("brand","neighbourhood", "roomInfo", "housingType", "county", "city", 'user.brands', 'user.housings', 'images')->firstOrFail();
        $projectHousing = $project->roomInfo->keyBy('name');
        $projectImages = ProjectImage::where('project_id', $project->id)->get();
        $projectHousingSetting = ProjectHouseSetting::orderBy('order')->get();

        $offer = Offer::where('project_id', $project->id)->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))->first();
        $projectCounts = CartOrder::selectRaw('COUNT(*) as count, JSON_UNQUOTE(json_extract(cart, "$.item.id")) as project_id, MAX(status) as status')
            ->where(DB::raw('JSON_UNQUOTE(json_extract(cart, "$.item.id"))'), $project->id)
            ->groupBy('project_id')
            ->where("status", "1")
            ->get();

        $project->cartOrders = $projectCounts->where('project_id', $project->id)->first()->count ?? 0;
        $selectedPage = $request->input('selected_page') ?? 0;
        $blockIndex = $request->input('block_id') ?? 0;
        $startIndex = 0;
        $lastHousingCount = 0;
        for($i = 0; $i < $blockIndex; $i++){
            $startIndex += $project->blocks[$i]->housing_count;
            $lastHousingCount += $project->blocks[$i]->housing_count;
        }
        $blockHousingCount = 0;
        for($i = 0; $i < $blockIndex + 1; $i++){
            $blockHousingCount += $project->blocks[$i]->housing_count;
        }
        $startIndex = $startIndex + ($selectedPage * 10);
        $endIndex = $startIndex + 20;
        if($endIndex > $blockHousingCount ){
            $endIndex = $blockHousingCount;
        }
        $currentBlockHouseCount = $project->blocks[$blockIndex]->housing_count;
        $projectCartOrders = DB::table('cart_orders')
        ->select(DB::raw('JSON_EXTRACT(cart, "$.item.housing") as housing_id , status'))
        ->where(DB::raw('JSON_EXTRACT(cart, "$.type")'), 'project')
        ->where(DB::raw('JSON_EXTRACT(cart, "$.item.id")'), $project->id)
        ->orderByRaw('CAST(housing_id AS SIGNED) ASC')
        ->get()
        ->keyBy("housing_id");
        $selectedPage = $request->input('selected_page') ?? 0;
        $blockIndex = $request->input('block_id') ?? 0;
        $startIndex = 0;
        $lastHousingCount = 0;
        for($i = 0; $i < $blockIndex; $i++){
            $startIndex += $project->blocks[$i]->housing_count;
            $lastHousingCount += $project->blocks[$i]->housing_count;
        }
        $blockHousingCount = 0;
        for($i = 0; $i < $blockIndex + 1; $i++){
            $blockHousingCount += $project->blocks[$i]->housing_count;
        }
        $startIndex = $startIndex + ($selectedPage * 10);
        $endIndex = $startIndex + 20;
        if($endIndex > $blockHousingCount ){
            $endIndex = $blockHousingCount;
        }


        return view('client.projects.project_housing', compact('blockIndex','lastHousingCount','projectCartOrders','offer','endIndex','startIndex','currentBlockHouseCount','menu', 'project', 'housingOrder', 'projectHousingSetting', 'projectHousing'));
    }

    public function propertyProjects(Request $request, $property)
    {
        $housingStatus = HousingStatus::where('slug', $property)->first();
        $projects = Project::whereHas('housingStatus', function ($query) use ($housingStatus) {
            $query->where('housing_type_id', $housingStatus->id);
        })->orderBy('view_count');
        if ($request->input("search")) {
            $projects = $projects->where('project_title', 'LIKE', '%' . $request->input('search') . '%');
        }

        if ($request->input("city_id")) {
            $projects = $projects->where('city_id', $request->input("city_id"));
        }

        if ($request->input("housing_type_id")) {
            $projects = $projects->where('housing_type_id', $request->input("housing_type_id"));
        }

        $housingTypes = HousingType::where('active', 1)->get();
        $housingStatus = HousingStatus::get();
        $cities = City::get();
        $projects = $projects->get();
        $menu = Menu::getMenuItems();
        return view('client.projects.list', compact('menu', 'projects', 'housingTypes', 'housingStatus', 'cities'));
    }

    public function getProjectHousingByStartAndEnd(Request $request,$projectId,$housingOrder){
        $blocks = Block::where('project_id',$projectId)->get();
        $blockStartIndex = 0;
        for($i = 0 ; $i < $request->input('block_index'); $i++){
            $blockStartIndex = $blocks[$i]->housing_count;
        }
        $blockEndIndex = $blockStartIndex + $blocks[$request->input('block_index')]->housing_count;
        
        $projectHousings = ProjectHousing::where("room_order",">=",$blockStartIndex)->where("room_order","<=",$blockEndIndex)->where('project_id',$projectId)->where('room_order','>',$blockStartIndex + $request->input('start'))->where('room_order','<=',$blockStartIndex + $request->input('end'))->get();

        $projectHousingsList = [];
        $combinedValues = $projectHousings->map(function ($item,$key) use(&$projectHousingsList,$request,$blockStartIndex) {
            $projectHousingsList[$item->room_order - ($request->input('start') + 1) - $blockStartIndex][$item->name] = $item->value;
        });

        
        $projectCartOrders = DB::table('cart_orders')
        ->select(DB::raw('JSON_EXTRACT(cart, "$.item.housing") as housing_id , status'))
        ->where(DB::raw('JSON_EXTRACT(cart, "$.type")'), 'project')
        ->where(DB::raw('JSON_EXTRACT(cart, "$.item.id")'), $projectId)
        ->orderByRaw('CAST(housing_id AS SIGNED) ASC')
        ->get()
        ->keyBy("housing_id");

        $discountAmount = 0;

        $offer = Offer::where('type', 'project')
            ->where('project_id', $projectId)
            ->where('start_date', '<=', date('Y-m-d H:i:s'))
            ->where('end_date', '>=', date('Y-m-d H:i:s'))
            ->get();


        return [
            "projectHousingsList" => $projectHousingsList,
            "projectCartOrders" => $projectCartOrders,
            "offers" => $offer,
            "blocks" => $blocks
        ];
    }
}
