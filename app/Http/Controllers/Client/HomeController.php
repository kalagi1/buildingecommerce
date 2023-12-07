<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\FooterSlider;
use App\Models\Housing;
use App\Models\HousingFavorite;
use App\Models\HousingStatus;
use App\Models\HousingType;
use App\Models\HousingTypeParent;
use App\Models\Menu;
use App\Models\Offer;
use App\Models\Project;
use App\Models\Slider;
use App\Models\StandOutUser;
use App\Models\User;
use App\Models\CartOrder;
use App\Models\Filter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        $menu = Menu::getMenuItems();
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
            \Illuminate\Support\Facades\DB::raw('(SELECT cart FROM cart_orders WHERE JSON_EXTRACT(housing_type_data, "$.type") = "housings" AND JSON_EXTRACT(housing_type_data, "$.item.id") = housings.id) AS sold'),
            \Illuminate\Support\Facades\DB::raw('(SELECT created_at FROM stand_out_users WHERE item_type = 2 AND item_id = housings.id AND housing_type_id = 0) as doping_time'),
            'cities.title AS city_title', // city tablosundan veri çekme
            'districts.ilce_title AS county_title' // district tablosundan veri çekme
        )
        ->leftJoin('housing_types', 'housing_types.id', '=', 'housings.housing_type_id')
        ->leftJoin('project_list_items', 'project_list_items.housing_type_id', '=', 'housings.housing_type_id')
        ->leftJoin('housing_status', 'housings.status_id', '=', 'housing_status.id')
        ->leftJoin('cities', 'cities.id', '=', 'housings.city_id') // city tablosunu join etme
        ->leftJoin('districts', 'districts.ilce_key', '=', 'housings.county_id') // district tablosunu join etme
        ->where('housings.status', 1)
        ->where('project_list_items.item_type', 2)
        ->orderByDesc('doping_time')
        ->orderByDesc('housings.created_at')
        ->get();


        $dashboardProjects = StandOutUser::where('start_date', "<=", date("Y-m-d"))->where('end_date', ">=", date("Y-m-d"))->where('item_type',1)->orderByDesc("created_at")->where('housing_type_id',0)->get();
        $dashboardStatuses = HousingStatus::where('in_dashboard', 1)->orderBy("dashboard_order")->where("status", "1")->get();
        $brands = User::where("type", "2")->where("status", "1")->get();
        $sliders = Slider::all();
        $footerSlider = FooterSlider::all();


        $finishProjects = Project::select(\Illuminate\Support\Facades\DB::raw('(SELECT created_at FROM stand_out_users WHERE item_type = 1 AND item_id = projects.id AND housing_type_id = 0) as doping_time'),'projects.*')
        ->with("city", "county")
        ->whereHas('housingStatus', function ($query) {
            $query->where('housing_type_id', '2');
        })->with("housings", 'brand', 'roomInfo','listItemValues', 'housingType')
        ->orderBy("doping_time", "desc")
        ->orderBy("created_at", "desc")
        ->where('status', 1)
        ->get();


        $continueProjects = Project::select(\Illuminate\Support\Facades\DB::raw('(SELECT created_at FROM stand_out_users WHERE item_type = 1 AND item_id = projects.id AND housing_type_id = 0) as doping_time'),'projects.*')
        ->with("city", "county")
        ->whereHas('housingStatus', function ($query) {
            $query->where('housing_type_id', '3');
        })->with("housings", 'brand', 'roomInfo', 'housingType')
        ->where('status', 1)
        ->orderBy("created_at", "desc")
        ->get();

        $soilProjects = Project::with("city", "county")->whereHas('housingStatus', function ($query) {
            $query->where('housing_type_id', '5');
        })->with("housings", 'brand', 'roomInfo', 'housingType')->where('status', 1)->orderBy("created_at", "desc")->get();
        return view('client.home.index', compact('menu', "soilProjects", 'finishProjects', 'continueProjects', 'sliders', 'secondhandHousings', 'brands', 'dashboardProjects', 'dashboardStatuses', 'footerSlider'));
    }

    public function getRenderedProjects(Request $request)
    {

        $parameters = ["slug", "type", "optional", "title"];
        $secondhandHousings = [];
        $projects = [];
        $slug = [];
        $slugType = null;
        $slugName = [];

        $housingTypeSlug = [];
        $housingTypeSlugName = [];

        $housingType = [];
        $housingTypeName = [];

        $opt = null;
        $is_project = null;

        $optName = [];

        foreach ($parameters as $paramValue) {
            if ($paramValue) {
                if ($request->input($paramValue) == "satilik" || $request->input($paramValue) == "kiralik") {
                    $opt = $request->input($paramValue);
                    if ($opt) {
                        $opt = $opt;
                        if ($opt == "satilik") {
                            $optName = "Satılık";
                        } else {
                            $optName = "Kiralık";
                        }
                    }
                } else {
                    $item1 = HousingStatus::where('id', $request->input($paramValue))->first();
                    $housingTypeParent = HousingTypeParent::where('slug', $request->input($paramValue))->first();
                    $housingType = HousingType::where('slug', $request->input($paramValue))->first();

                    if ($item1) {
                        $slugName = $item1->name;
                        $slug = $item1->id;
                    }

                    if ($housingTypeParent) {
                        $housingTypeSlugName = $housingTypeParent->title;
                        $housingTypeSlug = $housingTypeParent->slug;
                    }

                    if ($housingType) {
                        $housingTypeName = $housingType->title;
                        $housingType = $housingType->id;
                    }
                }

            }
        }

        $query = Project::query()->where('status', 1);

        if ($request->input('city')) {
            $query->where('city_id', $request->input('city'));
        }

        if ($request->input('county')) {
            $query->where('county_id', $request->input('county'));
        }

        if ($request->input('filterDate')) {
            $filterDate = $request->input('filterDate');

            switch ($filterDate) {
                case 'last3Days':
                    $query->where('created_at', '>=', now()->subDays(3));
                    break;

                case 'lastWeek':
                    $query->where('created_at', '>=', now()->subWeek());
                    break;

                case 'lastMonth':
                    $query->where('created_at', '>=', now()->subMonth());
                    break;

                default:
                    break;
            }
        }

        if ($request->input('project_type')) {
            $slug = $request->input('project_type');
            $query->whereHas('housingTypes', function ($query) use ($slug) {
                $query->where('housing_type_id', $slug);
            });}

        if ($slug) {
            $query->whereHas('housingTypes', function ($query) use ($slug) {
                $query->where('housing_type_id', $slug);
            });
        }

        if ($housingTypeSlug) {
            $query->where("step1_slug", $housingTypeSlug);
        }

        if ($opt) {
            $query->where("step2_slug", $opt);
        }
        if ($housingType) {
            $query->where('housing_type_id', $housingType);
            $housingTypeData = HousingType::where('id',$housingType)->first();
            $tempFilter = 0;
            
            $formData = json_decode($housingTypeData->form_json);
            foreach ($formData as $key => $data) {
                if ($data->type == "select" || $data->type == "checkbox-group") {
                    $inputName = str_replace('[]', '', $data->name);
                    if ($request->input($inputName)) {
                        $tempFilter = $tempFilter + 1;
                    }
                }
            }
            $filtersDb = Filter::where('item_type',1)->where('housing_type_id',$housingType)->get()->keyBy('filter_name')->toArray();
            $filtersDbx = array_keys($filtersDb);
            foreach ($formData as $key => $data) {
                if(in_array(str_replace('[]','',$data->name),$filtersDbx)){
                    if ($data->type == "select" || $data->type == "checkbox-group") {
                        $inputName = str_replace('[]', '', $data->name);
                        if ($request->input($inputName)) {
                            $query->whereHas('roomInfo', function ($query) use ($inputName, $request,$data) {
                                $query->where([
                                    ['name', $data->name],
                                ])->whereIn('value', $request->input($inputName))->groupBy('project_id');
                            }, '>=', 1);
                        }
                    }else if($data->type == 'text'){
                        if($filtersDb[str_replace('[]','',$data->name)]['text_style'] == 'min-max'){
                            $inputName = str_replace('[]', '', $data->name);
                            if ($request->input($inputName.'-min')) {
                                $query->whereHas('roomInfo', function ($query) use ($inputName, $request,$data) {
                                    $query->where([
                                        ['name', $data->name],
                                    ])->where('value','>=',intval($request->input($inputName.'-min')))->groupBy('project_id');
                                }, '>=', 1);
                            }
    
                            if ($request->input($inputName.'-max')) {
                                $query->whereHas('roomInfo', function ($query) use ($inputName, $request,$data) {
                                    $query->where([
                                        ['name', $data->name],
                                    ])->where('value','<=',intval($request->input($inputName.'-max')))->groupBy('project_id');
                                }, '>=', 1);
                            }
                        }else{
                            $inputName = str_replace('[]', '', $data->name);
                            if ($request->input($inputName)) {
                                $query->whereHas('roomInfo', function ($query) use ($inputName, $request,$data) {
                                    $query->where([
                                        ['name', $data->name],
                                    ])->where('value','LIKE','%'.$request->input($inputName).'%')->groupBy('project_id');
                                }, '>=', 1);
                            }
                        }
                        
                    }
                }
            }
        }

        if ($request->input('neighborhood')) {
            $query->where('neighbourhood_id', $request->input('neighborhood'));
        }

        // Sıralama seçeneğini kontrol et
        if ($request->input('sort')) {
            switch ($request->input('sort')) {
                case 'date-asc':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'date-desc':
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        }

        $itemPerPage = 12;
        $projects = $query->paginate($itemPerPage);

        $renderedProjects = $projects->through(function ($item) {
            return [
                'image' => url(str_replace('public/', 'storage/', $item->image)),
                'url' => route('project.detail', $item->slug),
                'city' => $item->city,
                'county' => $item->county,
                'profile_user_image' => URL::to('/').'/storage/profile_images/'.$item->user->profile_image,
                "title" => $item->project_title,
            ];
        });

        return response()->json($renderedProjects);
    }

    public function getRenderedSecondhandHousings(Request $request)
    {
        function convertMonthToTurkishCharacter($date)
        {
            $aylar = [
                'January' => 'Ocak',
                'February' => 'Şubat',
                'March' => 'Mart',
                'April' => 'Nisan',
                'May' => 'Mayıs',
                'June' => 'Haziran',
                'July' => 'Temmuz',
                'August' => 'Ağustos',
                'September' => 'Eylül',
                'October' => 'Ekim',
                'November' => 'Kasım',
                'December' => 'Aralık',
                'Monday' => 'Pazartesi',
                'Tuesday' => 'Salı',
                'Wednesday' => 'Çarşamba',
                'Thursday' => 'Perşembe',
                'Friday' => 'Cuma',
                'Saturday' => 'Cumartesi',
                'Sunday' => 'Pazar',
                'Jan' => 'Oca',
                'Feb' => 'Şub',
                'Mar' => 'Mar',
                'Apr' => 'Nis',
                'May' => 'May',
                'Jun' => 'Haz',
                'Jul' => 'Tem',
                'Aug' => 'Ağu',
                'Sep' => 'Eyl',
                'Oct' => 'Eki',
                'Nov' => 'Kas',
                'Dec' => 'Ara',
            ];
            return strtr($date, $aylar);
        }

        function getData($housing, $key)
        {
            $housing_type_data = json_decode($housing->housing_type_data);
            $a = $housing_type_data->$key;
            return $a[0];
        }

        function getImage($housing, $key)
        {
            $housing_type_data = json_decode($housing->housing_type_data);
            $a = $housing_type_data->$key;
            return $a;
        }

        $parameters = ["slug", "type", "optional", "title"];
        $secondhandHousings = [];
        $projects = [];
        $slug = [];
        $slugName = [];

        $housingTypeSlug = [];
        $housingTypeSlugName = [];

        $housingType = [];
        $housingTypeName = [];

        $opt = null;
        $is_project = null;

        $optName = [];

        foreach ($parameters as $paramValue) {
            if ($paramValue) {
                if ($request->input($paramValue) == "satilik" || $request->input($paramValue) == "kiralik" || $request->input($paramValue) == "gunluk-kiralik") {
                    $opt = $request->input($paramValue);
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
                    $item1 = HousingStatus::where('id', $request->input($paramValue))->first();
                    $housingTypeParent = HousingTypeParent::where('slug', $request->input($paramValue))->first();
                    $housingType = HousingType::where('slug', $request->input($paramValue))->first();

                    if ($item1) {
                        $is_project = $item1->is_project;
                        $slugName = $item1->name;
                        $slug = $item1->id;
                    }

                    if ($housingTypeParent) {
                        $housingTypeSlugName = $housingTypeParent->title;
                        $housingTypeSlug = $housingTypeParent->slug;
                    }

                    if ($housingType) {
                        $housingTypeName = $housingType->title;
                        $housingType = $housingType->id;
                    }
                }

            }
        }

        $obj =  Housing::with('images', "city", "county")
        ->select(
            'housings.*',
            'housing_types.title as housing_type_title',
            'project_list_items.column1_name as column1_name',
            'project_list_items.column2_name as column2_name',
            'project_list_items.column3_name as column3_name',
            'project_list_items.column4_name as column4_name',
            'project_list_items.column1_additional as column1_additional',
            'project_list_items.column2_additional as column2_additional',
            'project_list_items.column3_additional as column3_additional',
            'project_list_items.column4_additional as column4_additional',
            \Illuminate\Support\Facades\DB::raw('(SELECT cart FROM cart_orders WHERE JSON_EXTRACT(housing_type_data, "$.type") = "housings" AND JSON_EXTRACT(housing_type_data, "$.item.id") = housings.id) AS sold'),
            \Illuminate\Support\Facades\DB::raw('(SELECT created_at FROM stand_out_users WHERE item_type = 2 AND item_id = housings.id AND housings.housing_type_id = 0) as doping_time'),
        )
        ->leftJoin('housing_types', 'housing_types.id', '=', 'housings.housing_type_id')
        ->leftJoin('project_list_items', 'project_list_items.housing_type_id', '=', 'housings.housing_type_id')
        ->leftJoin('housing_status', 'housings.status_id', '=', 'housing_status.id')
        ->where('housings.status', 1)
        ->whereRaw('(SELECT 1 FROM cart_orders WHERE JSON_EXTRACT(cart, "$.type") = "housing" AND JSON_EXTRACT(cart, "$.item.id") = housings.id LIMIT 1) IS NULL')
        ->where('project_list_items.item_type', 2)
        ->with(['city', 'county']);

        if ($request->has('title') && in_array($request->input('title'), ['İmarlı','İmarsız'])) {
            $obj = $obj->whereRaw('housings.housing_type_id = (SELECT id FROM housing_types WHERE title = ?)', [$request->input('title')]);
        }

        if ($request->input("slug") == "al-sat-acil") {
            $obj = $obj->whereJsonContains('housing_type_data->buysellurgent1', "Evet");
        }

        if ($housingTypeSlug) {
            $obj->where("step1_slug", $housingTypeSlug);
        }

        if ($housingType) {
            // $obj->select(\Illuminate\Support\Facades\DB::raw('(SELECT MAX(start_date) FROM stand_out_users WHERE stand_out_users.item_type = 2 AND stand_out_users.item_id = housings.id AND housings.housing_type_id = '.$housingType.') as doping_time'));
            $obj->where('housings.housing_type_id', $housingType);
            
        }

        if ($opt) {
            $obj->where('step2_slug', $opt);
        }

        if ($slug) {
            $obj->whereHas('housingStatus', function ($query) use ($slug) {
                $query->where('housing_status_id', $slug);
            });
        }

        if ($request->input('from_owner')) {
            switch ($request->input('from_owner')) {
                case 'from_owner':
                    $obj = $obj->join('users', 'users.id', '=', 'housings.user_id')
                        ->where('users.type', '1');
                    break;

                case 'from_office':
                    $obj = $obj->join('users', 'users.id', '=', 'housings.user_id')
                        ->join('user_plans', 'user_plans.user_id', '=', 'users.id')
                        ->join('subscription_plans', 'subscription_plans.id', '=', 'user_plans.subscription_plan_id')
                        ->where('users.type', '2')
                        ->where('subscription_plans.plan_type', 'Emlakçı');
                    break;

                case 'from_bank':
                    $obj = $obj->join('users', 'users.id', '=', 'housings.user_id')
                        ->join('user_plans', 'user_plans.user_id', '=', 'users.id')
                        ->join('subscription_plans', 'subscription_plans.id', '=', 'user_plans.subscription_plan_id')
                        ->where('users.type', '2')
                        ->where('subscription_plans.plan_type', 'Banka');
                    break;

                case 'from_company':
                    $obj = $obj->join('users', 'users.id', '=', 'housings.user_id')
                        ->join('user_plans', 'user_plans.user_id', '=', 'users.id')
                        ->join('subscription_plans', 'subscription_plans.id', '=', 'user_plans.subscription_plan_id')
                        ->where('users.type', '2')
                        ->where('subscription_plans.plan_type', 'İnşaat');
                    break;
            }
        }

        if ($request->input('city')) {
            $obj = $obj->where('housings.city_id', $request->input('city'));
        }

        if ($request->input('county')) {
            $obj = $obj->where('housings.county_id', $request->input('county'));
        }

        if ($request->input('neighborhood')) {
            $obj = $obj->where('housings.neighborhood_id', $request->input('neighborhood'));
        }

        if ($request->input('neighborhood')) {
            $obj->where('neighborhood_id', $request->input('neighborhood'));
        }
        
        $housingTypeData = HousingType::where('id',$housingType)->first();
        $formData = json_decode($housingTypeData->form_json);
        $filtersDb = Filter::where('item_type',2)->where('housing_type_id',$housingType)->get()->keyBy('filter_name')->toArray();
        $filtersDbx = array_keys($filtersDb);
        foreach ($formData as $key => $data) {
            if(in_array(str_replace('[]','',$data->name),$filtersDbx)){
                if ($data->type == "select" || $data->type == "checkbox-group") {
                    $inputName = str_replace('[]', '', $data->name);
                    if ($request->input($inputName)) {
                        $obj = $obj->where(function($query) use($obj, $request,$inputName)
                        {
                            $query->whereJsonContains('housing_type_data->'.$inputName, [$request->input($inputName)[0]]);
                            $e = 0;
                            foreach ($request->input($inputName) as $input) {
                                if ($e == 0) {
                                    $e = 1;
                                    continue;
                                }
                                $query->orWhereJsonContains('housing_type_data->'.$inputName, [$input]);
                            }
                        });
                    }
                }else if($data->type == 'text'){
                    if($filtersDb[str_replace('[]','',$data->name)]['text_style'] == 'min-max'){
                        $inputName = str_replace('[]', '', $data->name);
                        if ($request->input($inputName.'-min')) {
                            $obj = $obj->whereRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(housing_type_data, "$.'.$inputName.'[0]")) AS FLOAT) >= ?', [$request->input($inputName.'-min')]);
                        }

                        if ($request->input($inputName.'-max')) {
                            $obj = $obj->whereRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(housing_type_data, "$.'.$inputName.'[0]")) AS FLOAT) <= ?', [$request->input($inputName.'-max')]);
                        }
                    }else{
                        $inputName = str_replace('[]', '', $data->name);
                        if ($request->input($inputName)) {
                            $obj = $obj->whereRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(housing_type_data, "$.'.$inputName.'[0]"))) = ?', $request->input($inputName));
                        }
                    }
                    
                }
            }
        }

        

        if ($request->input('post_date')) {
            switch ($request->input('post_date')) {
                case 'recent_day':
                    $obj = $obj->where('created_at', '>=', date('Y-m-d 00:00:00', strtotime('-1 Days')));
                    break;

                case 'last_3_day':
                    $obj = $obj->where('created_at', '>=', date('Y-m-d 00:00:00', strtotime('-3 Days')));
                    break;

                case 'last_7_day':
                    $obj = $obj->where('created_at', '>=', date('Y-m-d 00:00:00', strtotime('-7 Days')));
                    break;

                case 'last_15_day':
                    $obj = $obj->where('created_at', '>=', date('Y-m-d 00:00:00', strtotime('-15 Days')));
                    break;

                case 'last_30_day':
                    $obj = $obj->where('created_at', '>=', date('Y-m-d 00:00:00', strtotime('-30 Days')));
                    break;
            }
        }

        if ($request->has('sort')) {
            switch ($request->input('sort')) {
                case 'date-asc':
                    $obj = $obj->orderBy('created_at', 'asc');
                    $obj = $obj->orderBy('doping_time', 'asc');
                    break;
                case 'date-desc':
                    $obj = $obj->orderBy('created_at', 'desc');
                    $obj = $obj->orderBy('doping_time', 'asc');
                    break;
                case 'price-asc':
                    $obj = $obj->orderByRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(housings.housing_type_data, "$.price[0]")) AS FLOAT) ASC');
                    break;
                case 'price-desc':
                    $obj = $obj->orderByRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(housings.housing_type_data, "$.price[0]")) AS FLOAT) DESC');
                    break;
            }
        }else{
            $obj = $obj->orderBy('doping_time', 'desc');
        }

        $itemPerPage = 12;
        $obj = $obj->paginate($itemPerPage);


        return response()->json($obj->through(function ($item) use ($request) {
            if ($request->input('loc') && HousingType::find($request->input('loc'))->id !== $item->housing_type_id)
                return true;

            $discount_amount = Offer::where('type', 'housing')->where('housing_id', $item->id)->where('start_date', '<=', date('Y-m-d H:i:s'))->where('end_date', '>=', date('Y-m-d Hi:i:s'))->first()->discount_amount ?? 0;
            $isFavorite = 0;
            if (Auth::check()) {
                $isFavorite = HousingFavorite::where("housing_id", $item->id)->where("user_id", Auth::user()->id)->first();
            }

                $cartStatus = CartOrder::whereRaw("JSON_UNQUOTE(json_extract(cart, '$.item.type')) = 'housing'")
                ->whereRaw("JSON_UNQUOTE(json_extract(cart, '$.item.id')) = ?", [$item->id])
                ->value('status');

            $action = $cartStatus ? ( ($cartStatus == 0) ? 'payment_await' : (($cartStatus == 1) ? 'sold' : (($cartStatus == 2) ? 'tryBuy' : ''))) : "noCart";
            $housingTypeData = json_decode($item->housing_type_data, true);

            $offSale = isset($housingTypeData['off_sale1']);
            return [
                'image' => asset('housing_images/' . getImage($item, 'image')),
                'housing_type_title' => $item->housing_type_title,
                'id' => $item->id,
                'in_cart' => $request->session()->get('cart') && $request->session()->get('cart')['type'] == 'housing' && $request->session()->get('cart')['item']['id'] == $item->id,
                'is_favorite' => $isFavorite ? 1 : 0,
                'housing_url' => route('housing.show', $item->id),
                'title' => $item->title,
                'step1_slug' => $item->step1_slug,
                'housing_address' => $item->address,
                'doping_time' => $item->doping_time,
                'step2_slug' => $item->step2_slug,
                'city' => $item->city->title,
                'county' => $item->county->title,
                'created_at' => $item->created_at,
                "action" => $cartStatus,
                'offSale' => $offSale,
                "column1_additional" => $item->column1_additional ?? null,
                "column2_additional" => $item->column2_additional ?? null,
                "column3_additional" => $item->column3_additional ?? null,
                "column1" => json_decode($item->housing_type_data)->{$item->column1_name}[0] ?? null,
                "column2" => json_decode($item->housing_type_data)->{$item->column2_name}[0] ?? null,
                "column3" => json_decode($item->housing_type_data)->{$item->column3_name}[0] ?? null,
                'housing_type' =>
                [
                    'has_discount' => $discount_amount > 0,
                    // 'room_count' => getData($item, 'room_count') ? getData($item, 'room_count') : null,
                    'daily_rent' => ($item->step2_slug == "gunluk-kiralik" && getData($item, 'daily_rent')) ? getData($item, 'daily_rent') : null,
                    // 'squaremeters' => getData($item, 'squaremeters') ? getData($item, 'squaremeters') : null,
                    'price' => $item->step2_slug != "gunluk-kiralik" ? getData($item, 'price') - $discount_amount : null ,
                    'housing_date' => date('j', strtotime($item->created_at)) . ' ' . convertMonthToTurkishCharacter(date('F', strtotime($item->created_at))),
                ]

            ];
        }));
    }

    public function getSearchList(Request $request)
    {
        $request->validate(
            [
                'searchTerm' => 'required|string',
            ]
        );

        $term = $request->input('searchTerm');

        return response()->json(
            [
                'project_housings' => [],
                'housings' => Housing::select('housings.*')
                    ->join('cities', 'cities.id', '=', 'housings.city_id')
                    ->join('counties', 'counties.id', '=', 'housings.county_id')
                    ->where('status', 1)
                    ->where(function ($query) use ($term) {
                        $query->where('housings.title', 'LIKE', "%{$term}%");
                        $query->orWhereRaw('JSON_EXTRACT(housings.housing_type_data, "$.room_count[0]") = ?', $term);
                        $query->orWhere('cities.title', $term);
                        $query->orWhere('counties.title', $term);
                    })
                    ->get()
                    ->map(function ($item) {
                        $housingData = json_decode($item->housing_type_data);
                        return [
                            'id' => $item->id,
                            'photo' => $housingData->image,
                            'name' => $item->title,
                        ];
                    }),
                'projects' => Project::where('project_title', 'LIKE', "%{$term}%")
                    ->where('status', 1)
                    ->get()->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'photo' => $item->image,
                        'name' => $item->project_title,
                        'slug' => $item->slug,

                    ];
                }),
                'merchants' => User::where('type', '2')->where('name', 'LIKE', "%{$term}%")->get()->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'photo' => $item->profile_image,
                        'name' => $item->name,
                        'slug' => Str::slug($item->name),
                    ];
                }),
            ]
        );
    }

}
