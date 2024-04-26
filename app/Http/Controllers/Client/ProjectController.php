<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\CustomMail;
use App\Models\BankAccount;
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
use App\Models\ProjectOffers;
use App\Models\ProjectOffersGiven;
use App\Models\ProjectOffersReceived;
use App\Models\StandOutUser;
use App\Models\Town;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

use function PHPSTORM_META\type;

class ProjectController extends Controller
{
    public function index($slug, $id, Request $request)
    {

        if ($id > 1000000) {
            $id -= 1000000;
        }

        $menu = Cache::rememberForever('menu', function () {
            return Menu::getMenuItems();
        });
        $bankAccounts = BankAccount::all();

        $project = Project::where("id", $id)
            ->where("status", 1)
            ->with("brand", "blocks", 'listItemValues', "neighbourhood", "roomInfo", "housingType", "county", "city", 'user.brands', 'user.housings', 'images')
            ->first();

        $cities = City::all()->toArray();

        $turkishAlphabet = [
            'A', 'B', 'C', 'Ç', 'D', 'E', 'F', 'G', 'Ğ', 'H', 'I', 'İ', 'J', 'K', 'L',
            'M', 'N', 'O', 'Ö', 'P', 'R', 'S', 'Ş', 'T', 'U', 'Ü', 'V', 'Y', 'Z'
        ];

        usort($cities, function ($a, $b) use ($turkishAlphabet) {
            $priorityCities = ["İSTANBUL", "İZMİR", "ANKARA"];
            $endPriorityLetters = ["Y", "Z"];

            // Check if $a and $b are in the priority list
            $aPriority = array_search(strtoupper($a['title']), $priorityCities);
            $bPriority = array_search(strtoupper($b['title']), $priorityCities);

            // If both are in the priority list, sort based on their position in the list
            if ($aPriority !== false && $bPriority !== false) {
                return $aPriority - $bPriority;
            }

            // If only $a is in the priority list, move it to the top
            elseif ($aPriority !== false) {
                return -1;
            }

            // If only $b is in the priority list, move it to the top
            elseif ($bPriority !== false) {
                return 1;
            }

            // If neither $a nor $b is in the priority list, sort based on the first letter of the title
            else {
                $comparison = array_search(mb_substr($a['title'], 0, 1), $turkishAlphabet) - array_search(mb_substr($b['title'], 0, 1), $turkishAlphabet);

                // If the first letters are the same, check if they are 'Y' or 'Z'
                if ($comparison === 0 && in_array(mb_substr($a['title'], 0, 1), $endPriorityLetters)) {
                    return 1;
                } elseif ($comparison === 0 && in_array(mb_substr($b['title'], 0, 1), $endPriorityLetters)) {
                    return -1;
                }

                return $comparison;
            }
        });


        $towns = Town::all()->toArray();

        usort($towns, function ($a, $b) use ($turkishAlphabet) {
            $priorityCities = ["İSTANBUL", "İZMİR", "ANKARA"];
            $endPriorityLetters = ["Y", "Z"];

            // Check if $a and $b are in the priority list
            $aPriority = array_search(strtoupper($a['sehir_title']), $priorityCities);
            $bPriority = array_search(strtoupper($b['sehir_title']), $priorityCities);

            // If both are in the priority list, sort based on their position in the list
            if ($aPriority !== false && $bPriority !== false) {
                return $aPriority - $bPriority;
            }

            // If only $a is in the priority list, move it to the top
            elseif ($aPriority !== false) {
                return -1;
            }

            // If only $b is in the priority list, move it to the top
            elseif ($bPriority !== false) {
                return 1;
            }

            // If neither $a nor $b is in the priority list, sort based on the first letter of the title
            else {
                $comparison = array_search(mb_substr($a['sehir_title'], 0, 1), $turkishAlphabet) - array_search(mb_substr($b['sehir_title'], 0, 1), $turkishAlphabet);

                // If the first letters are the same, check if they are 'Y' or 'Z'
                if ($comparison === 0 && in_array(mb_substr($a['sehir_title'], 0, 1), $endPriorityLetters)) {
                    return 1;
                } elseif ($comparison === 0 && in_array(mb_substr($b['sehir_title'], 0, 1), $endPriorityLetters)) {
                    return -1;
                }

                return $comparison;
            }
        });

        if ($project) {

            $projectHousing = $project->roomInfo->keyBy('name');
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




            $lastHousingCount = 0;

            $projectHousings = ProjectHousing::where('project_id', $project->id)->where('room_order', '<=', $project->room_count)->get();
            $projectHousingsList = [];
            $salesCloseProjectHousingCount = 0;

            $projectHousings->each(function ($item) use (&$projectHousingsList, &$salesCloseProjectHousingCount, &$projectCartOrders) {
                $projectHousingsList[$item->room_order][$item->name] = $item->value;
                if ($item->name == "off_sale[]") {
                    if (isset($projectHousingsList[$item->room_order][$item->name]) &&  $projectHousingsList[$item->room_order][$item->name] !== "[]" && !isset($projectCartOrders[$item->room_order])) {
                        $salesCloseProjectHousingCount++;
                    }
                }
            });




            $offer = Offer::where('project_id', $project->id)->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))->get();

            $project->cartOrders = 0;
            $projectCounts = 0;
            $room_counts = intval($project->room_count); // room_counts değerini integer'a dönüştürdük
            $matching_indices = [];
            $matching_total = [];


            for ($i = 1; $i <= $room_counts; $i++) {
                $housing_json_path = 'JSON_UNQUOTE(json_extract(cart, "$.item.housing"))';
                
                $total_quantity = CartOrder::selectRaw(
                    "SUM(CAST(COALESCE(JSON_UNQUOTE(json_extract(cart, '$.item.qt')), '1') AS UNSIGNED)) as total_quantity"
                )
                    ->where(DB::raw('JSON_UNQUOTE(json_extract(cart, "$.item.id"))'), $project->id)
                    ->where(DB::raw($housing_json_path), $i)
                    ->where("status", "1")
                    ->first();

                    if(isset($total_quantity)) {
                        return $total_quantity;
                    }
                
            
                $has_share_sale = isset($projectHousingsList[$i]['share_sale[]']) && $projectHousingsList[$i]['share_sale[]'] !== "[]";
                $has_same_quantity = $total_quantity && isset($projectHousingsList[$i]['number_of_shares[]']) && $total_quantity->total_quantity == $projectHousingsList[$i]['number_of_shares[]'];
            
              if (!$has_share_sale && !empty($total_quantity) && isset($total_quantity) && !$has_same_quantity) {
                    $project->cartOrders += 1;
                    $matching_indices[] = $i;
                    $matching_total[] = $total_quantity;


                }
             
            }
            
            return $matching_total;

            $projectHousingSetting = ProjectHouseSetting::orderBy('order')->get();
            $selectedPage = $request->input('selected_page') ?? 0;
            $blockIndex = $request->input('block_id') ?? 0;
            $startIndex = 0;

            if ($project->have_blocks) {
                $currentBlockHouseCount = $project->blocks[$blockIndex]->housing_count;
            } else {
                $currentBlockHouseCount = 0;
            }
            for ($i = 0; $i < $blockIndex; $i++) {
                $startIndex += $project->blocks[$i]->housing_count;
            }
            $endIndex = 20 + $startIndex;
            $parent = HousingTypeParent::where("slug", $project->step1_slug)->first();

            $statusID = $project->housingStatus->where('housing_type_id', '<>', 1)->first()->housing_type_id ?? 1;
            $status = HousingStatus::find($statusID);

            $pageInfo = [
                "meta_title" => $project->project_title,
                "meta_keywords" => $project->project_title . "Proje,Proje Detay," . $project->city->title,
                "meta_description" => $project->project_title,
                "meta_image" => URL::to('/') . '/' . str_replace('public/', 'storage/', $project->image),
                "meta_author" => "Emlak Sepette"
            ];

            $pageInfo = json_encode($pageInfo);
            $pageInfo = json_decode($pageInfo);
        } else {
            return redirect('/')
                ->with('error', 'İlan yayından kaldırıldı veya bulunamadı.');
        }
        return view('client.projects.index', compact("pageInfo", "towns", "cities", "sumCartOrderQt", "bankAccounts", 'projectHousingsList', 'projectHousing', 'projectHousingSetting', 'parent', 'status', 'salesCloseProjectHousingCount', 'lastHousingCount', 'currentBlockHouseCount', 'menu', "offer", 'project', 'projectCartOrders', 'startIndex', 'blockIndex', 'endIndex'));
    }

    public function ajaxIndex($slug, Request $request)
    {
        $menu = Cache::rememberForever('menu', function () {
            return Menu::getMenuItems();
        });

        $project = Project::where('slug', $slug)
            ->with("brand", "blocks", 'listItemValues', "roomInfo", "housingType", "county", "city", 'user.brands', 'user.housings', 'images')
            ->firstOrFail();


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
        for ($i = 0; $i < $blockIndex; $i++) {
            $startIndex += $project->blocks[$i]->housing_count;
            $lastHousingCount += $project->blocks[$i]->housing_count;
        }
        $blockHousingCount = 0;
        for ($i = 0; $i < $blockIndex + 1; $i++) {
            $blockHousingCount += $project->blocks[$i]->housing_count;
        }
        $startIndex = $startIndex + ($selectedPage * 20);
        $endIndex = $startIndex + 20;
        if ($endIndex > $blockHousingCount) {
            $endIndex = $blockHousingCount;
        }
        $projectHousings = ProjectHousing::where('project_id', $project->id)->where('room_order', '<=', $project->room_count)->get();
        $projectHousingsList = [];
        $salesCloseProjectHousingCount = 0;

        $projectHousings->each(function ($item) use (&$projectHousingsList, &$salesCloseProjectHousingCount) {
            $projectHousingsList[$item->room_order][$item->name] = $item->value;
            if ($item->name == "off_sale[]") {
                if ($projectHousingsList[$item->room_order][$item->name]->value !== "[]") {
                    $salesCloseProjectHousingCount++;
                }
            }
        });
        $currentBlockHouseCount = $project->blocks[$blockIndex]->housing_count;


        return view('client.projects.index', compact('salesCloseProjectHousingCount', 'currentBlockHouseCount', 'lastHousingCount', 'menu', "offer", 'project', 'projectCartOrders', 'endIndex', 'blockIndex', 'startIndex'))->render();
    }

    public function detail($slug)
    {
        $menu = Menu::getMenuItems();
        $project = Project::where('slug', $slug)->with("brand", "roomInfo", "neighbourhood", "housingType", "county", "city", 'user.projects.housings', 'user.brands', 'user.housings', 'images')->firstOrFail();
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
            return view('client.projects.product_not_found', compact('menu', 'project'));
        }

        $statusID = $project->housingStatus->where('housing_type_id', '<>', 1)->first()->housing_type_id ?? 1;
        $status = HousingStatus::find($statusID);

        return view('client.projects.detail', compact('menu', 'projectHousingsList', 'project', 'offer', 'status'));
    }

    public function projectPaymentPlan(Request $request)
    {
        $project = Project::with("roomInfo", "housingType")->where('id', $request->input('project_id'))->first();
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
        $slugItem = null;
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
        $items = [];

        if ($deneme) {
            $slug = "al-sat-acil";
            $slugItem = "al-sat-acil";

            $slugName = "Al Sat Acil";
            $items = HousingTypeParent::with("parents.connections.housingType")->where("parent_id", null)->get();

            $secondhandHousings =  Housing::with('images')
                ->select(
                    'housings.id',
                    'housings.slug',

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
                    'cities.title AS city_title',
                    'districts.ilce_title AS county_title',
                    'neighborhoods.mahalle_title AS neighborhood_title',
                    DB::raw('(SELECT discount_amount FROM offers WHERE housing_id = housings.id AND type = "housing" AND start_date <= "' . date('Y-m-d H:i:s') . '" AND end_date >= "' . date('Y-m-d H:i:s') . '") as discount_amount'),
                )
                ->leftJoin('housing_types', 'housing_types.id', '=', 'housings.housing_type_id')
                ->leftJoin('project_list_items', 'project_list_items.housing_type_id', '=', 'housings.housing_type_id')
                ->leftJoin('housing_status', 'housings.status_id', '=', 'housing_status.id')
                ->leftJoin('cities', 'cities.id', '=', 'housings.city_id')
                ->leftJoin('districts', 'districts.ilce_key', '=', 'housings.county_id')
                ->leftJoin('neighborhoods', 'neighborhoods.mahalle_id', '=', 'housings.neighborhood_id')
                ->where('housings.status', 1)
                ->where('project_list_items.item_type', 2)
                ->orderByDesc('housings.created_at')
                ->get();
        }

        foreach ($parameters as $index => $paramValue) {
            if ($paramValue) {

                if ($paramValue == "satilik" || $paramValue == "devren-satilik" || $paramValue == "devren-kiralik" || $paramValue == "kiralik" || $paramValue == "gunluk-kiralik") {
                    $opt = $paramValue;
                    if ($opt) {
                        $opt = $opt;
                        if ($opt == "kiralik") {
                            $optName = "Kiralık";
                        } elseif ($opt == "satilik") {
                            $optName = "Satılık";
                        } elseif ($opt == "gunluk-kiralik") {
                            $optName = "Günlük Kiralık";
                        } elseif ($opt == "devren-satilik") {
                            $optName = "Devren Satılık";
                        } elseif ($opt == "devren-kiralik") {
                            $optName = "Devren Kiralık";
                        }
                    }
                } else {
                    $item1 = HousingStatus::where('slug', $paramValue)->first();
                    $housingTypeParent = HousingTypeParent::where('slug', $paramValue)->first();
                    $housingType = HousingType::where('slug', $paramValue)->first();


                    if ($item1) {
                        $items = HousingTypeParent::with("parents.connections.housingType")->where("parent_id", null)->get();
                        $is_project = $item1->is_project;
                        $slugName = $item1->name;
                        $slugItem = $item1->slug;
                        $slug = $item1->id;
                    }


                    if ($housingTypeParent) {
                        $items = HousingTypeParent::with("connections.housingType")->where("parent_id", $housingTypeParent->id)->get();
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
        $cities = City::get()->toArray();
        $turkishAlphabet = [
            'A', 'B', 'C', 'Ç', 'D', 'E', 'F', 'G', 'Ğ', 'H', 'I', 'İ', 'J', 'K', 'L',
            'M', 'N', 'O', 'Ö', 'P', 'R', 'S', 'Ş', 'T', 'U', 'Ü', 'V', 'Y', 'Z'
        ];

        usort($cities, function ($a, $b) use ($turkishAlphabet) {
            $priorityCities = ["İSTANBUL", "İZMİR", "ANKARA"];
            $endPriorityLetters = ["Y", "Z"];

            // Check if $a and $b are in the priority list
            $aPriority = array_search(strtoupper($a['title']), $priorityCities);
            $bPriority = array_search(strtoupper($b['title']), $priorityCities);

            // If both are in the priority list, sort based on their position in the list
            if ($aPriority !== false && $bPriority !== false) {
                return $aPriority - $bPriority;
            }

            // If only $a is in the priority list, move it to the top
            elseif ($aPriority !== false) {
                return -1;
            }

            // If only $b is in the priority list, move it to the top
            elseif ($bPriority !== false) {
                return 1;
            }

            // If neither $a nor $b is in the priority list, sort based on the first letter of the title
            else {
                $comparison = array_search(mb_substr($a['title'], 0, 1), $turkishAlphabet) - array_search(mb_substr($b['title'], 0, 1), $turkishAlphabet);

                // If the first letters are the same, check if they are 'Y' or 'Z'
                if ($comparison === 0 && in_array(mb_substr($a['title'], 0, 1), $endPriorityLetters)) {
                    return 1;
                } elseif ($comparison === 0 && in_array(mb_substr($b['title'], 0, 1), $endPriorityLetters)) {
                    return -1;
                }

                return $comparison;
            }
        });

        $menu = Menu::getMenuItems();
        $newHousingType = HousingType::where('slug', $housingTypeSlug)->first();
        if ($projects) {
            if (empty($housingTypeSlug) && !empty($housingTypeSlugName) || $newHousingType ||  $slug == "al-sat-acil") {
                $connections = HousingTypeParent::where("title", $housingTypeSlugName)->with("parents.connections.housingType")->first();
                $parentConnections = $connections->parents->pluck('connections')->flatten();
                $uniqueHousingTypeIds = $parentConnections->pluck('housingType.id')->unique();
                $uniqueHousingTypeNames = ["price", "squaremeters"];
                if ($housingTypeSlugName == "Müstakil Tatil") {
                    if ($newHousingType) {
                        $filtersDb = Filter::where('item_type', 1)->where('housing_type_id', $newHousingType->id)->get()->keyBy('filter_name')->toArray();
                    } elseif ($slug == "al-sat-acil" && !$newHousingType) {
                        $filtersDb = Filter::where('item_type', 1)
                            ->get()
                            ->where("is_sale", 1)
                            ->whereIn('filter_name', $uniqueHousingTypeNames)
                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    } else {
                        $filtersDb = Filter::where('item_type', 1)
                            ->whereIn('housing_type_id', $uniqueHousingTypeIds)
                            ->get()
                            ->where("is_daily_rent", 1)


                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    }
                } else {

                    if ($slug == "al-sat-acil" && !$housingTypeSlugName) {
                        $filtersDb = Filter::where('item_type', 1)
                            ->get()
                            ->where("is_sale", 1)
                            ->whereIn('filter_name', $uniqueHousingTypeNames)
                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    } elseif ($newHousingType && !$housingTypeSlugName) {
                        $filtersDb = Filter::where('item_type', 1)->where('housing_type_id', $newHousingType->id)->get()->keyBy('filter_name')->toArray();
                    } else {
                        $filtersDb = Filter::where('item_type', 1)
                            ->whereIn('housing_type_id', $uniqueHousingTypeIds)
                            ->get()
                            ->where("is_sale", 1)


                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    }
                }



                if (!empty($optName)) {

                    if ($optName == "Satılık") {
                        $filtersDb = Filter::where('item_type', 1)
                            ->whereIn('housing_type_id', $uniqueHousingTypeIds)
                            ->get()
                            ->where("is_sale", 1)
                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    } else if ($optName == "Kiralık") {
                        $filtersDb = Filter::where('item_type', 1)
                            ->whereIn('housing_type_id', $uniqueHousingTypeIds)
                            ->get()
                            ->where("is_rent", 1)
                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    } else if ($optName == "Günlük Kiralık") {
                        $filtersDb = Filter::where('item_type', 1)
                            ->whereIn('housing_type_id', $uniqueHousingTypeIds)
                            ->get()
                            ->where("is_daily_rent", 1)
                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    }
                }
                foreach ($filtersDb as $data) {
                    $filterItem = [
                        "label" => $data['filter_label'],
                        "type" => $data['filter_type'],
                        "name" => $data['filter_name'],
                    ];

                    if ($data['filter_type'] == "select" || $data['filter_type'] == "checkbox-group") {
                        $filterItem["values"] = json_decode($data['options']);
                    } else if ($data['filter_type'] == "text") {
                        $filterItem['text_style'] = $data['text_style'];
                    } else if ($data['filter_type'] == "toggle") {
                        $filterItem['toggle'] = true;
                        $filterItem["values"] = json_decode($data['options']);
                    }

                    array_push($filters, $filterItem);
                }
            }
        } else {

            // if (!empty($slugName) || $slug== "al-sat-acil" && !empty($housingType) &&  !empty($housingTypeParentSlug)) {
            //     $uniqueHousingTypeNames = ["price", "squaremeters"];
            // $filtersDb = Filter::where('item_type', 2)
            //     ->get()
            //     ->where("is_sale", 1)
            //     ->whereIn('filter_name', $uniqueHousingTypeNames)
            //     ->unique('filter_name') // filter_name değerine göre tekil olanları al
            //     ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
            //     ->toArray();
            //     foreach ($filtersDb as $data) {
            //         $filterItem = [
            //             "label" => $data['filter_label'],
            //             "type" => $data['filter_type'],
            //             "name" => $data['filter_name'],
            //         ];

            //         if ($data['filter_type'] == "select" || $data['filter_type'] == "checkbox-group") {
            //             $filterItem["values"] = json_decode($data['options']);
            //         } else if ($data['filter_type'] == "text") {
            //             $filterItem['text_style'] = $data['text_style'];
            //         } else if ($data['filter_type'] == "toggle") {
            //             $filterItem['toggle'] = true;
            //             $filterItem["values"] = json_decode($data['options']);
            //         }

            //         array_push($filters, $filterItem);
            //     }
            // }


            if (empty($housingTypeSlug) && !empty($housingTypeSlugName) || $newHousingType ||  $slug == "al-sat-acil") {
                $connections = HousingTypeParent::where("title", $housingTypeSlugName)->with("parents.connections.housingType")->first();
                $parentConnections = $connections->parents->pluck('connections')->flatten();
                $uniqueHousingTypeIds = $parentConnections->pluck('housingType.id')->unique();
                $uniqueHousingTypeNames = ["price", "squaremeters"];
                if ($housingTypeSlugName == "Müstakil Tatil") {
                    if ($newHousingType) {
                        $filtersDb = Filter::where('item_type', 2)->where('housing_type_id', $newHousingType->id)->get()->keyBy('filter_name')->toArray();
                    } elseif ($slug == "al-sat-acil" && !$newHousingType) {
                        $filtersDb = Filter::where('item_type', 2)
                            ->get()
                            ->where("is_sale", 1)
                            ->whereIn('filter_name', $uniqueHousingTypeNames)
                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    } else {
                        $filtersDb = Filter::where('item_type', 2)
                            ->whereIn('housing_type_id', $uniqueHousingTypeIds)
                            ->get()
                            ->where("is_daily_rent", 1)


                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    }
                } else {

                    if ($slug == "al-sat-acil" && !$housingTypeSlugName) {
                        $filtersDb = Filter::where('item_type', 2)
                            ->get()
                            ->where("is_sale", 1)
                            ->whereIn('filter_name', $uniqueHousingTypeNames)
                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    } elseif ($newHousingType && !$housingTypeSlugName) {
                        $filtersDb = Filter::where('item_type', 2)->where('housing_type_id', $newHousingType->id)->get()->keyBy('filter_name')->toArray();
                    } else {
                        $filtersDb = Filter::where('item_type', 2)
                            ->whereIn('housing_type_id', $uniqueHousingTypeIds)
                            ->get()
                            ->where("is_sale", 1)


                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    }
                }



                if (!empty($optName)) {

                    if ($optName == "Satılık") {
                        $filtersDb = Filter::where('item_type', 2)
                            ->whereIn('housing_type_id', $uniqueHousingTypeIds)
                            ->get()
                            ->where("is_sale", 1)
                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    } else if ($optName == "Kiralık") {
                        $filtersDb = Filter::where('item_type', 2)
                            ->whereIn('housing_type_id', $uniqueHousingTypeIds)
                            ->get()
                            ->where("is_rent", 1)
                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    } else if ($optName == "Günlük Kiralık") {
                        $filtersDb = Filter::where('item_type', 2)
                            ->whereIn('housing_type_id', $uniqueHousingTypeIds)
                            ->get()
                            ->where("is_daily_rent", 1)
                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    }
                }
                foreach ($filtersDb as $data) {
                    $filterItem = [
                        "label" => $data['filter_label'],
                        "type" => $data['filter_type'],
                        "name" => $data['filter_name'],
                    ];

                    if ($data['filter_type'] == "select" || $data['filter_type'] == "checkbox-group") {
                        $filterItem["values"] = json_decode($data['options']);
                    } else if ($data['filter_type'] == "text") {
                        $filterItem['text_style'] = $data['text_style'];
                    } else if ($data['filter_type'] == "toggle") {
                        $filterItem['toggle'] = true;
                        $filterItem["values"] = json_decode($data['options']);
                    }

                    array_push($filters, $filterItem);
                }
            }
        }

        $title = "";

        if ($slugName) {
            $title .= $slugName;
        }

        if ($housingTypeSlugName) {
            $title .= " " . $housingTypeSlugName;
        }

        if ($optName) {
            $title .= " " . $optName;
        }

        if ($housingTypeName) {
            $title .= " " . $housingTypeName;
        }

        if ($checkTitle) {
            $title .= " " . $checkTitle;
        }

        $pageInfo = [
            "meta_title" => $title,
            "meta_keywords" => "Emlak Sepette,asdasd",
            "meta_description" => "Emlak Sepette",
            "meta_author" => "Emlak Sepette",
        ];

        $pageInfo = json_encode($pageInfo);
        $pageInfo = json_decode($pageInfo);


        return view('client.all-projects.menu-list', compact('pageInfo', 'filters', "slugItem", "items", 'nslug', 'checkTitle', 'menu', "opt", "housingTypeSlug", "housingTypeParentSlug", "optional", "optName", "housingTypeName", "housingTypeSlug", "housingTypeSlugName", "slugName", "housingTypeParent", "housingType", 'projects', "slug", 'secondhandHousings', 'housingStatuses', 'cities', 'title', 'type'));
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
                return redirect('/')
                    ->with('error', 'Sayfa bulunamadı.');
            }
            $title = $type->title;
            $projects = Project::with("city", "county")->where("housing_type_id", $type->id)->get();
        } else {
            if (!$status) {
                return redirect('/')
                    ->with('error', 'Sayfa bulunamadı.');
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

    public function projectHousingDetail($projectSlug, $projectID, $housingOrder, Request $request, $active = null,)
    {
        if ($projectID > 1000000) {
            $projectID -= 1000000;
        }
        $cities = City::get();


        $menu = Menu::getMenuItems();
        $bankAccounts = BankAccount::all();

        $project = Project::where('id', $projectID)->where("status", 1)->with("brand", "neighbourhood", "housingType", "county", "city", 'user.brands', 'user.housings', 'images')->first();

        if (!$project) {
            return redirect('/')
                ->with('error', 'İlan yayından kaldırıldı veya bulunamadı.');
        }

        $statusID = $project->housingStatus->where('housing_type_id', '<>', 1)->first()->housing_type_id ?? 1;

        $statusSlug = HousingStatus::find($statusID)->slug;

        $turkishAlphabet = [
            'A', 'B', 'C', 'Ç', 'D', 'E', 'F', 'G', 'Ğ', 'H', 'I', 'İ', 'J', 'K', 'L',
            'M', 'N', 'O', 'Ö', 'P', 'R', 'S', 'Ş', 'T', 'U', 'Ü', 'V', 'Y', 'Z'
        ];



        $towns = Town::all()->toArray();

        usort($towns, function ($a, $b) use ($turkishAlphabet) {
            $priorityCities = ["İSTANBUL", "İZMİR", "ANKARA"];
            $endPriorityLetters = ["Y", "Z"];

            // Check if $a and $b are in the priority list
            $aPriority = array_search(strtoupper($a['sehir_title']), $priorityCities);
            $bPriority = array_search(strtoupper($b['sehir_title']), $priorityCities);

            // If both are in the priority list, sort based on their position in the list
            if ($aPriority !== false && $bPriority !== false) {
                return $aPriority - $bPriority;
            }

            // If only $a is in the priority list, move it to the top
            elseif ($aPriority !== false) {
                return -1;
            }

            // If only $b is in the priority list, move it to the top
            elseif ($bPriority !== false) {
                return 1;
            }

            // If neither $a nor $b is in the priority list, sort based on the first letter of the title
            else {
                $comparison = array_search(mb_substr($a['sehir_title'], 0, 1), $turkishAlphabet) - array_search(mb_substr($b['sehir_title'], 0, 1), $turkishAlphabet);

                // If the first letters are the same, check if they are 'Y' or 'Z'
                if ($comparison === 0 && in_array(mb_substr($a['sehir_title'], 0, 1), $endPriorityLetters)) {
                    return 1;
                } elseif ($comparison === 0 && in_array(mb_substr($b['sehir_title'], 0, 1), $endPriorityLetters)) {
                    return -1;
                }

                return $comparison;
            }
        });

        if ($project) {
            $projectHousing = $project->roomInfo->keyBy('name');
            $projectImages = ProjectImage::where('project_id', $project->id)->get();
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
            $selectedPage = $request->input('selected_page') ?? 0;
            $blockIndex = $request->input('block_id') ?? 0;
            $startIndex = 0;
            $lastHousingCount = 0;
            if ($project->have_blocks) {
                $currentBlockHouseCount = $project->blocks[$blockIndex]->housing_count;
            } else {
                $currentBlockHouseCount = 0;
            }
            for ($i = 0; $i < $blockIndex; $i++) {
                $startIndex += $project->blocks[$i]->housing_count;
            }
            $projectHousings = ProjectHousing::where('project_id', $project->id)->get();
            $projectHousingsList = [];
            $combinedValues = $projectHousings->map(function ($item) use (&$projectHousingsList) {
                $projectHousingsList[$item->room_order][$item->name] = $item->value;
            });

            $endIndex = $project->house_count + 20;

            $parent = HousingTypeParent::where("slug", $project->step1_slug)->first();


            $pageInfo = [
                "meta_title" => isset($projectHousingsList[$housingOrder]['advertise_title[]'])
                    ? $projectHousingsList[$housingOrder]['advertise_title[]']
                    : (isset($projectHousingsList[$housingOrder]['advertise-title[]'])
                        ? $projectHousingsList[$housingOrder]['advertise-title[]']
                        : "Emlak Sepette"),
                "meta_keywords" => $project->project_title . "Proje,Proje Detay," . $project->city->title,
                "meta_description" => isset($projectHousingsList[$housingOrder]['advertise_title[]'])
                    ? $projectHousingsList[$housingOrder]['advertise_title[]']
                    : (isset($projectHousingsList[$housingOrder]['advertise-title[]'])
                        ? $projectHousingsList[$housingOrder]['advertise-title[]']
                        : "Emlak Sepette"),
                "meta_author" => "Emlak Sepette",
            ];

            $pageInfo = json_encode($pageInfo);
            $pageInfo = json_decode($pageInfo);
            // print_r($housingOrder);die;
        } else {
            return redirect('/')
                ->with('error', 'İlan yayından kaldırıldı veya bulunamadı.');
        }

        $active = isset($active) ? 'active' : null;


        return view('client.projects.project_housing', compact('pageInfo', "towns", "cities", "sumCartOrderQt", "bankAccounts", 'projectHousingsList', 'blockIndex', "parent", 'lastHousingCount', 'projectCartOrders', 'offer', 'endIndex', 'startIndex', 'currentBlockHouseCount', 'menu', 'project', 'housingOrder', 'projectHousingSetting', 'projectHousing', "statusSlug", "active"));
    }

    public function projectHousingDetailAjax($projectSlug, $housingOrder, Request $request)
    {
        $menu = Menu::getMenuItems();
        $project = Project::where('slug', $projectSlug)->with("brand", "neighbourhood", "roomInfo", "housingType", "county", "city", 'user.brands', 'user.housings', 'images')->firstOrFail();
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
        for ($i = 0; $i < $blockIndex; $i++) {
            $startIndex += $project->blocks[$i]->housing_count;
            $lastHousingCount += $project->blocks[$i]->housing_count;
        }
        $blockHousingCount = 0;
        for ($i = 0; $i < $blockIndex + 1; $i++) {
            $blockHousingCount += $project->blocks[$i]->housing_count;
        }
        $startIndex = $startIndex + ($selectedPage * 10);
        $endIndex = $startIndex + 20;
        if ($endIndex > $blockHousingCount) {
            $endIndex = $blockHousingCount;
        }
        $currentBlockHouseCount = $project->blocks[$blockIndex]->housing_count;

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
        $selectedPage = $request->input('selected_page') ?? 0;
        $blockIndex = $request->input('block_id') ?? 0;
        $startIndex = 0;
        $lastHousingCount = 0;
        for ($i = 0; $i < $blockIndex; $i++) {
            $startIndex += $project->blocks[$i]->housing_count;
            $lastHousingCount += $project->blocks[$i]->housing_count;
        }
        $blockHousingCount = 0;
        for ($i = 0; $i < $blockIndex + 1; $i++) {
            $blockHousingCount += $project->blocks[$i]->housing_count;
        }
        $startIndex = $startIndex + ($selectedPage * 10);
        $endIndex = $startIndex + 20;
        if ($endIndex > $blockHousingCount) {
            $endIndex = $blockHousingCount;
        }


        return view('client.projects.project_housing', compact('blockIndex', 'lastHousingCount', 'projectCartOrders', 'offer', 'endIndex', 'startIndex', 'currentBlockHouseCount', 'menu', 'project', 'housingOrder', 'projectHousingSetting', 'projectHousing'));
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

    public function getProjectHousingByStartAndEnd(Request $request, $projectId, $housingOrder)
    {
        $blocks = Block::where('project_id', $projectId)->get();
        $blockStartIndex = 0;
        for ($i = 0; $i < $request->input('block_index'); $i++) {
            $blockStartIndex = $blocks[$i]->housing_count;
        }
        $blockEndIndex = $blockStartIndex + $blocks[$request->input('block_index')]->housing_count;

        $projectHousings = ProjectHousing::where("room_order", ">=", $blockStartIndex)->where("room_order", "<=", $blockEndIndex)->where('project_id', $projectId)->where('room_order', '>', $blockStartIndex + $request->input('start'))->where('room_order', '<=', $blockStartIndex + $request->input('end'))->get();

        $projectHousingsList = [];
        $combinedValues = $projectHousings->map(function ($item, $key) use (&$projectHousingsList, $request, $blockStartIndex) {
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

    //Mağazanın Alınan Tekliflerin listesi
    public function get_received_offers()
    {
        $data = ProjectOffers::with('project', "city", "district")->where('store_id', auth()->id())->get();
        return view('institutional.project_offers.get_received_offers', compact('data'));
    } //End

    //Kullanıcının Verdiği Tekliflerin listesi
    public function get_given_offers()
    {
        $data = ProjectOffers::with('project', "city", "district")->where('user_id', auth()->id())->get();

        return view('institutional.project_offers.get_given_offers', compact('data'));
    } //End


    //Teklif ver fonksiyonu
    public function give_offer(Request $request)
    {

        $data = [
            'user_id'           => Auth::check() ? auth()->id() : 4,
            'store_id'          => $request->projectUserId,
            'project_id'        => $request->projectId,
            'room_id'           => $request->roomId,
            'email'             => $request->email,
            'name'             => $request->name,
            'phone'             => $request->phone,
            'city_id'             => $request->city_id,
            'county_id'             => $request->county_id,
            'title'             => $request->title,
            'offer_description' => $request->offer_description,
            'approval_status'   => 0,
            'response_status'   => 0,
            'sales_status'      => 0,
            'offer_response'    => 0,
            'created_at'        => now()
        ];

        ProjectOffers::create($data);

        return redirect()->back()->with('success', 'Başvurunuz başarıyla alındı !');
    }

    //Teklif Yanıtı
    public function offer_response(Request $request)
    {

        $response         = $request->input('response');
        $email            = $request->input('email');
        $offerInfo        = $request->input('offer_info');

        $offer = ProjectOffers::findOrFail($request->input('offer_id'));

        $offer->response_description = $response;
        $offer->offer_response = 1;
        $offer->save();

        // Send email to the offerer
        $message = $offerInfo . "a yapmış olduğunuz teklifin yanıtlandı.";

        Mail::to($email)->send(new CustomMail($message, $response));

        return redirect()->back()->with('success', 'Yanıtlandı.');
    } //End


}
