<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\CartOrder;
use App\Models\City;
use App\Models\Click;
use App\Models\Collection;
use App\Models\ShareLink;
use App\Models\SharerPrice;
use App\Models\User;
use App\Models\Housing;
use App\Models\Offer;
use App\Models\Project;
use App\Models\ProjectHousing;
use App\Models\Town;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as FacadesRequest;

class SharerController extends Controller
{

    public function view()
    {
        $pageInfo = [
            "meta_title" => "Emlak Kulüp",
            "meta_keywords" => "Emlak Sepette,Emlak Kulüp",
            "meta_description" => "Emlak Kulüp, konut ihtiyaçlarınız için en güvenilir ve kapsamlı çözümleri sunar. Uzman danışmanlarımızla birlikte, satın alma, kiralamaya veya yatırıma yönelik en iyi seçenekleri keşfedin. Geniş portföyümüzdeki lüks dairelerden ticari gayrimenkullere kadar her türlü konut ihtiyacınızı karşılamak için buradayız. Müşteri memnuniyeti odaklı hizmet anlayışımız ve sektördeki deneyimimizle, Emlak Kulüp sizin yanınızda",
            "meta_author" => "Emlak Sepette",
        ];

        $pageInfo = json_encode($pageInfo);
        $pageInfo = json_decode($pageInfo);
        $user = null;
        if (Auth::check()) {
            $user = User::where("id", Auth::user()->id)->first();
        }

        return view("client.sharer-panel.view", compact('pageInfo', "user"));
    }
    public function index()
    {
        $sharer = User::where('id', auth()->user()->id)->first();
        $items = ShareLink::where('user_id', auth()->user()->id)->get();    

        $store = User::where('id', auth()->user()->id)
            ->with('projects.housings', 'housings', 'city', 'town', 'district', 'neighborhood', 'brands', "child.collections.clicks", 'banners')
            ->first();

        $collections = Collection::with('links.project', 'links.housing', "clicks")->where('user_id', auth()->user()->id)->orderBy("id", "desc")->get();
        $itemsArray = [];
        foreach ($items as $item) {
            $item['project_values'] = $item->projectHousingData($item->item_id)->pluck('value', 'name')->toArray();
            $item['housing'] = $item->housing;
        }

        return view('client.panel.sharer-panel.index', compact('items', "store" , 'sharer', 'collections'));
    }
    public function earnings()
    {
        $user_id = Auth::user()->id;

        $balanceStatus0Lists = SharerPrice::where("user_id", $user_id)
            ->where("status", "0")->get();

        $balanceStatus0 = SharerPrice::where("user_id", $user_id)
            ->where("status", "0")
            ->sum('balance');

        $balanceStatus1Lists = SharerPrice::where("user_id", $user_id)
            ->where("status", "1")->get();

        $balanceStatus1 = SharerPrice::where("user_id", $user_id)
            ->where("status", "1")
            ->sum('balance');

        $balanceStatus2Lists = SharerPrice::where("user_id", $user_id)
            ->where("status", "2")->get();

        $balanceStatus2 = SharerPrice::where("user_id", $user_id)
            ->where("status", "2")
            ->sum('balance');

        $collections = Collection::with("links")->where("user_id", Auth::user()->id)->get();
        $totalStatus1Count = $balanceStatus1Lists->count();
        $successPercentage = $totalStatus1Count > 0 ? ($totalStatus1Count / ($totalStatus1Count + $balanceStatus0Lists->count() + $balanceStatus2Lists->count())) * 100 : 0;

        return view("institutional.earnings.index", compact("balanceStatus0", "successPercentage", "collections", "balanceStatus1", "balanceStatus2", "balanceStatus0Lists", "balanceStatus1Lists", "balanceStatus2Lists"));
    }

    public function showClientLinks($slug, $userid, $id, Request $request)
    {
        $users = User::all();
        $collection = Collection::where("id", $id)->first();

        $cities = City::all()->toArray();
        $bankAccounts = BankAccount::all();

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

        if (isset($collection)) {
            $clickData = [
                'collection_id' => $collection->id,
                'user_id' => auth()->id(),
                'ip_address' => $request->ip(),
            ];


            $collection->uniqueClicks()->updateOrCreate(['user_id' => auth()->id(), 'ip_address' => $request->ip()], $clickData);



            $store = User::with('projects.housings', 'housings', 'city', 'town', 'district', 'neighborhood', 'brands', 'banners')
                ->findOrFail($userid);

            $projects = Project::with("brand", "roomInfo", "housingType", "county", "city", 'user.projects.housings', 'user.brands', 'user.housings', 'images')
                ->where("user_id", $store->id)->where("status", 1)->orderBy("id", "desc")->limit(3)->get();

            $collections = Collection::with('links')->where('user_id', $userid)->get();

            $collection = Collection::findOrFail($id);

            $items = ShareLink::where('user_id', $userid)->where('collection_id', $collection->id)->get();
            $itemsArray = $items->map(function ($item) use ($store) {
                $action = null;
                $offSale = null;

                if ($item->item_type == 2 && isset($item->housing)) {
                    $cartStatus = CartOrder::whereRaw("JSON_UNQUOTE(json_extract(cart, '$.type')) = 'housing'")
                        ->whereRaw("JSON_UNQUOTE(json_extract(cart, '$.item.id')) = ?", [$item->item_id])
                        ->latest()->first();

                    $action = $cartStatus ? (
                        ($cartStatus->status == "0") ? 'payment_await' : (
                            ($cartStatus->status == "1") ? 'sold' : (
                                ($cartStatus->status == "2") ? 'tryBuy' : ''
                            )
                        )
                    ) : 'noCart';

                    $discount_amount = Offer::where('type', 'housing')->where('housing_id', $item->item_id)->where('start_date', '<=', date('Y-m-d H:i:s'))->where('end_date', '>=', date('Y-m-d Hi:i:s'))->first()->discount_amount ?? 0;
                    $housingTypeData = json_decode($item->housing->housing_type_data, true);
                    $offSale = isset($housingTypeData['off_sale1']);
                 
                }
          
                $projectCartOrders = [];
                $projectHousingsList= [];
                $project= null;
                $sumCartOrderQt = 0;
                $discount_amount = 0;

                if ($item->item_type == 1) {

                    $userProjectIds = $store->projects->pluck('id');
                    $discount_amount = Offer::where('type', 'project')
                        ->where('project_id', $item->project->id)
                        ->where('project_housings', 'LIKE', '%' . $item->room_order . '%')
                        ->where('start_date', '<=', date('Y-m-d H:i:s'))->where('end_date', '>=', date('Y-m-d H:i:s'))->first()->discount_amount ?? 0;

                    $status = CartOrder::where(DB::raw('JSON_EXTRACT(cart, "$.item.housing")'), $item->room_order)
                        ->where(DB::raw('JSON_EXTRACT(cart, "$.item.id")'), $item->item_id)
                        ->latest()->first();

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
                        ->where(DB::raw('JSON_EXTRACT(cart, "$.item.id")'), $item->item_id)
                        ->orderByRaw('CAST(housing_id AS SIGNED) ASC')
                        ->get()
                        ->keyBy("housing_id");

                        $projectHousings = ProjectHousing::where('project_id', $item->item_id)->where('room_order', '<=', $item->project->room_count)->get();
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
            

                    $action = $status ? (
                        ($status->status == "0") ? 'payment_await' : (
                            ($status->status == "1") ? 'sold' : (
                                ($status->status == "2") ? 'tryBuy' : ''
                            )
                        )
                    ) : 'noCart';

                    $projectHousing = $item->project->roomInfo->keyBy('name');
                    $sumCartOrderQt = DB::table('cart_orders')
                        ->select(
                            DB::raw('JSON_EXTRACT(cart, "$.item.housing") as housing_id'),
                            DB::raw('JSON_EXTRACT(cart, "$.item.qt") as qt')
                        )
                        ->leftJoin('users', 'cart_orders.user_id', '=', 'users.id')
                        ->where(DB::raw('JSON_EXTRACT(cart, "$.type")'), 'project')
                        ->where(DB::raw('JSON_EXTRACT(cart, "$.item.id")'), $item->project->id)
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
                }

                return [
                    'project_values' => $item->projectHousingData($item->item_id)->pluck('value', 'name')->toArray(),
                    'housing' => $item->housing,
                    'project' => $item->project,
                    "projectCartOrders" => $projectCartOrders,
                    "projectHousingsList" => $projectHousingsList,
                    'action' => $action,
                    'offSale' => $offSale,
                    "sumCartOrderQt" => $sumCartOrderQt,
                    'discount_amount' => $discount_amount
                ];
            });

            $mergedItems = array_map(function ($item, $itemArray) {
                return array_merge($item, $itemArray);
            }, $items->toArray(), $itemsArray->toArray());


            return view('client.club.show', compact("store", "towns", "bankAccounts", "cities", "mergedItems", "collections", "slug", 'projects', 'itemsArray', 'collections', 'collection', 'items'));
        } else {
            return view("errors.404");
        }
    }

    public function viewsLinks($id)
    {
        $collection = Collection::with("clicks.user")->where('id', $id)->first();
        return view('client.panel.sharer-panel.views', compact("collection"));
    }


    public function showLinks($hashedId)
    {
        return $hashedId;
        $collectionId = decode_id($hashedId);

        $collection = Collection::where('id', $collectionId)->first();
        $sharer = User::findOrFail(auth()->user()->id);

        $items = ShareLink::where('user_id', auth()->user()->id)->where('collection_id', $collection->id)->get();
        $itemsArray = $items->map(function ($item) use ($sharer) {
            $action = null;
            $offSale = null;

            if ($item->item_type == 2) {
                $cartStatus = CartOrder::whereRaw("JSON_UNQUOTE(json_extract(cart, '$.type')) = 'housing'")
                    ->whereRaw("JSON_UNQUOTE(json_extract(cart, '$.item.id')) = ?", [$item->item_id])
                    ->latest()->first();

                $action = $cartStatus ? (
                    ($cartStatus->status == 0) ? 'payment_await' : (
                        ($cartStatus->status == 1) ? 'sold' : (
                            ($cartStatus->status == 2) ? 'tryBuy' : ''
                        )
                    )
                ) : 'noCart';

                $sharePrice = 0;
                if ($cartStatus) {
                    $sharePrice = SharerPrice::where("cart_id", $cartStatus->id)->where("user_id", Auth::user()->id)->first();
                }

                $discount_amount = Offer::where('type', 'housing')->where('housing_id', $item->item_id)->where('start_date', '<=', date('Y-m-d H:i:s'))->where('end_date', '>=', date('Y-m-d Hi:i:s'))->first()->discount_amount ?? 0;
                $housingTypeData = json_decode($item->housing->housing_type_data, true);
                $offSale = isset($housingTypeData['off_sale1']);
            }

            if ($item->item_type == 1) {

                $userProjectIds = $sharer->projects->pluck('id');
                $discount_amount = Offer::where('type', 'project')->where('project_id', $item->project->id)
                    ->where('project_housings', 'LIKE', '%' . $item->room_order . '%')->where('start_date', '<=', date('Y-m-d H:i:s'))->where('end_date', '>=', date('Y-m-d H:i:s'))->first()->discount_amount ?? 0;


                $status = CartOrder::where(DB::raw('JSON_EXTRACT(cart, "$.item.housing")'), $item->room_order)
                    ->where(DB::raw('JSON_EXTRACT(cart, "$.item.id")'), $item->item_id)
                    ->latest()->first();

                $sharePrice = 0;
                if ($status) {
                    $sharePrice = SharerPrice::where("cart_id", $status->id)->where("user_id", Auth::user()->id)->first();
                }

                $action = $status ? (
                    ($status->status == "0") ? 'payment_await' : (
                        ($status->status == "1") ? 'sold' : (
                            ($status->status == "2") ? 'tryBuy' : ''
                        )
                    )
                ) : 'noCart';
            }

            return [
                'project_values' => $item->projectHousingData($item->item_id)->pluck('value', 'name')->toArray(),
                'housing' => $item->housing,
                'project' => $item->project,
                'action' => $action,
                'offSale' => $offSale,
                'discount_amount' => $discount_amount,
                "share_price" => $sharePrice
            ];
        });

        $mergedItems = array_map(function ($item, $itemArray) {
            return array_merge($item, $itemArray);
        }, $items->toArray(), $itemsArray->toArray());

        return view('client.panel.sharer-panel.show', compact('mergedItems', 'items', 'sharer', 'collection'));
    }

    public function sharerPanel()
    {
        $orders = SharerPrice::where('user_id', auth()->user()->id)->get();
        return view('client.sharer-panel.panel', compact('orders'));
    }

    public function sharerPanelByAnotherUser($username)
    {
        $sharer = User::where('username', $username)->first();
        $items = ShareLink::where('user_id', $sharer->id)->get();
        $itemsArray = [];
        foreach ($items as $item) {
            if ($item->projectHousingData($item->item_id)) {
                if (isset($item->projectHousingData($item->item_id)[0])) {
                    $item['room_order'] = $item->projectHousingData($item->item_id)[0]['room_order'];
                }
                $item['project_values'] = $item->projectHousingData($item->item_id)->pluck('value', 'name')->toArray();
            }
        }

        return view('client.sharer-panel.index', compact('items', 'sharer'));
    }

    public function deleteCollection($id)
    {
        $collection = Collection::findOrFail($id);
        $collection->delete();

        return redirect()->back();
    }

    public function deleteCollectioJson(Request $request)
    {
        $collection = $request->input('collection');
    
        // `id` değerini al
        $collectionId = $collection['id'];
    
        // Diğer işlemler...
        // Örneğin, Collection modelini kullanarak veritabanında silme işlemi yapabilirsiniz
        $collection = Collection::find($collectionId);
        
        if ($collection) {
            $collection->delete();
            return response()->json(['success' => true, 'message' => 'Collection deleted successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Collection not found']);
        }
    }

  
    public function editCollection($id, Request $request)
    {
        $collection = Collection::findOrFail($id);
        $collection->update([
            "name" => $request->input("collectionName")
        ]);

        return redirect()->back();
    }
}
