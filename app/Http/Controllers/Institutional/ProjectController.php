<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\Block;
use App\Models\Brand;
use App\Models\CartOrder;
use App\Models\City;
use App\Models\County;
use App\Models\District;
use App\Models\DocumentNotification;
use App\Models\DopingOrder;
use App\Models\DopingPricing;
use App\Models\Housing;
use App\Models\HousingStatus;
use App\Models\HousingType;
use App\Models\HousingTypeParent;
use App\Models\HousingTypeParentConnection;
use App\Models\Invoice;
use App\Models\Log;
use App\Models\Menu;
use App\Models\Neighborhood;
use App\Models\NeighborView;
use App\Models\Offer;
use App\Models\PricingStandOut;
use App\Models\Project;
use App\Models\ProjectHouseSetting;
use App\Models\ProjectHousing;
use App\Models\ProjectHousingType;
use App\Models\ProjectImage;
use App\Models\ProjectSituation;
use App\Models\SinglePrice;
use App\Models\StandOutUser;
use App\Models\TempOrder;
use App\Models\Town;
use App\Models\User;
use App\Models\UserPlan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Throwable;

class ProjectController extends Controller
{

    public function loadMoreMobileHousings(Request $request)
    {
        // AJAX isteğiyle gelen sayfa numarasını al
        $page = $request->input('page', 1);

        // Sayfalama işlemi için, her sayfada kaç konut gösterileceğini belirleyin
        $perPage = 4;

        // Konutları çek
        $housings = Housing::with('images')
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
                DB::raw('(SELECT status FROM cart_orders WHERE JSON_EXTRACT(cart, "$.type") = "housing" AND JSON_EXTRACT(cart, "$.item.id") = housings.id) AS sold'),
                DB::raw('(SELECT created_at FROM stand_out_users WHERE item_type = 2 AND item_id = housings.id AND housing_type_id = 0) as doping_time'),
                'cities.title AS city_title',
                'districts.ilce_title AS county_title',
                'neighborhoods.mahalle_title AS neighborhood_title',
                DB::raw('(SELECT discount_amount FROM offers WHERE housing_id = housings.id AND type = "housing" AND start_date <= "' . date('Y-m-d H:i:s') . '" AND end_date >= "' . date('Y-m-d H:i:s') . '") as discount_amount')
            )
            ->leftJoin('housing_types', 'housing_types.id', '=', 'housings.housing_type_id')
            ->leftJoin('project_list_items', 'project_list_items.housing_type_id', '=', 'housings.housing_type_id')
            ->leftJoin('housing_status', 'housings.status_id', '=', 'housing_status.id')
            ->leftJoin('cities', 'cities.id', '=', 'housings.city_id')
            ->leftJoin('districts', 'districts.ilce_key', '=', 'housings.county_id')
            ->leftJoin('neighborhoods', 'neighborhoods.mahalle_id', '=', 'housings.neighborhood_id')
            ->where('housings.status', 1)
            ->where('project_list_items.item_type', 2)
            ->orderByDesc('doping_time')
            ->orderByDesc('housings.created_at')
            ->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();

        // Eğer daha fazla konut varsa, yeni konutları gönderin
        if ($housings->count() > 0) {
            return view('components.housing_mobile_cards', compact('housings'))->render();
        } else {
            // Daha fazla konut yoksa, boş bir yanıt gönderin
            return response()->json(['html' => '']);
        }
    }

    public function housingsV2()
    {
        return view('institutional.projects.housings_v2');
    }

    public function loadMoreHousings(Request $request)
    {
        // AJAX isteğiyle gelen sayfa numarasını al
        $page = $request->input('page', 1);

        // Sayfalama işlemi için, her sayfada kaç konut gösterileceğini belirleyin
        $perPage = 4;

        // Konutları çek
        $housings = Housing::with('images')
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
                DB::raw('(SELECT status FROM cart_orders WHERE JSON_EXTRACT(cart, "$.type") = "housing" AND JSON_EXTRACT(cart, "$.item.id") = housings.id) AS sold'),
                DB::raw('(SELECT created_at FROM stand_out_users WHERE item_type = 2 AND item_id = housings.id AND housing_type_id = 0) as doping_time'),
                'cities.title AS city_title',
                'districts.ilce_title AS county_title',
                'neighborhoods.mahalle_title AS neighborhood_title',
                DB::raw('(SELECT discount_amount FROM offers WHERE housing_id = housings.id AND type = "housing" AND start_date <= "' . date('Y-m-d H:i:s') . '" AND end_date >= "' . date('Y-m-d H:i:s') . '") as discount_amount')
            )
            ->leftJoin('housing_types', 'housing_types.id', '=', 'housings.housing_type_id')
            ->leftJoin('project_list_items', 'project_list_items.housing_type_id', '=', 'housings.housing_type_id')
            ->leftJoin('housing_status', 'housings.status_id', '=', 'housing_status.id')
            ->leftJoin('cities', 'cities.id', '=', 'housings.city_id')
            ->leftJoin('districts', 'districts.ilce_key', '=', 'housings.county_id')
            ->leftJoin('neighborhoods', 'neighborhoods.mahalle_id', '=', 'housings.neighborhood_id')
            ->where('housings.status', 1)
            ->where('project_list_items.item_type', 2)
            ->orderByDesc('doping_time')
            ->orderByDesc('housings.created_at')
            ->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();

        // Eğer daha fazla konut varsa, yeni konutları gönderin
        if ($housings->count() > 0) {
            return view('components.housing_cards', compact('housings'))->render();
        }
    }
    public function loadMoreRooms($projectId, $page, Request $request)
    {
        $perPage = 10;

        $menu = Cache::rememberForever('menu', function () {
            return Menu::getMenuItems();
        });
        $bankAccounts = BankAccount::all();

        $project = Project::where("id", $projectId)
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
                    'users.phone'
                )
                ->leftJoin('users', 'cart_orders.user_id', '=', 'users.id')
                ->where(DB::raw('JSON_EXTRACT(cart, "$.type")'), 'project')
                ->where(DB::raw('JSON_EXTRACT(cart, "$.item.id")'), $project->id)
                ->orderByRaw('CAST(housing_id AS SIGNED) ASC')
                ->get()
                ->keyBy("housing_id");




            $salesCloseProjectHousingCount = ProjectHousing::where('name', 'off_sale[]')->where('project_id', $project->id)->where('value', '!=', '[]')->count();
            $lastHousingCount = 0;

            $projectHousings = ProjectHousing::where('project_id', $project->id)->get();
            $projectHousingsList = [];
            $combinedValues = $projectHousings->map(function ($item) use (&$projectHousingsList) {
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
                "meta_author" => "Emlak Sepette",
            ];

            $pageInfo = json_encode($pageInfo);
            $pageInfo = json_decode($pageInfo);

            // Eğer geçersiz bir sayfa numarası gelirse boş bir yanıt döndür
            if ($page < 1 || $page > ceil($project->room_count / $perPage)) {
                return response()->json(['html' => '']);
            }

            // Odaları çek
            $start = ($page - 1) * $perPage;
            $end = min($start + $perPage, $project->room_count);

            if ($start < $end) {
                return view('components.room-list', compact('project', 'start', 'end', "pageInfo", "towns", "cities", "sumCartOrderQt", "bankAccounts", 'projectHousingsList', 'projectHousing', 'projectHousingSetting', 'parent', 'status', 'salesCloseProjectHousingCount', 'lastHousingCount', 'currentBlockHouseCount', 'menu', "offer", 'project', 'projectCartOrders', 'startIndex', 'blockIndex', 'endIndex'))->render();
            }

            // Odalar yoksa boş bir yanıt döndür
            return response()->json(['html' => '']);
        } else {
            return redirect('/')
                ->with('error', 'İlan yayından kaldırıldı veya bulunamadı.');
        }
    }

    public function loadMoreRoomsBlock($projectId, $blockIndexx, $page, Request $request)
    {
        $paxe = $page;
        $perPage = 10;

        $menu = Cache::rememberForever('menu', function () {
            return Menu::getMenuItems();
        });
        $bankAccounts = BankAccount::all();

        $project = Project::where("id", $projectId)
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
                    'users.phone'
                )
                ->leftJoin('users', 'cart_orders.user_id', '=', 'users.id')
                ->where(DB::raw('JSON_EXTRACT(cart, "$.type")'), 'project')
                ->where(DB::raw('JSON_EXTRACT(cart, "$.item.id")'), $project->id)
                ->orderByRaw('CAST(housing_id AS SIGNED) ASC')
                ->get()
                ->keyBy("housing_id");




            $salesCloseProjectHousingCount = ProjectHousing::where('name', 'off_sale[]')->where('project_id', $project->id)->where('value', '!=', '[]')->count();
            $lastHousingCount = 0;

            $projectHousings = ProjectHousing::where('project_id', $project->id)->get();
            $projectHousingsList = [];
            $combinedValues = $projectHousings->map(function ($item) use (&$projectHousingsList) {
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
                "meta_author" => "Emlak Sepette",
            ];

            $pageInfo = json_encode($pageInfo);
            $pageInfo = json_decode($pageInfo);


            $blocks = Block::where('project_id', $project->id)->get();
            $blockStart = 0;
            foreach ($blocks as $blockKey => $block) {
                if ($blockKey < $blockIndexx) {
                    $blockStart += $block->housing_count;
                }
            }


            $blockItemCount = $blocks[$blockIndexx]->housing_count;
            // Odaları çek
            if ($page == 0) {
                $start = $blockStart + 0;
                $end = min($start + $perPage, $blockStart + $blockItemCount);
            } else {
                $start = ($blockStart + ($page) * $perPage);
                $end = min($start + $perPage, $blockStart + $blockItemCount);
            }

            $blockName = $blocks[$blockIndexx]->block_name;


            if ($start < $end) {
                return view('components.room-list', compact('project', 'start', 'end', "pageInfo", "towns", "cities", "sumCartOrderQt", "blockName", "bankAccounts", 'projectHousingsList', 'projectHousing', 'projectHousingSetting', 'parent', 'status', 'salesCloseProjectHousingCount', 'lastHousingCount', 'currentBlockHouseCount', 'menu', "offer", 'project', 'projectCartOrders', 'startIndex', 'blockIndex', 'endIndex', 'blockStart'))->render();
            }

            // Odalar yoksa boş bir yanıt döndür
            return response()->json(['html' => '']);
        } else {
            return redirect('/')
                ->with('error', 'İlan yayından kaldırıldı veya bulunamadı.');
        }
    }

    public function loadMoreRoomsBlockMobile($projectId, $blockIndexx, $page, Request $request)
    {
        $paxe = $page;
        $perPage = 10;

        $menu = Cache::rememberForever('menu', function () {
            return Menu::getMenuItems();
        });
        $bankAccounts = BankAccount::all();

        $project = Project::where("id", $projectId)
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
                    'users.phone'
                )
                ->leftJoin('users', 'cart_orders.user_id', '=', 'users.id')
                ->where(DB::raw('JSON_EXTRACT(cart, "$.type")'), 'project')
                ->where(DB::raw('JSON_EXTRACT(cart, "$.item.id")'), $project->id)
                ->orderByRaw('CAST(housing_id AS SIGNED) ASC')
                ->get()
                ->keyBy("housing_id");




            $salesCloseProjectHousingCount = ProjectHousing::where('name', 'off_sale[]')->where('project_id', $project->id)->where('value', '!=', '[]')->count();
            $lastHousingCount = 0;

            $projectHousings = ProjectHousing::where('project_id', $project->id)->get();
            $projectHousingsList = [];
            $combinedValues = $projectHousings->map(function ($item) use (&$projectHousingsList) {
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
                "meta_author" => "Emlak Sepette",
            ];

            $pageInfo = json_encode($pageInfo);
            $pageInfo = json_decode($pageInfo);


            $blocks = Block::where('project_id', $project->id)->get();
            $blockStart = 0;
            foreach ($blocks as $blockKey => $block) {
                if ($blockKey < $blockIndexx) {
                    $blockStart += $block->housing_count;
                }
            }

            $blockItemCount = $blocks[$blockIndexx]->housing_count;
            // Odaları çek
            if ($page == 0) {
                $start = $blockStart + 0;
                $end = min($start + $perPage, $blockStart + $blockItemCount);
            } else {
                $start = ($blockStart + ($page) * $perPage);
                $end = min($start + $perPage, $blockStart + $blockItemCount);
            }
            $blockName = $blocks[$blockIndexx]->block_name;

            if ($start < $end) {
                return view('components.room-list-mobile', compact('project', "blockName", 'start', 'end', "pageInfo", "towns", "cities", "sumCartOrderQt", "bankAccounts", 'projectHousingsList', 'projectHousing', 'projectHousingSetting', 'parent', 'status', 'salesCloseProjectHousingCount', 'lastHousingCount', 'currentBlockHouseCount', 'menu', "offer", 'project', 'projectCartOrders', 'startIndex', 'blockIndex', 'endIndex', 'blockStart'))->render();
            }

            // Odalar yoksa boş bir yanıt döndür
            return response()->json(['html' => '']);
        } else {
            return redirect('/')
                ->with('error', 'İlan yayından kaldırıldı veya bulunamadı.');
        }
    }


    public function loadMoreRoomsMobile($projectId, $page, Request $request)
    {
        $perPage = 10;

        $menu = Cache::rememberForever('menu', function () {
            return Menu::getMenuItems();
        });
        $bankAccounts = BankAccount::all();

        $project = Project::where("id", $projectId)
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
                    'users.phone'
                )
                ->leftJoin('users', 'cart_orders.user_id', '=', 'users.id')
                ->where(DB::raw('JSON_EXTRACT(cart, "$.type")'), 'project')
                ->where(DB::raw('JSON_EXTRACT(cart, "$.item.id")'), $project->id)
                ->orderByRaw('CAST(housing_id AS SIGNED) ASC')
                ->get()
                ->keyBy("housing_id");




            $salesCloseProjectHousingCount = ProjectHousing::where('name', 'off_sale[]')->where('project_id', $project->id)->where('value', '!=', '[]')->count();
            $lastHousingCount = 0;

            $projectHousings = ProjectHousing::where('project_id', $project->id)->get();
            $projectHousingsList = [];
            $combinedValues = $projectHousings->map(function ($item) use (&$projectHousingsList) {
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
                "meta_author" => "Emlak Sepette",
            ];

            $pageInfo = json_encode($pageInfo);
            $pageInfo = json_decode($pageInfo);

            // Eğer geçersiz bir sayfa numarası gelirse boş bir yanıt döndür
            if ($page < 1 || $page > ceil($project->room_count / $perPage)) {
                return response()->json(['html' => '']);
            }

            // Odaları çek
            $start = ($page - 1) * $perPage;
            $end = min($start + $perPage, $project->room_count);
            if ($start < $end) {
                return view('components.room-list-mobile', compact('project', 'start', 'end', "pageInfo", "towns", "cities", "sumCartOrderQt", "bankAccounts", 'projectHousingsList', 'projectHousing', 'projectHousingSetting', 'parent', 'status', 'salesCloseProjectHousingCount', 'lastHousingCount', 'currentBlockHouseCount', 'menu', "offer", 'project', 'projectCartOrders', 'startIndex', 'blockIndex', 'endIndex'))->render();
            }

            // Odalar yoksa boş bir yanıt döndür
            return response()->json(['html' => '']);
        } else {
            return redirect('/')
                ->with('error', 'İlan yayından kaldırıldı veya bulunamadı.');
        }
    }


    public function reactProjects()
    {
        return view('institutional.projects.react_projects');
    }

    public function setSelectedData(Request $request, $projectId)
    {
        $orders = explode(',', $request->input('selected-items'));
        foreach ($orders as $order) {
            $hasData = ProjectHousing::where('project_id', $projectId)->where('room_order', $order)->where('name', $request->input('transaction-type') . "[]")->first();

            if ($hasData) {
                ProjectHousing::where('project_id', $projectId)->where('room_order', $order)->where('name', $request->input('transaction-type') . "[]")->update([
                    "value" => str_replace('.', '', $request->input('new_data'))
                ]);
            } else {
                ProjectHousing::create([
                    "project_id" => $projectId,
                    "room_order" => $order,
                    "name" => $request->input('transaction-type') . "[]",
                    "value" => str_replace('.', '', $request->input('new_data')),
                    "key" => $request->input('transaction-type') . "[]"
                ]);
            }
        }
        Session::flash('status', 'update_selected_items');
        return redirect()->route('institutional.projects.housings', $projectId);
    }

    public function housings($project_id)
    {
        $menu = Menu::getMenuItems();
        $project = Project::where('id', $project_id)->with("brand", "blocks", "roomInfo", "housingType", "county", "city", 'user.projects.housings', 'user.brands', 'user.housings', 'images')->firstOrFail();
        $project->roomInfo = $project->roomInfo;
        $project->brand = $project->brand;
        $project->housingType = $project->housingType;
        $project->county = $project->county;
        $project->city = $project->city;
        $project->user = $project->user;
        $project->user->housings = $project->user->housings;
        $project->user->brands = $project->user->brands;
        $project->images = $project->images;


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

        $projectHousings = ProjectHousing::where('project_id', $project->id)->get();
        $projectHousingsList = [];
        $combinedValues = $projectHousings->map(function ($item) use (&$projectHousingsList) {
            $projectHousingsList[$item->room_order][$item->name] = $item->value;
        });

        $offer = Offer::where('project_id', $project->id)->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))->first();


        return view('institutional.projects.housings', compact('menu', "sumCartOrderQt", "projectHousingsList", "offer", 'project'));
    }

    public function setPayDecs(Request $request)
    {
        $project = Project::where('id', $request->input('project_id'))->first();
        if (str_contains($request->input('item_order'), ',')) {
            $itemOrders = explode(',', $request->input('item_order'));
            foreach ($itemOrders as $order) {
                ProjectHousing::where('project_id', $request->input('project_id'))->where('room_order', $order)->where('name', 'LIKE', '%pay_desc_price%')->delete();
                ProjectHousing::where('project_id', $request->input('project_id'))->where('room_order', $order)->where('name', 'LIKE', '%pay_desc_date%')->delete();
                ProjectHousing::where('project_id', $request->input('project_id'))->where('room_order', $order)->where('name', 'LIKE', '%pay-dec-count%')->delete();

                ProjectHousing::create([
                    "key" => 'pay-dec-count' . ($order),
                    "name" => 'pay-dec-count' . ($order),
                    "value" => count($request->input('pay-dec-price')),
                    "project_id" => $project->id,
                    "room_order" => $order
                ]);

                for ($j = 0; $j < count($request->input('pay-dec-price')); $j++) {
                    ProjectHousing::create([
                        "key" => 'pay_desc_price' . ($order) . $j,
                        "name" => 'pay_desc_price' . ($order) . $j,
                        "value" => str_replace('.', '', $request->input('pay-dec-price')[$j]),
                        "project_id" => $project->id,
                        "room_order" => $order
                    ]);

                    ProjectHousing::create([
                        "key" => 'pay_desc_date' . ($order) . $j,
                        "name" => 'pay_desc_date' . ($order) . $j,
                        "value" => $request->input('pay-dec-date')[$j],
                        "project_id" => $project->id,
                        "room_order" => $order
                    ]);
                }
            }
        } else {
            if ($request->input('all-items')) {
                ProjectHousing::where('project_id', $request->input('project_id'))->where('name', 'LIKE', '%pay_desc_price%')->delete();
                ProjectHousing::where('project_id', $request->input('project_id'))->where('name', 'LIKE', '%pay_desc_date%')->delete();
                ProjectHousing::where('project_id', $request->input('project_id'))->where('name', 'LIKE', '%pay-dec-count%')->delete();
                for ($i = 0; $i < $project->room_count; $i++) {
                    ProjectHousing::create([
                        "key" => 'pay-dec-count' . ($i + 1),
                        "name" => 'pay-dec-count' . ($i + 1),
                        "value" => count($request->input('pay-dec-price')),
                        "project_id" => $project->id,
                        "room_order" => $i + 1
                    ]);
                    for ($j = 0; $j < count($request->input('pay-dec-price')); $j++) {
                        ProjectHousing::create([
                            "key" => 'pay_desc_price' . ($i + 1) . $j,
                            "name" => 'pay_desc_price' . ($i + 1) . $j,
                            "value" => str_replace('.', '', $request->input('pay-dec-price')[$j]),
                            "project_id" => $project->id,
                            "room_order" => $i + 1
                        ]);

                        ProjectHousing::create([
                            "key" => 'pay_desc_date' . ($i + 1) . $j,
                            "name" => 'pay_desc_date' . ($i + 1) . $j,
                            "value" => $request->input('pay-dec-date')[$j],
                            "project_id" => $project->id,
                            "room_order" => $i + 1
                        ]);
                    }
                }
            } else {
                ProjectHousing::where('project_id', $request->input('project_id'))->where('room_order', $request->input('item_order'))->where('name', 'LIKE', '%pay_desc_price%')->delete();
                ProjectHousing::where('project_id', $request->input('project_id'))->where('room_order', $request->input('item_order'))->where('name', 'LIKE', '%pay_desc_date%')->delete();
                ProjectHousing::where('project_id', $request->input('project_id'))->where('room_order', $request->input('item_order'))->where('name', 'LIKE', '%pay-dec-count%')->delete();
                ProjectHousing::create([
                    "key" => 'pay-dec-count' . $request->input('item_order'),
                    "name" => 'pay-dec-count' . $request->input('item_order'),
                    "value" => count($request->input('pay-dec-price')),
                    "project_id" => $project->id,
                    "room_order" => $request->input('item_order')
                ]);
                for ($j = 0; $j < count($request->input('pay-dec-price')); $j++) {
                    ProjectHousing::create([
                        "key" => 'pay_desc_price' . $request->input('item_order') . $j,
                        "name" => 'pay_desc_price' . $request->input('item_order') . $j,
                        "value" => str_replace('.', '', $request->input('pay-dec-price')[$j]),
                        "project_id" => $project->id,
                        "room_order" => $request->input('item_order')
                    ]);

                    ProjectHousing::create([
                        "key" => 'pay_desc_date' . $request->input('item_order') . $j,
                        "name" => 'pay_desc_date' . $request->input('item_order') . $j,
                        "value" => str_replace('.', '', $request->input('pay-dec-date')[$j]),
                        "project_id" => $project->id,
                        "room_order" => $request->input('item_order')
                    ]);
                }
            }
        }


        return redirect()->route('institutional.projects.housings', $project->id);
    }

    public function getRoomPayDec(Request $request)
    {
        $payDecCount = ProjectHousing::where('project_id', $request->input('project_id'))->where('room_order', $request->input('item_order'))->where('name', 'pay-dec-count' . $request->input('item_order'))->first();
        $payDecPrice = ProjectHousing::where('project_id', $request->input('project_id'))->where('room_order', $request->input('item_order'))->where('name', 'LIKE', '%pay_desc_price' . $request->input('item_order') . '%')->get();
        $payDecDate = ProjectHousing::where('project_id', $request->input('project_id'))->where('room_order', $request->input('item_order'))->where('name', 'LIKE', '%pay_desc_date' . $request->input('item_order') . '%')->get();

        return json_encode([
            "pay_dec_count" => $payDecCount,
            "pay_dec_price" => $payDecPrice,
            "pay_dec_date" => $payDecDate,
        ]);
    }

    public function editHousing($projectId, $roomOrder)
    {
        $project = Project::where('id', $projectId)->first();
        $housingType = HousingType::where('id', $project->housing_type_id)->first();
        $housing = ProjectHousing::where('project_id', $projectId)->where('room_order', $roomOrder)->get();
        return view('institutional.projects.housing_edit', compact('project', 'housingType', 'housing', 'roomOrder'));
    }

    public function editHousingPost(Request $request, $projectId, $roomOrder)
    {
        try {

            $project = Project::where('id', $projectId)->first();
            $housingType = HousingType::where('id', $project->housing_type_id)->firstOrFail();
            $housingTypeInputs = json_decode($housingType->form_json);
            if ($request->file('image')) {
                ProjectHousing::where('project_id', $projectId)->where('name', '!=', 'images[]')->where('room_order', '=', $roomOrder)->delete();
            } else {
                ProjectHousing::where('project_id', $projectId)->where('name', '!=', 'images[]')->where('name', '!=', 'image[]')->where('room_order', '=', $roomOrder)->delete();
            }

            Project::where('id', $project->id)->update([
                "status" => 2
            ]);

            if ($request->input('pay-dec-price')) {
                ProjectHousing::create([
                    "key" => "pay-dec-count" . $roomOrder,
                    "name" => "pay-dec-count" . $roomOrder,
                    "value" => count($request->input('pay-dec-price')),
                    "project_id" => $project->id,
                    "room_order" => $roomOrder,
                ]);

                for ($i = 0; $i < count($request->input('pay-dec-price')); $i++) {
                    if (isset($request->input('pay-dec-price')[$i])) {
                        ProjectHousing::create([
                            "key" => "pay_desc_price" . $roomOrder . $i,
                            "name" => "pay_desc_price" . $roomOrder . $i,
                            "value" => str_replace('.', '', $request->input('pay-dec-price')[$i]),
                            "project_id" => $project->id,
                            "room_order" => $roomOrder,
                        ]);
                    }

                    if (isset($request->input('pay-dec-date')[$i])) {
                        ProjectHousing::create([
                            "key" => "pay_desc_date" . $roomOrder . $i,
                            "name" => "pay_desc_date" . $roomOrder . $i,
                            "value" => $request->input('pay-dec-date')[$i],
                            "project_id" => $project->id,
                            "room_order" => $roomOrder,
                        ]);
                    }
                }
            }
            for ($i = 0; $i < 1; $i++) {
                for ($j = 0; $j < count($housingTypeInputs); $j++) {
                    if ($housingTypeInputs[$j]->type == "file") {
                        if ($request->hasFile(substr($housingTypeInputs[$j]->name, 0, -2))) {
                            $images = $request->file(substr($housingTypeInputs[$j]->name, 0, -2));

                            foreach ($images as $key => $image) {
                                if ($image->isValid()) {
                                    $imageName = Str::slug(Str::slug($request->input('name'))) . '-' . ($key + 1) . time() . '.' . $image->getClientOriginalExtension();
                                    $image->move(public_path('/project_housing_images'), $imageName);
                                    ProjectHousing::create([
                                        "key" => $housingTypeInputs[$j]->label,
                                        "name" => $housingTypeInputs[$j]->name,
                                        "value" => $imageName,
                                        "project_id" => $project->id,
                                        "room_order" => $roomOrder,
                                    ]);
                                } else {
                                }
                            }
                        }
                    } else {
                        if ($housingTypeInputs[$j]->type != "checkbox-group" && !str_contains($housingTypeInputs[$j]->className, 'project-disabled')) {
                            if (in_array(3, array_merge(array_keys($project->housingTypes->keyBy('housing_type_id')->toArray()))) && str_contains($housingTypeInputs[$j]->className, 'continue-disabled')) {
                            } else {
                                if (isset($housingTypeInputs[$j]->name) && $request->input(substr($housingTypeInputs[$j]->name, 0, -2))[$i] != null) {
                                    if (str_contains($housingTypeInputs[$j]->className, 'price-only')) {
                                        ProjectHousing::create([
                                            "key" => $housingTypeInputs[$j]->label,
                                            "name" => $housingTypeInputs[$j]->name,
                                            "value" => is_object($request->input(substr($housingTypeInputs[$j]->name, 0, -2))[$i]) || is_array($request->input(substr($housingTypeInputs[$j]->name, 0, -2))) ? str_replace('.', '', $request->input(substr($housingTypeInputs[$j]->name, 0, -2))[0]) : str_replace('.', '', $request->input(substr($housingTypeInputs[$j]->name, 0, -2))[0]),
                                            "project_id" => $project->id,
                                            "room_order" => $roomOrder,
                                        ]);
                                    } else {
                                        ProjectHousing::create([
                                            "key" => $housingTypeInputs[$j]->label,
                                            "name" => $housingTypeInputs[$j]->name,
                                            "value" => is_object($request->input(substr($housingTypeInputs[$j]->name, 0, -2))[$i]) || is_array($request->input(substr($housingTypeInputs[$j]->name, 0, -2))) ? $request->input(substr($housingTypeInputs[$j]->name, 0, -2))[0] : $request->input(substr($housingTypeInputs[$j]->name, 0, -2))[0],
                                            "project_id" => $project->id,
                                            "room_order" => $roomOrder,
                                        ]);
                                    }
                                }
                            }
                        } else {
                            $projectHousing = ProjectHousing::create([
                                "key" => $housingTypeInputs[$j]->label,
                                "name" => $housingTypeInputs[$j]->name,
                                "value" => is_object($request->input(substr($housingTypeInputs[$j]->name, 0, -2) . ($i + 1))) || is_array($request->input(substr($housingTypeInputs[$j]->name, 0, -2) . ($roomOrder))) ? json_encode(array_reduce($request->input(substr($housingTypeInputs[$j]->name, 0, -2) . ($roomOrder)), 'array_merge', [])) : '[]',
                                "project_id" => $project->id,
                                "room_order" => $roomOrder,
                            ]);
                        }
                    }
                }
            }
            return redirect()->route('institutional.projects.housings', $project->id);
        } catch (Throwable $e) {

            return Redirect::back()->withErrors(['msg' => $e->getMessage()]);
        }
    }

    public function deleteHousingPost($projectId, $roomOrder)
    {
        $project = Project::where('id', $projectId)->first();
        if ($project->have_blocks) {
            $blockCount = 0;
            $tempBlockCount = 0;
            for ($i = 0; $i < count($project->blocks); $i++) {
                $tempBlockCount = $blockCount;
                $blockCount += $project->blocks[$i]->housing_count;
                if ($roomOrder <= $blockCount && $roomOrder = $tempBlockCount) {
                    $block = $project->blocks[$i]->block_name;

                    $blockId = $project->blocks[$i]->id;

                    $block = Block::where('id', $blockId)->first();
                    Block::where('id', $blockId)->update([
                        "housing_count" => $block->housing_count - 1
                    ]);
                }
            }
        }

        ProjectHousing::where('room_order', $roomOrder)->where('project_id', $projectId)->delete();
        for ($i = 0; $i < $project->room_count; $i++) {
            if ($i + 1 > $roomOrder) {
                ProjectHousing::where('project_id', $projectId)->where('room_order', $i + 1)->update([
                    "room_order" => $i
                ]);
            }
        }

        $project->update([
            "room_count" => $project->room_count - 1
        ]);


        return redirect()->route('institutional.projects.housings', $projectId);
    }


    public function index()
    {
        $bankAccounts = BankAccount::all();
        $userId = auth()->user()->parent_id ?? auth()->user()->id;

        $projects = Project::where('user_id', $userId)
            ->with("roomInfo", "housingType", "county", "city", "neighbourhood", "standOut", "standOut.dopingPricePaymentWait", 'standOut.dopingPricePaymentCancel')
            ->orderByDesc('created_at')
            ->get();
        $userProjectIds = $projects->pluck('id');

        $projectCounts = $this->getProjectCounts($userProjectIds, '1');
        $paymentPendingCounts = $this->getProjectCounts($userProjectIds, '0');
        $offSaleCount = 0;

        $activeProjects = [];
        $inactiveProjects = [];
        $pendingProjects = [];
        $disabledProjects = [];

        $projects = $projects->map(function ($project) use (&$offSaleCount, &$activeProjects, &$inactiveProjects, &$pendingProjects, &$disabledProjects) {
            $salesCloseProjectHousingCount = ProjectHousing::where('name', 'off_sale[]')->where('project_id', $project->id)->where('value', '!=', '[]')->count();
            $project->offSale = $salesCloseProjectHousingCount;

            switch ($project->status) {
                case 1:
                    $activeProjects[] = $project;
                    break;
                case 2:
                    $pendingProjects[] = $project;
                    break;
                case 3:
                    $disabledProjects[] = $project;
                    break;
                default:
                    $inactiveProjects[] = $project;
                    break;
            }

            return $project;
        });


        $projects = $this->mapProjectCounts($projects, $projectCounts, 'cartOrders');
        $projects = $this->mapProjectCounts($projects, $paymentPendingCounts, 'paymentPending');

        return view('institutional.projects.index', compact('activeProjects', 'pendingProjects', 'disabledProjects', 'inactiveProjects', 'pendingProjects', 'bankAccounts'));
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


    public function create()
    {
        $brands = Brand::where('user_id', auth()->user()->parent_id ?? auth()->user()->parent_id ?? auth()->user()->id)->where('status', 1)->get();
        $housing_types = HousingType::all();
        $housing_status = HousingStatus::all();
        $cities = City::get();
        return view('institutional.projects.create', compact('housing_types', 'housing_status', 'brands', 'cities'));
    }

    public function createV2()
    {
        $housingTypeParent = HousingTypeParent::whereNull('parent_id')->get();
        $prices = SinglePrice::where('item_type', 1)->get();
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
        $housing_status = HousingStatus::where('is_project', 1)->where('is_default', 0)->get();
        $housing_statusX = HousingStatus::where('is_project', 1)->where('is_default', 1)->first();
        $tempDataFull = TempOrder::where('item_type', 1)->where('user_id', auth()->guard()->user()->id)->first();
        if ($tempDataFull) {
            $hasTemp = true;
            $tempData = json_decode($tempDataFull->data);
        } else {
            $tempData = json_decode('{}');
            $hasTemp = false;
        }
        $areaSlugs = [];


        if (isset($tempData->housing_type_id) && $tempData->housing_type_id) {
            $housingTypeTempX = HousingType::where('id', $tempData->housing_type_id)->first();
        } else {
            $housingTypeTempX = null;
        }

        if (isset($tempDataFull) && isset($tempData->step1_slug) && $tempData->step1_slug) {
            $topParent = HousingTypeParent::whereNull('parent_id')->where('slug', $tempData->step1_slug)->first();
            array_push($areaSlugs, $topParent->title);
            $secondAreaList = HousingTypeParent::where('parent_id', $topParent->id)->get();
        } else {
            $secondAreaList = null;
        }

        if (isset($tempDataFull) && isset($tempData->step2_slug) && isset($tempData->step1_slug) && $tempData->step1_slug && $tempData->step2_slug) {
            $topParent = HousingTypeParent::whereNull('parent_id')->where('slug', $tempData->step1_slug)->first();
            $topParentSecond = HousingTypeParent::where('parent_id', $topParent->id)->where('slug', $tempData->step2_slug)->first();
            array_push($areaSlugs, $topParentSecond->title);
            $housingTypes = HousingTypeParentConnection::where("parent_id", $topParentSecond->id)->join('housing_types', 'housing_types.id', "=", "housing_type_parent_connections.housing_type_id")->get();
        } else {
            $housingTypes = null;
        }

        if (isset($tempDataFull) && isset($tempData->step3_slug) && isset($tempData->step2_slug) && $tempData->step2_slug && isset($tempData->step1_slug) && $tempData->step1_slug && $tempData->step3_slug) {
            $housingTypeTemp = HousingTypeParentConnection::where('slug', $tempData->step3_slug)->where("parent_id", $topParentSecond->id)->join('housing_types', 'housing_types.id', "=", "housing_type_parent_connections.housing_type_id")->first();

            array_push($areaSlugs, $housingTypeTemp->title);
        }

        if ($tempDataFull && isset($tempData->statuses)) {
            $selectedStatuses = HousingStatus::whereIn("id", $tempData->statuses)->get();
        } else {
            $selectedStatuses = [];
        }
        if ($tempDataFull) {
            $tempDataFull = $tempDataFull;
        } else {
            $tempDataFull = json_decode('{"step_order" : 1}');
        }
        $bankAccounts = BankAccount::all();
        $userPlan = UserPlan::where('user_id', auth()->user()->parent_id ?? auth()->user()->id)->first();
        $featuredPrices = DopingPricing::where('item_type', 1)->get();
        $topRowPrices = DopingPricing::where('item_type', 2)->get();
        return view('institutional.projects.createv2', compact('topRowPrices', 'featuredPrices', 'housingTypeParent', 'cities', 'prices', 'tempData', 'housing_status', 'tempDataFull', 'bankAccounts', 'selectedStatuses', 'userPlan', 'hasTemp', 'secondAreaList', 'housingTypes', 'areaSlugs', 'housingTypeTempX'));
    }

    public function createV3()
    {
        return view('institutional.projects.createv3');
    }

    public function editV2( $id)
    {
        $housingTypeParent = HousingTypeParent::whereNull('parent_id')->get();
        $prices = SinglePrice::where('item_type', 1)->get();
        $cities = City::get();
        $tempUpdateHas = false;
        $housing_status = HousingStatus::all();
        $tempDataFull = Project::where('id', $id)->first();
        $project = Project::where('id', $id)->first();
        $tempDataFull2 = Project::where('id', $id)->first();
        $housingType = HousingType::where('id', $tempDataFull->housing_type_id)->first();
        $tempUpdate = TempOrder::where('item_type', 3)->where('user_id', auth()->user()->id)->first();
        if ($tempUpdate && isset($tempUpdate->data) && $tempUpdate->data && isset(json_decode($tempUpdate->data)->data_slug) && json_decode($tempUpdate->data)->data_slug &&  json_decode($tempUpdate->data)->data_slug == $slug) {
            $tempUpdateHas = true;
            $tempDataFull = $tempUpdate;

            $tempData = json_decode($tempDataFull->data);
            $tempData->step3_slug = $housingType->slug;
        } else {
            TempOrder::where('item_type', 3)->where('user_id', auth()->user()->id)->delete();
            if ($tempDataFull) {
                $tempData = $tempDataFull;
                $tempData->roomInfoKeys = $tempDataFull->roomInfo;
                $tempData->step3_slug = $housingType->slug;
            } else {
                $tempData = json_decode("{}");
            }
            $tempDataFull->data_slug = $tempDataFull->slug;
            $selectedStatuses = HousingStatus::select("id")->whereIn("id", $tempDataFull2->housingStatusIds)->get()->keyBy('id')->toArray();
            $tempDataFull->statuses = array_keys((array) $selectedStatuses);
            $tempDataFull->images = $tempDataFull->images;
            $tempDataFull->situations = $tempDataFull->situations;
            TempOrder::create([
                "user_id" => auth()->user()->id,
                "data" => json_encode($tempDataFull),
                "item_type" => 3,
                "step_order" => 1,
            ]);
        }

        $selectedStatuses = $tempDataFull->statuses;
        if ($tempDataFull) {
            $tempDataFull = $tempDataFull;
        } else {
            $tempDataFull = json_decode('{"step_order" : 1}');
        }

        $userPlan = UserPlan::where('user_id', auth()->user()->id)->first();
        
        return view('institutional.projects.editv2', compact('tempUpdateHas', 'project', 'housingTypeParent', 'cities', 'prices', 'tempData', 'housing_status', 'tempDataFull', 'selectedStatuses', 'userPlan'));
    }

    public function editV3($projectSlug, $projectId)
    {
        return view('institutional.projects.editv3', compact('projectId'));
    }

    public function getBusyDatesByStatusType($statusId, Request $request)
    {
        return json_encode([
            "busy_dates" => StandOutUser::where('housing_status_id', $statusId)->where('item_order', $request->input('order'))->get(),
            "price" => PricingStandOut::where('housing_status_id', $statusId)->where('order', $request->input('order'))->first(),
        ]);
    }

    public function getHousingTypeChildren(Request $request, $slug)
    {
        if ($request->input('parent_slug')) {
            $topParent = HousingTypeParent::whereNull('parent_id')->where('slug', $request->input('parent_slug'))->first();
            $housingTypeParent = HousingTypeParent::where('slug', $slug)->where('parent_id', $topParent->id)->first();
        } else {
            $housingTypeParent = HousingTypeParent::where('slug', $slug)->first();
        }

        if ($housingTypeParent->is_end) {
            $housingTypes = HousingTypeParentConnection::where("parent_id", $housingTypeParent->id)->join('housing_types', 'housing_types.id', "=", "housing_type_parent_connections.housing_type_id")->get();
            return [
                "data" => $housingTypes,
                "is_end" => 0,
            ];
        } else {
            $housingTypeChildren = HousingTypeParent::where('parent_id', $housingTypeParent->id)->get();
            return [
                "data" => $housingTypeChildren,
                "is_end" => 1,
            ];
        }
    }

    public function createProjectEnd(Request $request)
    {

        DB::beginTransaction();
        $tempOrderFull = TempOrder::where('user_id', auth()->user()->id)->where('item_type', 1)->first();
        $tempOrder = json_decode($tempOrderFull->data);
        $housingType = HousingType::where('slug', $tempOrder->step3_slug)->firstOrFail();
        $housingTypeInputs = json_decode($housingType->form_json);

        if ($tempOrderFull->step_order == 3) {
            $oldCoverImage = public_path('project_images/' . $tempOrder->cover_image); // Mevcut dosyanın yolu
            $extension = explode('.', $tempOrder->cover_image);
            $newCoverImage = Str::slug($tempOrder->name) . (Auth::user()->id) . '.' . end($extension);
            $newCoverImageName = public_path('storage/project_images/' . $newCoverImage); // Yeni dosya adı ve yolu
            if (File::exists($oldCoverImage)) {
                File::move($oldCoverImage, $newCoverImageName);
            }
            $oldDocument = public_path('housing_documents/' . $tempOrder->document); // Mevcut dosyanın yolu
            $extension = explode('.', $tempOrder->document);
            $newDocument = Str::slug($tempOrder->name) . '_verification_' . (Auth::user()->id) . '.' . end($extension);
            $newDocumentFile = public_path('housing_documents/' . $newDocument); // Yeni dosya adı ve yolu
            if (File::exists($oldDocument)) {
                File::move($oldDocument, $newDocumentFile);
            }
            $now = Carbon::now();
            if ($tempOrder->{"pricing-type"} == "2") {
                $singlePrice = SinglePrice::where('id', $tempOrder->price_id)->first();
                $endDate = $now->addMonths($singlePrice->month);
            } else {
                $endDate = $now->addMonths(2);
            }

            if (isset($tempOrder->has_blocks) && $tempOrder->has_blocks) {
                $houseCount = 0;
                for ($j = 0; $j < count($tempOrder->blocks); $j++) {
                    if (isset($tempOrder->{"house_count" . $j}) && $tempOrder->{"house_count" . $j}) {
                        $houseCount += $tempOrder->{"house_count" . $j};
                    }
                }
            } else {
                $houseCount = $tempOrder->house_count;
            }


            $instUser = User::where("id", Auth::user()->id)->first();
            $project = Project::create([
                "housing_type_id" => $housingType->id,
                "step1_slug" => $tempOrder->step1_slug,
                "step2_slug" => $tempOrder->step2_slug,
                "project_title" => $tempOrder->name,
                "create_company" => $tempOrder->create_company,
                "total_project_area" => str_replace('.', '', $tempOrder->total_project_area),
                "start_date" => $tempOrder->start_date,
                "project_end_date" => $tempOrder->end_date,
                "slug" => Str::slug($tempOrder->name),
                "address" => "asd",
                "location" => $tempOrder->location,
                "description" => $tempOrder->description,
                "room_count" => $houseCount,
                "city_id" => $tempOrder->city_id,
                "county_id" => $tempOrder->county_id,
                "neighbourhood_id" => $tempOrder->neighbourhood_id,
                "user_id" => $instUser->parent_id ? $instUser->parent_id : $instUser->id,
                "status_id" => 1,
                "image" => 'public/project_images/' . $newCoverImage,
                'document' => $newDocument,
                "end_date" => $endDate->format('Y-m-d'),
                "status" => 2,
                "have_blocks" => isset($tempOrder->has_blocks) ? ($tempOrder->has_blocks ? true : false) : false
            ]);


            for ($i = 0; $i < $houseCount; $i++) {
                if (isset($tempOrder->{"pay-dec-count" . ($i + 1)})) {
                    ProjectHousing::create([
                        "key" => "pay-dec-count" . ($i + 1),
                        "name" => "pay-dec-count" . ($i + 1),
                        "value" => $tempOrder->{"pay-dec-count" . ($i + 1)},
                        "project_id" => $project->id,
                        "room_order" => $i + 1,
                    ]);
                    for ($j = 0; $j < $tempOrder->{"pay-dec-count" . ($i + 1)}; $j++) {
                        if (isset($tempOrder->{"pay_desc_price" . ($i + 1) . $j})) {
                            ProjectHousing::create([
                                "key" => "pay_desc_price" . ($i + 1) . $j,
                                "name" => "pay_desc_price" . ($i + 1) . $j,
                                "value" => str_replace('.', '', $tempOrder->{"pay_desc_price" . ($i + 1) . $j}),
                                "project_id" => $project->id,
                                "room_order" => $i + 1,
                            ]);
                        }

                        if (isset($tempOrder->{"pay_desc_date" . ($i + 1) . $j})) {
                            ProjectHousing::create([
                                "key" => "pay_desc_date" . ($i + 1) . $j,
                                "name" => "pay_desc_date" . ($i + 1) . $j,
                                "value" => $tempOrder->{"pay_desc_date" . ($i + 1) . $j},
                                "project_id" => $project->id,
                                "room_order" => $i + 1,
                            ]);
                        }
                    }
                }
            }

            foreach ($tempOrder->statuses as $status) {
                ProjectHousingType::create([
                    "project_id" => $project->id,
                    "housing_type_id" => $status,
                ]);
            }

            if (isset($tempOrder->has_blocks) && $tempOrder->has_blocks) {
                foreach ($tempOrder->blocks as $key => $block) {
                    Block::create([
                        "project_id" => $project->id,
                        "block_name" => $block,
                        "housing_count" => $tempOrder->{"house_count" . $key}
                    ]);
                }
            }


            foreach ($tempOrder->images as $key => $image) {
                $eskiDosyaAdi = public_path('project_images/' . $image); // Mevcut dosyanın yolu
                $extension = explode('.', $image);
                $newFileName = Str::slug($tempOrder->name) . '-' . ($key + 1) . '.' . end($extension);
                $yeniDosyaAdi = public_path('storage/project_images/' . $newFileName); // Yeni dosya adı ve yolu

                if (File::exists($eskiDosyaAdi)) {
                    if (File::move($eskiDosyaAdi, $yeniDosyaAdi)) {
                        $projectImage = new ProjectImage(); // Eğer model kullanıyorsanız
                        $projectImage->image = 'public/project_images/' . $newFileName;
                        $projectImage->project_id = $project->id;
                        $projectImage->save();
                    }
                }
            }

            foreach ($tempOrder->situations as $key => $situation) {
                $eskiDosyaAdi = public_path('situation_images/' . $situation); // Mevcut dosyanın yolu
                $extension = explode('.', $situation);
                $newFileName = Str::slug($tempOrder->name) . '-' . ($key + 1) . '.' . end($extension);
                $yeniDosyaAdi = public_path('situation_images/' . $newFileName); // Yeni dosya adı ve yolu

                if (File::exists($eskiDosyaAdi)) {
                    if (File::move($eskiDosyaAdi, $yeniDosyaAdi)) {
                        $projectImage = new ProjectSituation(); // Eğer model kullanıyorsanız
                        $projectImage->situation = 'public/situation_images/' . $newFileName;
                        $projectImage->project_id = $project->id;
                        $projectImage->save();
                    }
                }
            }

            for ($i = 0; $i < $houseCount; $i++) {
                $paymentPlanOrder = 0;
                for ($j = 0; $j < count($housingTypeInputs); $j++) {
                    if ($housingTypeInputs[$j]->type != "checkbox-group" && $housingTypeInputs[$j]->type != "file") {
                        if ($housingTypeInputs[$j]->name == "installments[]" || $housingTypeInputs[$j]->name == "advance[]" || $housingTypeInputs[$j]->name == "installments-price[]") {
                            if (isset($tempOrder->roomInfoKeys->{'payment-plan' . ($i + 1)}) &&  $tempOrder->roomInfoKeys->{'payment-plan' . ($i + 1)}) {
                                if (in_array("taksitli", $tempOrder->roomInfoKeys->{'payment-plan' . ($i + 1)})) {

                                    ProjectHousing::create([
                                        "key" => $housingTypeInputs[$j]->label,
                                        "name" => $housingTypeInputs[$j]->name,
                                        "value" => str_replace('.', '', $tempOrder->roomInfoKeys->{substr($housingTypeInputs[$j]->name, 0, -2)}[$i]),
                                        "project_id" => $project->id,
                                        "room_order" => $i + 1,
                                    ]);
                                    if (substr($housingTypeInputs[$j]->name, 0, -2) == "installments-price") {
                                        $paymentPlanOrder++;
                                    }
                                }
                            }
                        } else {
                            if (str_contains($housingTypeInputs[$j]->className, 'price-only')) {

                                if (isset($housingTypeInputs[$j]->name) && isset($tempOrder->roomInfoKeys->{substr($housingTypeInputs[$j]->name, 0, -2)}) && isset($tempOrder->roomInfoKeys->{substr($housingTypeInputs[$j]->name, 0, -2)}[$i]) && $tempOrder->roomInfoKeys->{substr($housingTypeInputs[$j]->name, 0, -2)}[$i] != null) {
                                    ProjectHousing::create([
                                        "key" => $housingTypeInputs[$j]->label,
                                        "name" => $housingTypeInputs[$j]->name,
                                        "value" => str_replace('.', '', $tempOrder->roomInfoKeys->{substr($housingTypeInputs[$j]->name, 0, -2)}[$i]),
                                        "project_id" => $project->id,
                                        "room_order" => $i + 1,
                                    ]);
                                }
                            } else {
                                if (isset($housingTypeInputs[$j]->name) && isset($tempOrder->roomInfoKeys->{substr($housingTypeInputs[$j]->name, 0, -2)}) && isset($tempOrder->roomInfoKeys->{substr($housingTypeInputs[$j]->name, 0, -2)}[$i]) && $tempOrder->roomInfoKeys->{substr($housingTypeInputs[$j]->name, 0, -2)}[$i] != null) {

                                    ProjectHousing::create([
                                        "key" => $housingTypeInputs[$j]->label,
                                        "name" => $housingTypeInputs[$j]->name,
                                        "value" => $tempOrder->roomInfoKeys->{substr($housingTypeInputs[$j]->name, 0, -2)}[$i],
                                        "project_id" => $project->id,
                                        "room_order" => $i + 1,
                                    ]);
                                }
                            }
                        }
                    } else if ($housingTypeInputs[$j]->type != "file") {

                        ProjectHousing::create([
                            "key" => $housingTypeInputs[$j]->label,
                            "name" => $housingTypeInputs[$j]->name,
                            "value" => isset($tempOrder->roomInfoKeys->{substr($housingTypeInputs[$j]->name, 0, -2) . ($i + 1)}) ? json_encode($tempOrder->roomInfoKeys->{substr($housingTypeInputs[$j]->name, 0, -2) . ($i + 1)}) : json_encode([]),
                            "project_id" => $project->id,
                            "room_order" => $i + 1,
                        ]);
                    } else if ($housingTypeInputs[$j]->type == "file") {
                        if (!$housingTypeInputs[$j]->multiple) {
                            $eskiDosyaAdi = public_path('storage/project_images/' . $tempOrder->roomInfoKeys->image[$i]); // Mevcut dosyanın yolu
                            $extension = explode('.', $tempOrder->roomInfoKeys->image[$i]);
                            $newImageName = str_replace('.' . end($extension), '', $tempOrder->roomInfoKeys->image[$i]);
                            if (substr($newImageName, -1) == $i) {
                                $newFileName = Str::slug($tempOrder->name) . '-project_housing-image-' . ($i) . '.' . end($extension);
                                $yeniDosyaAdi = public_path('project_housing_images/' . $newFileName); // Yeni dosya adı ve yolu
                                if (File::exists($eskiDosyaAdi)) {
                                    File::move($eskiDosyaAdi, $yeniDosyaAdi);
                                }
                            } else {
                                $newFileName = Str::slug($tempOrder->name) . '-project_housing-image-' . (substr($newImageName, -1)) . '.' . end($extension);
                            }

                            ProjectHousing::create([
                                "key" => $housingTypeInputs[$j]->label,
                                "name" => $housingTypeInputs[$j]->name,
                                "value" => $newFileName,
                                "project_id" => $project->id,
                                "room_order" => $i + 1,
                            ]);
                        }
                    }
                }
            }


            if (isset($tempOrder->top_row) && $tempOrder->top_row) {
                $now = Carbon::now();
                $endDate = Carbon::now()->addDays($tempOrder->top_row_data_day);
                $standOut = StandOutUser::create([
                    "user_id" => auth()->user()->parent_id ?? auth()->user()->parent_id ?? auth()->user()->id,
                    "item_id" => $project->id,
                    "item_type" => 1,
                    "housing_type_id" => $tempOrder->housing_type_id,
                    "start_date" => $now->format('y-m-d'),
                    "end_date" => $endDate->format('y-m-d'),
                ]);

                $pricing = DopingPricing::where('item_type', 2)->where('day', $tempOrder->top_row_data_day)->first();
                DopingOrder::create([
                    "stand_out_id" => $standOut->id,
                    "project_id" => $project->id,
                    "key" => $tempOrder->key,
                    "user_id" => $instUser->parent_id ? $instUser->parent_id : $instUser->id,
                    "bank_id" => $tempOrder->bank_id,
                    "price" => $pricing->price,
                    "status" => 0,
                ]);
            }

            if (isset($tempOrder->featured) && $tempOrder->featured) {
                $now = Carbon::now();
                $endDate = Carbon::now()->addDays($tempOrder->featured_data_day);
                $standOut = StandOutUser::create([
                    "user_id" => auth()->user()->parent_id ?? auth()->user()->parent_id ?? auth()->user()->id,
                    "item_id" => $project->id,
                    "item_type" => 1,
                    "housing_type_id" => 0,
                    "start_date" => $now->format('y-m-d'),
                    "end_date" => $endDate->format('y-m-d'),
                ]);

                $pricing = DopingPricing::where('item_type', 1)->where('day', $tempOrder->featured_data_day)->first();
                DopingOrder::create([
                    "stand_out_id" => $standOut->id,
                    "project_id" => $project->id,
                    "key" => $tempOrder->key,
                    "user_id" => $instUser->parent_id ? $instUser->parent_id : $instUser->id,
                    "bank_id" => $tempOrder->bank_id,
                    "price" => $pricing->price,
                    "status" => 0,
                ]);
            }
            $statusID = $project->housingStatus->where('housing_type_id', '<>', 1)->first()->housing_type_id ?? 1;
            $status = HousingStatus::find($statusID);

            $notificationLink =  route('project.detail', ['slug' => $project->slug . "-" . $status->slug . "-" . $project->step2_slug . "-" . $project->housingtype->slug, 'id' => $project->id + 1000000]);
            $notificationText = 'Proje #' . $project->id . ' şu anda admin onayına gönderildi. Onaylandığı takdirde yayına alınacaktır.';
            DocumentNotification::create([
                'user_id' => $instUser->parent_id ? $instUser->parent_id : $instUser->id,
                'text' => $notificationText,
                'item_id' => $project->id,
                'link' => $notificationLink,
                'owner_id' => 4,
                'is_visible' => true,
            ]);


            DB::commit();

            TempOrder::where('user_id', auth()->user()->id)->where('item_type', 1)->delete();
            UserPlan::where('user_id', $instUser->parent_id ? $instUser->parent_id : $instUser->id)->decrement('project_limit');

            return json_encode([
                "status" => true,
            ]);



            $notificationLink =  route('project.detail', ['slug' => $project->slug . "-" . $status->slug . "-" . $project->step2_slug . "-" . $project->housingtype->slug, 'id' => $project->id + 1000000]);
            $notificationText = 'Proje #' . $project->id . ' şu anda admin onayına gönderildi. Onaylandığı takdirde yayına alınacaktır.';
            DocumentNotification::create([
                'user_id' => $instUser->parent_id ? $instUser->parent_id : $instUser->id,
                'text' => $notificationText,
                'item_id' => $project->id,
                'link' => $notificationLink,
                'owner_id' => 4,
                'is_visible' => true,
            ]);

            DB::commit();

            TempOrder::where('user_id', auth()->user()->id)->where('item_type', 1)->delete();
            UserPlan::where('user_id', $instUser->parent_id ? $instUser->parent_id : $instUser->id)->decrement('project_limit');

            return json_encode([
                "status" => true,
            ]);
        } else {
            return json_encode([
                "status" => false,
                "message" => "Son aşamada değilsiniz",
            ]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            "housing_type" => "required",
            "name" => "required",
            "address" => "required",
            "location" => "required",
            "brand_id" => "required",
            "description" => "required",
            "house_count" => "required",
            "cover_photo" => "required",
            "document" => "required|file|max:2048",
        ]);

        if (UserPlan::where('user_id', auth()->user()->id)->sum('project_limit') <= 0) {
            return redirect()->back()->withErrors(['not_enough_limit' => 'Proje oluşturma hakkınız doldu.']);
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentName = $request->project_title . ' proje belgesi.' . $document->getClientOriginalExtension();

            // Dosyayı public/housing_documents klasörüne taşı
            $document->move(public_path('/housing_documents'), $documentName);
        }

        $housingTypeInputs = HousingType::where('id', $request->input('housing_type'))->first();
        $housingTypeInputs = json_decode($housingTypeInputs->form_json);
        $errors = [];

        for ($i = 0; $i < $request->input('house_count'); $i++) {
            for ($j = 0; $j < count($housingTypeInputs); $j++) {
                if (isset($housingTypeInputs[$j]->name) && $housingTypeInputs[$j]->type != "file" && $housingTypeInputs[$j]->type != "checkbox-group" && $request->input(substr($housingTypeInputs[$j]->name, 0, -2)) && $request->input(substr($housingTypeInputs[$j]->name, 0, -2))[$i] == null && $housingTypeInputs[$j]->required) {
                    array_push($errors, ($i + 1) . " nolu konutun " . $housingTypeInputs[$j]->label . " alanı boş bırakılamaz");
                }
            }
        }

        if ($request->hasFile('cover_photo')) {
            $uploadedFile = $request->file('cover_photo');

            $filePath = $uploadedFile->store('public/project_images');
        }

        if (count($errors) == 0) {
            $project = Project::create([
                "housing_type_id" => $request->input('housing_type'),
                "project_title" => $request->input('name'),
                "slug" => Str::slug($request->input('name')),
                "address" => $request->input('address'),
                "location" => $request->input('location'),
                "brand_id" => $request->input('brand_id'),
                "description" => $request->input('description'),
                "room_count" => $request->input('house_count'),
                "city_id" => $request->input('city_id'),
                "county_id" => $request->input('county_id'),
                "user_id" => auth()->user()->parent_id ?? auth()->user()->id,
                "status_id" => 1,
                "image" => $filePath,
                'document' => $documentName,
                "status" => 2,
            ]);

            UserPlan::where('user_id', auth()->user()->id)->decrement('project_limit');

            foreach ($request->file('project_images') as $image) {
                // Dosyayı uygun bir konuma kaydedin, örneğin "public/project_images" klasörüne
                $path = $image->store('public/project_images');

                // Dosya yolunu veritabanına ekleyin
                $projectImage = new ProjectImage(); // Eğer model kullanıyorsanız
                $projectImage->image = $path;
                $projectImage->project_id = $project->id;
                $projectImage->save();
            }

            for ($i = 0; $i < $request->input('house_count'); $i++) {
                for ($j = 0; $j < count($housingTypeInputs); $j++) {
                    if ($housingTypeInputs[$j]->type == "file") {
                        if ($request->hasFile(substr($housingTypeInputs[$j]->name, 0, -2))) {
                            $images = $request->file(substr($housingTypeInputs[$j]->name, 0, -2));

                            foreach ($images as $key => $image) {
                                if ($image->isValid()) {
                                    $imageName = Str::slug(Str::slug($request->input('name'))) . '-' . ($key + 1) . time() . '.' . $image->getClientOriginalExtension();
                                    $image->move(public_path('/project_housing_images'), $imageName);
                                    ProjectHousing::create([
                                        "key" => $housingTypeInputs[$j]->label,
                                        "name" => $housingTypeInputs[$j]->name,
                                        "value" => $imageName,
                                        "project_id" => $project->id,
                                        "room_order" => $key + 1,
                                    ]);
                                } else {
                                }
                            }
                        }

                        if ($housingTypeInputs[$j]->name == "images[]") {
                            $files = [];
                            for ($k = 0; $k < count($request->file('images' . ($i + 1))); $k++) {
                                $image = $request->file('images' . ($i + 1))[$k][0];
                                $imageName = Str::slug(Str::slug($request->input('name'))) . '-' . ($i) . '-' . $k . '-' . time() . '.' . $image->getClientOriginalExtension();
                                $image->move(public_path('/project_housing_images'), $imageName);
                                array_push($files, $imageName);
                            }

                            ProjectHousing::create([
                                "key" => $housingTypeInputs[$j]->label,
                                "name" => $housingTypeInputs[$j]->name,
                                "value" => json_encode($files),
                                "project_id" => $project->id,
                                "room_order" => $i + 1,
                            ]);
                        }
                    } else {
                        if ($housingTypeInputs[$j]->type != "checkbox-group") {
                            if (isset($housingTypeInputs[$j]->name) && $request->input(substr($housingTypeInputs[$j]->name, 0, -2))[$i] != null) {
                                ProjectHousing::create([
                                    "key" => $housingTypeInputs[$j]->label,
                                    "name" => $housingTypeInputs[$j]->name,
                                    "value" => is_object($request->input(substr($housingTypeInputs[$j]->name, 0, -2))[$i]) || is_array($request->input(substr($housingTypeInputs[$j]->name, 0, -2))[$i]) ? json_encode($request->input(substr($housingTypeInputs[$j]->name, 0, -2))[$i]) : $request->input(substr($housingTypeInputs[$j]->name, 0, -2))[$i],
                                    "project_id" => $project->id,
                                    "room_order" => $i + 1,
                                ]);
                            }
                        } else {
                            ProjectHousing::create([
                                "key" => $housingTypeInputs[$j]->label,
                                "name" => $housingTypeInputs[$j]->name,
                                "value" => is_object($request->input(substr($housingTypeInputs[$j]->name, 0, -2) . ($i + 1))) || is_array($request->input(substr($housingTypeInputs[$j]->name, 0, -2) . ($i + 1))) ? json_encode($request->input(substr($housingTypeInputs[$j]->name, 0, -2) . ($i + 1))) : '',
                                "project_id" => $project->id,
                                "room_order" => $i + 1,
                            ]);
                        }
                    }
                }
            }
        }

        $statusID = $project->housingStatus->where('housing_type_id', '<>', 1)->first()->housing_type_id ?? 1;
        $status = HousingStatus::find($statusID);

        $notificationLink =  route('project.detail', ['slug' => $project->slug . "-" . $status->slug . "-" . $project->step2_slug . "-" . $project->housingtype->slug, 'id' => $project->id + 1000000]);
        $notificationText = 'Proje #' . $project->id . ' yayınlandı.';
        DocumentNotification::create([
            'user_id' => auth()->user()->id,
            'text' => $notificationText,
            'item_id' => $project->id,
            'link' => $notificationLink,
            'owner_id' => 4,
            'is_visible' => true,
        ]);


        return redirect()->route('institutional.projects.index', ["status" => "new_project"]);
    }

    public function getCounties(Request $request)
    {
        $counties = District::where('ilce_sehirkey', $request->input('city'))->get();

        return $counties;
    }

    public function getNeighbourhood(Request $request)
    {
        $counties = Neighborhood::where('mahalle_ilcekey', $request->input('county_id'))->get();

        return $counties;
    }

    public function standOut($projectId)
    {
        $bankAccounts = BankAccount::all();
        $project = Project::where('id', $projectId)->first();
        $featuredPrices = DopingPricing::where('item_type', 1)->get();
        $topRowPrices = DopingPricing::where('item_type', 2)->get();

        return view('institutional.projects.stand_out', compact('projectId', 'project', 'topRowPrices', 'featuredPrices', 'bankAccounts'));
    }

    public function standOutPost(Request $request, $projectId)
    {
        $request->validate([
            "key" => "required",
            "bank_id" => "required",
            "price" => "required",
        ]);

        $project = Project::where('id', $projectId)->first();

        if ($request->input('is_featured')) {
            $standOutPrice = DopingPricing::where('day', $request->input('selected_featured_price'))->where('item_type', 1)->first();
            $now = Carbon::now();
            $endDate = Carbon::now()->addDays($request->selected_featured_price);

            $standOut = StandOutUser::create([
                "user_id" => auth()->user()->parent_id ?? auth()->user()->parent_id ?? auth()->user()->id,
                "item_id" => $projectId,
                "item_type" => 1,
                "housing_type_id" => 0,
                "start_date" => $now->format('y-m-d'),
                "end_date" => $endDate->format('y-m-d'),
            ]);

            DopingOrder::create([
                "key" => $request->input('key'),
                "bank_id" => $request->input('bank_id'),
                "price" => $standOutPrice->price,
                "project_id" => $projectId,
                "stand_out_id" => $standOut->id,
                "user_id" => auth()->user()->id,
                "status" => 0,
            ]);
        }

        if ($request->input('is_top_row')) {
            $standOutPrice = DopingPricing::where('day', $request->input('selected_top_row_price'))->where('item_type', 2)->first();

            $now = Carbon::now();
            $endDate = Carbon::now()->addDays($request->selected_top_row_price);

            $standOut = StandOutUser::create([
                "user_id" => auth()->user()->parent_id ?? auth()->user()->parent_id ?? auth()->user()->id,
                "item_id" => $projectId,
                "item_type" => 1,
                "housing_type_id" => $project->housing_type_id,
                "start_date" => $now->format('y-m-d'),
                "end_date" => $endDate->format('y-m-d'),
            ]);

            DopingOrder::create([
                "key" => $request->input('key'),
                "bank_id" => $request->input('bank_id'),
                "price" => $standOutPrice->price,
                "project_id" => $projectId,
                "stand_out_id" => $standOut->id,
                "user_id" => auth()->user()->id,
                "status" => 0,
            ]);
        }

        return redirect()->route('institutional.projects.index');
    }

    public function getStandOutPrices(Request $request)
    {
        $prices = [];
        if ($request->input('featured')) {
            $priceFeatured = DopingPricing::where('day', $request->input('featured_id'))->where('item_type', 1)->first();

            array_push($prices, $priceFeatured);
        }

        if ($request->input('top_row')) {
            $pricingTopRow = DopingPricing::where('day', $request->input('top_row_id'))->where('item_type', 1)->first();

            array_push($prices, $pricingTopRow);
        }

        return $prices;
    }

    public function pricingList(Request $request)
    {
        $pricingStandOuts = PricingStandOut::where('housing_status_id', $request->input('housing_status_id'))->where('type', $request->input('type'))->get();

        return json_encode([
            "status" => true,
            "data" => $pricingStandOuts,
        ]);
    }

    public function edit($id)
    {
        $project = Project::with("roomInfo")->where('id', $id)->first();
        $project->housingStatusesFull = $project->housingStatus->keyBy('housing_type_id')->toArray();
        $results = ProjectHousing::select(DB::raw('max(name) as name , max(value) as value, max(room_order) as room_order'))
            ->where('project_id', $id)
            ->groupBy('room_order', 'name')
            ->orderBy('room_order')
            ->get();

        $groupedData = [];
        foreach ($results as $key => $result) {
            $groupedData[str_replace("[]", "", $result['name'])][$result->room_order - 1] = $result->value;
        }

        $project->roomInfoKeys = $groupedData;

        $brands = Brand::where('user_id', auth()->user()->parent_id ?? auth()->user()->parent_id ?? auth()->user()->id)->where('status', 1)->get();
        $housing_types = HousingType::all();
        $housing_status = HousingStatus::all();
        $cities = City::get();
        $counties = County::where('city_id', $project->city_id)->get();
        return view('institutional.projects.edit', compact('project', 'housing_types', 'housing_status', 'brands', 'cities', 'counties'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "housing_type" => "required",
            "name" => "required",
            "address" => "required",
            "location" => "required",
            "brand_id" => "required",
            "description" => "required",
            "house_count" => "required",
        ]);

        $housingTypeInputs = HousingType::where('id', $request->input('housing_type'))->first();
        $housingTypeInputs = json_decode($housingTypeInputs->form_json);
        $errors = [];

        for ($i = 0; $i < $request->input('house_count'); $i++) {
            for ($j = 0; $j < count($housingTypeInputs); $j++) {
                if (isset($housingTypeInputs[$j]->name) && $housingTypeInputs[$j]->type != "file" && $housingTypeInputs[$j]->type != "checkbox-group" && $request->input(substr($housingTypeInputs[$j]->name, 0, -2)) && $request->input(substr($housingTypeInputs[$j]->name, 0, -2))[$i] == null && $housingTypeInputs[$j]->required) {
                    array_push($errors, ($i + 1) . " nolu konutun " . $housingTypeInputs[$j]->label . " alanı boş bırakılamaz");
                }
            }
        }

        $project = Project::where('id', $id)->first();
        if ($request->hasFile('cover_photo')) {
            $uploadedFile = $request->file('cover_photo');

            $filePath = $uploadedFile->store('public/project_images');
        } else {
            $filePath = $project->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentName = $request->project_title . ' proje belgesi.' . $document->getClientOriginalExtension();

            // Dosyayı public/housing_documents klasörüne taşı
            $document->move(public_path('/housing_documents'), $documentName);
        } else {
            $documentName = $project->document;
        }

        if (count($errors) == 0) {
            $projectNew = Project::where('id', $id)->update([
                "housing_type_id" => $request->input('housing_type'),
                "project_title" => $request->input('name'),
                "slug" => Str::slug($request->input('name')),
                "address" => $request->input('address'),
                "location" => $request->input('location'),
                "brand_id" => $request->input('brand_id'),
                "description" => $request->input('description'),
                "room_count" => $request->input('house_count'),
                "city_id" => $request->input('city_id'),
                "county_id" => $request->input('county_id') ?? $project->id,
                "status_id" => 1,
                "image" => $filePath,
                'document' => $documentName,
            ]);

            ProjectHousingType::where('project_id', $id)->delete();

            foreach ($request->input('housing_status') as $housingStatus) {
                ProjectHousingType::create([
                    "project_id" => $id,
                    "housing_type_id" => $housingStatus,
                ]);
            }

            $project = Project::where('id', $id)->first();
            if ($request->file('image')) {

                ProjectHousing::where('project_id', $id)->where('name', '!=', 'images[]')->delete();
            } else {
                ProjectHousing::where('project_id', $id)->where('name', '!=', 'images[]')->where('name', '!=', 'image[]')->delete();
            }
            for ($i = 0; $i < $request->input('house_count'); $i++) {
                for ($j = 0; $j < count($housingTypeInputs); $j++) {
                    if ($housingTypeInputs[$j]->type == "file") {
                        if ($request->hasFile(substr($housingTypeInputs[$j]->name, 0, -2))) {
                            $images = $request->file(substr($housingTypeInputs[$j]->name, 0, -2));

                            foreach ($images as $key => $image) {
                                if ($image->isValid()) {
                                    $imageName = Str::slug(Str::slug($request->input('name'))) . '-' . ($key + 1) . time() . '.' . $image->getClientOriginalExtension();
                                    $image->move(public_path('/project_housing_images'), $imageName);
                                    ProjectHousing::create([
                                        "key" => $housingTypeInputs[$j]->label,
                                        "name" => $housingTypeInputs[$j]->name,
                                        "value" => $imageName,
                                        "project_id" => $project->id,
                                        "room_order" => $key + 1,
                                    ]);
                                } else {
                                }
                            }
                        }
                    } else {
                        if ($housingTypeInputs[$j]->type != "checkbox-group") {
                            if (isset($housingTypeInputs[$j]->name) && $request->input(substr($housingTypeInputs[$j]->name, 0, -2))[$i] != null) {
                                ProjectHousing::create([
                                    "key" => $housingTypeInputs[$j]->label,
                                    "name" => $housingTypeInputs[$j]->name,
                                    "value" => is_object($request->input(substr($housingTypeInputs[$j]->name, 0, -2))[$i]) || is_array($request->input(substr($housingTypeInputs[$j]->name, 0, -2))[$i]) ? json_encode($request->input(substr($housingTypeInputs[$j]->name, 0, -2))[$i]) : $request->input(substr($housingTypeInputs[$j]->name, 0, -2))[$i],
                                    "project_id" => $project->id,
                                    "room_order" => $i + 1,
                                ]);
                            }
                        } else {
                            ProjectHousing::create([
                                "key" => $housingTypeInputs[$j]->label,
                                "name" => $housingTypeInputs[$j]->name,
                                "value" => is_object($request->input(substr($housingTypeInputs[$j]->name, 0, -2) . ($i + 1))) || is_array($request->input(substr($housingTypeInputs[$j]->name, 0, -2) . ($i + 1))) ? json_encode($request->input(substr($housingTypeInputs[$j]->name, 0, -2) . ($i + 1))) : '',
                                "project_id" => $project->id,
                                "room_order" => $i + 1,
                            ]);
                        }
                    }
                }
            }
        }

        return redirect()->route('institutional.projects.index', ["status" => "new_project"]);
    }

    public function passive($id)
    {
        Project::where('id', $id)->update([
            "status" => 0
        ]);
    }

    public function active($id)
    {
        Project::where('id', $id)->update([
            "status" => 1
        ]);
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
    }

    public function housingDestroy($id)
    {
        $housing = Housing::findOrFail($id);
        $housing->delete();
    }

    public function housingPassive($id)
    {
        Housing::where('id', $id)->update([
            'status' => 0
        ]);
    }

    public function housingActive($id)
    {
        Housing::where('id', $id)->update([
            'status' => 1
        ]);
    }

    public function newProjectImage(Request $request, $projectId)
    {
        if ($request->hasFile('file')) {
            $uploadedFile = $request->file('file');

            $filePath = $uploadedFile->store('public/project_images');
        }

        ProjectImage::create([
            "image" => $filePath,
            "project_id" => $projectId,
        ]);

        return json_encode([
            "status" => true,
        ]);
    }

    public function deleteProjectImage($projectId, $filename)
    {
        $fileId = explode('--', $filename);

        ProjectImage::where('id', $fileId[1])->delete();
        return json_encode([
            "status" => true,
        ]);
    }

    public function removeProjectHousingFile(Request $request)
    {
        $projectHousing = ProjectHousing::where('project_id', $request->input('projectId'))->where('room_order', $request->input('housingOrder'))->where('name', 'images[]')->first();

        $projectHousingImagesTemp = [];

        $projectHousingImages = json_decode($projectHousing->value);

        foreach ($projectHousingImages as $key => $image) {
            if ($key != $request->input('order')) {
                array_push($projectHousingImagesTemp, $image);
            }
        }

        ProjectHousing::where('project_id', $request->input('projectId'))->where('room_order', $request->input('housingOrder'))->where('name', 'images[]')->update(["value" => json_encode($projectHousingImagesTemp)]);

        return json_encode([
            "status" => true,
        ]);
    }

    public function addProjectHousingFile(Request $request)
    {
        $project = Project::where('id', $request->input('projectId'))->first();
        $projectHousing = ProjectHousing::where('project_id', $request->input('projectId'))->where('room_order', $request->input('housingOrder'))->where('name', 'images[]')->first();
        if ($projectHousing->value) {

            $projectHousingImages = json_decode($projectHousing->value);
        } else {
            $projectHousingImages = [];
        }

        $image = $request->file('file');
        $imageName = $project->slug . '-' . ($request->input('housingOrder')) . '-' . time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('/project_housing_images'), $imageName);

        array_push($projectHousingImages, $imageName);

        ProjectHousing::where('project_id', $request->input('projectId'))->where('room_order', $request->input('housingOrder'))->where('name', 'images[]')->update(["value" => json_encode($projectHousingImages)]);

        $projectHousing = ProjectHousing::where('project_id', $request->input('projectId'))->where('room_order', $request->input('housingOrder'))->where('name', 'images[]')->first();
        return json_encode([
            "status" => true,
            "imageName" => $imageName,
        ]);
    }

    public function logs($projectId)
    {
        $logs = Log::where('item_type', 1)->where('item_id', $projectId)->orderByDesc('created_at')->get();
        return view('institutional.projects.logs', compact('logs'));
    }

    public function updateProjectEnd()
    {
        $tempOrder = TempOrder::where('item_type', 3)->where('user_id', auth()->guard()->user()->id)->first();
        $tempData = json_decode($tempOrder->data);

        Project::where('id', $tempData->id)->update([
            "project_title" => $tempData->project_title,
            "create_company" => $tempData->create_company,
            "total_project_area" => str_replace('.', '', $tempData->total_project_area),
            "island" => str_replace('.', '', $tempData->island),
            "parcel" => str_replace('.', '', $tempData->parcel),
            "start_date" => $tempData->start_date,
            "project_end_date" => $tempData->project_end_date,
            "slug" => Str::slug($tempData->project_title),
            "description" => $tempData->description,
            "location" => $tempData->location,
            "image" => $tempData->image,
            "city_id" => $tempData->city_id,
            "county_id" => $tempData->county_id,
            "neighbourhood_id" => $tempData->neighbourhood_id,
            "status" => "2",
        ]);


        ProjectImage::where('project_id', $tempData->id)->delete();
        foreach ($tempData->images as $key => $image) {
            $projectImage = new ProjectImage(); // Eğer model kullanıyorsanız
            $projectImage->image = 'public/project_images/' . str_replace('storage/project_images/', '', str_replace('public/project_images/', '', $image->image));
            $projectImage->project_id = $tempData->id;
            $projectImage->save();
        }

        ProjectSituation::where('project_id', $tempData->id)->delete();
        foreach ($tempData->situations as $key => $image) {
            $projectImage = new ProjectSituation(); // Eğer model kullanıyorsanız
            $projectImage->situation = 'public/situation_images/' . str_replace('public/situation_images/', '', $image->situation);
            $projectImage->project_id = $tempData->id;
            $projectImage->save();
        }

        $tempOrder->delete();

        return json_encode([
            "status" => true,
        ]);
    }

    public function setSingleHousingData(Request $request, $projectId)
    {

        if ($request->input('allData')) {
            ProjectHousing::where('project_id', $projectId)->where('name', $request->input('inputName'))->update([
                "value" => str_replace('.', '', $request->input('newVal'))
            ]);
        } else {
            ProjectHousing::where('project_id', $projectId)->where('room_order', $request->input('roomOrder'))->where('name', $request->input('inputName'))->update([
                "value" => str_replace('.', '', $request->input('newVal'))
            ]);
        }

        Project::where('id', $projectId)->update([
            "status" => 2
        ]);

        return json_encode([
            "status" => true
        ]);
    }

    public function setSingleHousingImage(Request $request, $projectId)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('project_housing_images'), $fileName);
        }

        if ($request->input('allData')) {
            ProjectHousing::where('project_id', $projectId)->where('name', 'image[]')->update([
                "value" => $fileName
            ]);
        } else {
            ProjectHousing::where('project_id', $projectId)->where('room_order', $request->input('roomOrder'))->where('name', 'image[]')->update([
                "value" => $fileName
            ]);
        }

        Project::where('id', $projectId)->update([
            "status" => 2
        ]);

        return json_encode([
            "status" => true
        ]);
    }

    //Komşumu gor modal fonksiyonu
    public function komsumuGorInfo(Request $request)
    {


        $housingID = $request->no;
        $projectID = $request->projectID;

      
        $city_id = Project::where('id', $projectID)->value('city_id');
        $county_id = Project::where('id', $projectID)->value('county_id');

        $request->validate([
            'email' => 'required|email|unique:users,email',
        ], [
            'email.unique' => 'Bu e-posta adresi zaten kullanılıyor.',
        ]);


        //Kullanıcıyı Ekle
        $userData = [
            'is_show' => 'no',
            'type' => 1,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('komsumugor123'),
            'status' => 1,
            'is_blocked' => 0,
            'has_club' => '0',
        ];

        $user = User::create($userData);

        if (!$user) {
            return back()->with('message', 'Kullanıcı Eklenirken Hata!!');
        }

        //CartORders'a ekle
        $order = new CartOrder;

        $order->user_id = $user->id;
        $order->status = '1';
        $order->key = 1000000 + $projectID + $housingID;
        $order->full_name = $user->name;
        $order->tc = $request->tc;
        $order->is_swap = 0;
        $order->is_reference = 0;
        $order->is_show_user = 'on';
        $order->amount = 0;
        $order->is_disabled = 1; // sonradan eklenen konutlar için
        $order->store_id = Project::where('id', $projectID)->value('user_id');

        $cartJson['item']['id'] = (int)$projectID;
        $cartJson['item']['housing'] = (int)$housingID;


        $neighborProjects  = [];
        $neighborProjects = NeighborView::with('user', 'owner', 'project')->where('project_id', $projectID)->where('user_id', $user->id)->get();
        $cartJson['item']['neighborProjects'] = $neighborProjects;


        function getHouse($project, $key, $roomOrder)
        {
            foreach ($project->roomInfo as $room) {
                if ($room->room_order == $roomOrder && $room->name == $key) {
                    return $room;
                }
            }
        }
        $project = Project::where('id', $projectID)->with('brand', 'roomInfo', 'housingType', 'county', 'city', 'user.projects.housings', 'user.brands', 'user.housings', 'images')->first();

        $cartJson['item']['city_id'] = $city_id;
        $cartJson['item']['county_id'] = $county_id;
        $cartJson['item']['image'] =  URL::to('/') . '/project_housing_images/' . getHouse($project, 'image[]', $housingID)->value;


        $cartJson['type'] = 'project';
        $cartJson['hasCounter'] = false;
        $order->cart = json_encode($cartJson);

        $order->save();

        $fatura = new Invoice();
        $fatura->order_id = $order->id;
        $fatura->total_amount = $request->price;
        $fatura->invoice_number = 'FTR-' . time() . $order->id;
        // Fatura numarası oluşturabilirsiniz.
        $fatura->save();

        return back()->with('message', 'Kaydedildi.');
    } //End

}
