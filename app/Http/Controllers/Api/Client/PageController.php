<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\CartOrder;
use App\Models\City;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\District;
use App\Models\Filter;
use App\Models\Housing;
use App\Models\HousingStatus;
use App\Models\HousingType;
use App\Models\HousingTypeParent;
use App\Models\Invoice;
use App\Models\Menu;
use App\Models\Neighborhood;
use App\Models\Offer;
use App\Models\Project;
use App\Models\Rate;
use App\Models\Bid;
use App\Models\ShareLink;
use App\Models\SharerPrice;
use App\Models\StandOutUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    public function removeFromCollection(Request $request)
    {
        $itemType = $request->input('itemType');
        $itemId = $request->input('itemId');
        $projectId = $request->input('projectId');

        $link = null;

        $link = ShareLink::where('item_id', $projectId)
            ->where('item_type', $itemType === 'project' ? 1 : 2)
            ->when($itemType === 'project', function ($query) use ($itemId) {
                return $query->where('room_order', $itemId);
            })
            ->first();


        if ($link) {
            ShareLink::where('item_id', $projectId)
                ->where('item_type', $itemType === 'project' ? 1 : 2)
                ->when($itemType === 'project', function ($query) use ($itemId) {
                    return $query->where('room_order', $itemId);
                })
                ->delete();
            return response()->json(['success' => true, 'message' => 'Item removed from the collection.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Link not found in the collection.'], 404);
        }
    }


    public function getCollections()
    {
        $collections = Collection::where("user_id", Auth::guard("api")->user()->id)->get();

        return response()->json(['collections' => $collections]);
    }

    public function invoiceDetail($order)
    {
        // Retrieve the order
        $order = CartOrder::where("id", $order)->first();

        // Check if the order exists
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Decode the cart JSON
        $cart = json_decode($order->cart);

        // Check if cart is decoded properly
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Invalid cart JSON'], 400);
        }

        $project = null;

        // Check if cart type and item properties exist
        if (isset($cart->type) && isset($cart->item) && isset($cart->item->id)) {
            if ($cart->type == "project") {
                // Retrieve the project with its related data
                $project = Project::where("id", $cart->item->id)
                    ->with("brand", "roomInfo", "housingType", "county", "city","housings","neighbourhood", 'user.projects.housings', 'user.brands', 'user.housings', 'images',"listItemValues")
                    ->first();
            } else {
                // Retrieve the housing with its related user data
                $project = Housing::where("id", $cart->item->id)->with("user","housing_type","listItems",'neighborhood', "county", "city")->first();
            }
        } else {
            return response()->json(['error' => 'Invalid cart structure'], 400);
        }

        // Retrieve the invoice with its related data
        $invoice = Invoice::where("order_id", $order->id)->with("order.user", "order.store", "order.bank")->first();

        // Check if the invoice exists
        if (!$invoice) {
            return response()->json(['error' => 'Invoice not found'], 404);
        }

        $data = [
            'invoice' => $invoice,
            'project' => $project,
        ];

        // Return the data as JSON
        return response()->json($data);
    }


    public function orderDetail($id)
    {
        $order = CartOrder::with("user", "store","refund")->where('id', $id)->first();
        $orderCart = json_decode($order->cart, true);
        $housing = null;
        $project = null;

        if ($order) {
            // Payment result değerine göre ödeme yöntemini belirle
            if ($order->payment_result) {
                $paymentMethod = 'Kredi Kartı';
            } else {
                $paymentMethod = 'EFT / Havale';
            }
        
            // $order değişkenine yeni bir alan ekleyerek ödeme yöntemini atayabiliriz
            $order->payment_method = $paymentMethod;
        }

        if ($order) {
    // Taksitli veya taksitsiz durumu eklemek
    $order->is_installment = $order->is_swap ? 'Taksitli' : 'Taksitsiz';
}
        

        if ($orderCart['type'] == 'housing') {
            $housing = Housing::with("county","city")->where('id', $orderCart['item']['id'])->first();
        } else {
            $project = Project::with("county","city")->where('id', $orderCart['item']['id'])->first();
        }
        return response()->json([
            "order" => $order,
            "housing" => $housing,
            "project" => $project
        ]);
    }

    public function index($slug)
    {
        $pageInfo = Page::where('slug', $slug)->first();
        // Sayfa bulunamazsa 404 hatası döndür
        if (!$pageInfo) {
            return response()->json([
                'error' => 'Sayfa bulunamadı.'
            ], 404);
        }

        return response()->json($pageInfo);
    }

    public function contracts_show()
    {
        $contract_pages = Page::where('is_contract_page', 1)->get();

        return response()->json($contract_pages);
    } //End

    public function getContent($target)
    {
        // Hedef değere göre içeriği al
        $page = Page::where('title', $target)->first();

        if ($page) {
            // Eğer içerik varsa, içeriği JSON formatında döndür
            return response()->json(['content' => $page->content]);
        } else {
            // Eğer içerik bulunamazsa hata mesajı döndür
            return response()->json(['error' => 'İçerik bulunamadı'], 404);
        }
    } //End






    public function clientCollections()
    {
        function calculateEarning($item)
        {
            $earningAmount = 0;
            $deposit_rate = 0.02;

            if ($item['item_type'] == 2) {
                $discountRate = isset($item['housing']['housing_type_data']->discount_rate[0]) ? json_decode($item['housing']['housing_type_data'])->discount_rate[0] : 1;

                $defaultPrice =
                    json_decode($item['housing']['housing_type_data'])->price[0] ??
                    json_decode($item['housing']['housing_type_data'])->daily_rent[0];

                $price = $defaultPrice - $item['discount_amount'];
                $discountedPrice = $price - ($price * $discountRate) / 100;
                $deposit_rate = 0.02;

                $rates = Rate::where('housing_id', $item['housing']['id'])->get();
                $share_percent_earn = null;
                $sales_rate_club = null;

                foreach ($rates as $key => $rate) {
                    if (
                        Auth::user()->corporate_type ==
                        $rate->institution->name
                    ) {
                        $sales_rate_club = $rate->sales_rate_club;
                    }
                    if (
                        $item['housing']['user']['corporate_type'] ==
                        $rate->institution->name
                    ) {
                        $share_percent_earn = $rate->default_deposit_rate;
                        $share_percent_balance = 1.0 - $share_percent_earn;
                    }
                }

                if ($sales_rate_club === null && count($rates) > 0) {
                    $sales_rate_club = $rates->last()->sales_rate_club;
                }

                $total = $discountedPrice * 0.04 * $share_percent_earn;

                $earningAmount = $total * $sales_rate_club;
            } elseif ($item['item_type'] == 1) {
                $discountRate = $item['project_values']['discount_rate[]'] ?? 0;
                $share_sale = $item['project_values']['share_sale[]'] ?? null;
                $number_of_share = $item['project_values']['number_of_shares[]'] ?? null;
                $price = $item['project_values']['price[]'] - $item['discount_amount'];
                $discountedPrice = $price - ($price * $discountRate) / 100;
                $deposit_rate = $item['project']->deposit_rate / 100;

                $sharePercent = 0.5;
                $discountedPrice =
                    isset($discountRate) &&
                    $discountRate != 0 &&
                    isset($discountedPrice)
                    ? $discountedPrice
                    : (isset($item['project_values']['price[]'])
                        ? $item['project_values']['price[]']
                        : $item['project_values']['daily_rent[]']);

                $earningAmount =
                    $discountedPrice * $deposit_rate * $sharePercent;
            }

            return $earningAmount;
        }


        $sharer = User::where('id', auth()->user()->id)->first();
        $items = ShareLink::where('user_id', auth()->user()->id)->get();
        $collections = Collection::with('links.project',"links.housing", "clicks")->where('user_id', auth()->user()->id)->orderBy("id", "desc")->get();
        foreach ($items as $item) {

            $item['project_values'] = $item->projectHousingData($item->item_id)->pluck('value', 'name')->toArray();
            $item['housing'] = $item->housing;
            $item['project'] = $item->project;

            $earningAmount = calculateEarning($item);
            $item['earningAmount'] = $earningAmount;

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
                $item['action'] = $action;

                $sharePrice = 0;
                if ($cartStatus) {
                    $sharePrice = SharerPrice::where("cart_id", $cartStatus->id)->where("user_id", Auth::user()->id)->first();
                }
                $item['sharePrice'] = $sharePrice;

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
                $item['sharePrice'] = $sharePrice;

                $action = $status ? (
                    ($status->status == "0") ? 'payment_await' : (
                        ($status->status == "1") ? 'sold' : (
                            ($status->status == "2") ? 'tryBuy' : ''
                        )
                    )
                ) : 'noCart';
                $item['action'] = $action;
            }
        }


        return response()->json([
            'success' => 'Koleksiyonlar başarıyla listelendi',
            'sharer' => $sharer,
            'items' => $items,
            'collections' => $collections
        ]);
    } //End

    public function editCollection($id, Request $request)
    {
        $collection = Collection::findOrFail($id);
        $collection->update([
            "name" => $request->input("collectionName")
        ]);

        return response()->json([
            'success'    => "Koleksiyon başarıyla güncellendi.",
            'collection' => $collection
        ]);
    } //End

    public function deleteCollection($id)
    {
        $collection = Collection::findOrFail($id);
        $collection->delete();

        return response()->json([
            'success' => "Koleksiyon başarıyla silindi."
        ]);
    }

    public function deleteCollections(Request $request)
    {
        // Gelen istekte ID'leri bir dizi olarak al
        $ids = $request->input('ids');

        // ID'lerin boş olmadığından emin ol
        if (empty($ids)) {
            return response()->json([
                'error' => 'Silmek için hiçbir koleksiyon ID\'si gönderilmedi.'
            ], 400);
        }

        // ID'lere sahip koleksiyonları bulun ve silin
        Collection::whereIn('id', $ids)->delete();

        return response()->json([
            'success' => 'Koleksiyonlar başarıyla silindi.'
        ]);
    }


    public function store(Request $request)
    {
        $cart = $request->input("cart");

        $request->validate([
            'collection_name' => 'required|string',
        ]);

        $collection = new Collection([
            'name' => $request->input('collection_name'),
            'user_id' => Auth::user()->id,
        ]);

        $collection->save();

        $type = $cart['type'];
        $id = $cart['id'];
        $project = $cart['project'];

        if ($type == 'project') {
            $sharerLinksProjects = ShareLink::select('room_order', 'item_id', "collection_id")->where('user_id', auth()->user()->id)->where('item_type', 1)->get()->keyBy('item_id')->toArray();
            $isHas = false;
            $ext = ShareLink::where("item_id", $project)->where("room_order", $id)->where("collection_id", $request->input('selectedCollectionId'))->first();
            if ($ext) {
                $isHas = true;
            }
            if (!$isHas) {
                ShareLink::create([
                    'user_id' => auth()->user()->id,
                    'item_type' => 1,
                    'collection_id' =>  $collection->id,
                    'item_id' => $project,
                    'room_order' => $id
                ]);
            } else {
                return response(['failed' => 'success']);
            }
        } else {
            $sharerLinks = array_values(array_keys(ShareLink::where('user_id', auth()->user()->id)->where('item_type', 2)->where('collection_id', $collection->id)->get()->keyBy('item_id')->toArray()));
            if (!in_array($id, $sharerLinks)) {
                ShareLink::create([
                    'user_id' => auth()->user()->id,
                    'item_type' => 2,
                    'item_id' => $id,
                    'collection_id' =>  $collection->id,

                ]);
            } else {
                return response(['failed' => 'success']);
            }
        }

        return response()->json(['collection' => $collection]);
    }

    public function addLink(Request $request)
    {
        $type = $request->input('type');
        $id = $request->input('id');
        $project = $request->input('project');

        if ($type == 'project') {
            $sharerLinksProjects = ShareLink::select('room_order', 'item_id', 'collection_id')->where('user_id', auth()->user()->id)->where('item_type', 1)->get()->keyBy('item_id')->toArray();
            $isHas = false;
            $ext = ShareLink::where('item_id', $project)->where('room_order', $id)->where('collection_id', $request->input('selectedCollectionId'))->first();
            if ($ext) {
                $isHas = true;
            }
            if (!$isHas) {
                ShareLink::create([
                    'user_id' => auth()->user()->id,
                    'item_type' => 1,
                    'collection_id' => $request->input('selectedCollectionId'),
                    'item_id' => $project,
                    'room_order' => $id,
                ]);
            } else {
                return response(['failed' => 'share link was added before for the project']);
            }
        } else {
            $sharerLinks = array_values(array_keys(ShareLink::where('user_id', auth()->user()->id)->where('item_type', 2)->where('collection_id', $request->input('selectedCollectionId'))->get()->keyBy('item_id')->toArray()));
            if (!in_array($id, $sharerLinks)) {
                ShareLink::create([
                    'user_id' => auth()->user()->id,
                    'item_type' => 2,
                    'item_id' => $id,
                    'collection_id' => $request->input('selectedCollectionId'),

                ]);
            } else {
                return response(['failed' => 'share link was added before for the housing']);
            }
        }

        return response(['message' => 'success']);
    }


    public function removeItemOnCollection(Request $request)
    {
        if ($request->input('item_type') == 1) {
            ShareLink::where('user_id', auth()->guard("api")->user()->id)->where('item_type', $request->input('item_type'))->where('room_order', $request->input('room_order'))->where('item_id', $request->input('item_id'))->where('collection_id', $request->input('collection_id'))->delete();
        } else {
            ShareLink::where('user_id', auth()->guard("api")->user()->id)->where('item_type', $request->input('item_type'))->where('item_id', $request->input('item_id'))->where('collection_id', $request->input('collection_id'))->delete();
        }

        return json_encode([
            "status" => true
        ]);
    }


    public function allMenuProjects(Request $request, $slug = null, $type = null, $optional = null, $title = null, $check = null, $city = null, $county = null, $hood = null)
    {
        $term = $request->input('term');
        $deneme = null;

        function slugify($text)
        {
            // Replace non-letter or digits by -
            $text = preg_replace('~[^\pL\d]+~u', '-', $text);

            // Transliterate
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

            // Remove unwanted characters
            $text = preg_replace('~[^-\w]+~', '', $text);

            // Trim
            $text = trim($text, '-');

            // Remove duplicate -
            $text = preg_replace('~-+~', '-', $text);

            // Lowercase
            $text = strtolower($text);

            return $text;
        }

        if ($slug == "al-sat-acil") {
            $deneme = "al-sat-acil";
        } else   if ($slug == "paylasimli-ilanlar") {
            $deneme = "paylasimli-ilanlar";
        }



        $nslug = HousingType::where('slug', ['konut' => 'daire'][$slug] ?? $slug)->first()->id ?? 0;
        $parameters = [$slug, $type, $optional, $title, $check, $city, $county, $hood];
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

        $opt = null;
        $checkTitle = null;
        $is_project = null;

        $optName = [];
        $items = [];

        $cityTitle = null;
        $citySlug = null;
        $cityID = null;

        $countyTitle = null;
        $countySlug = null;
        $countyID = null;

        $neighborhoodTitle = null;
        $neighborhoodSlug = null;
        $neighborhoodID = null;


        if ($deneme && $deneme == "al-sat-acil") {
            $slug = "al-sat-acil";
            $slugItem = "al-sat-acil";

            $slugName = "Al Sat Acil";
            $items = HousingTypeParent::with("parents.connections.housingType")->where("parent_id", null)->get();
        }

        if ($deneme && $deneme == "paylasimli-ilanlar") {
            $slug = "paylasimli-ilanlar";
            $slugItem = "paylasimli-ilanlar";

            $slugName = "Paylaşımlı İlanlar";
        }


        foreach ($parameters as $index => $paramValue) {
            if ($paramValue) {
                if (in_array($paramValue, ["satilik", "devren-satilik", "devren-kiralik", "kiralik", "gunluk-kiralik"])) {
                    $opt = $paramValue;
                    switch ($paramValue) {
                        case "kiralik":
                            $optName = "Kiralık";
                            break;
                        case "satilik":
                            $optName = "Satılık";
                            break;
                        case "gunluk-kiralik":
                            $optName = "Günlük Kiralık";
                            break;
                        case "devren-satilik":
                            $optName = "Devren Satılık";
                            break;
                        case "devren-kiralik":
                            $optName = "Devren Kiralık";
                            break;
                    }
                } else {
                    // City check
                    if (!$cityID) {
                        $cityValue = City::whereRaw('LOWER(REPLACE(title, " ", "-")) = ?', [$paramValue])->first();
                        if ($cityValue) {
                            $cityTitle = $cityValue->title;
                            $cityID = $cityValue->id;
                            $citySlug = slugify($cityValue->title);
                        }
                    }

                    // County check
                    if ($cityID && !$countyID) {
                        $countyValue = District::whereRaw('LOWER(REPLACE(ilce_title, " ", "-")) = ?', [$paramValue])->where('ilce_sehirkey', $cityID)->first();
                        if ($countyValue) {
                            $countyTitle = $countyValue->ilce_title;
                            $countyID = $countyValue->ilce_key;
                            $countySlug = slugify($countyValue->ilce_title);
                        }
                    }

                    // Neighborhood check
                    if ($countyID && !$neighborhoodID) {
                        $neighborhoodValue = Neighborhood::whereRaw('LOWER(REPLACE(mahalle_title, " ", "-")) = ?', [$paramValue])->where('mahalle_ilcekey', $countyID)->first();
                        if ($neighborhoodValue) {
                            $neighborhoodTitle = $neighborhoodValue->mahalle_title;
                            $neighborhoodID = $neighborhoodValue->mahalle_id;
                            $neighborhoodSlug = slugify($neighborhoodValue->mahalle_title);
                        }
                    }

                    // Housing status, type and parent type checks

                    if ($request->input('selectedProjectStatus')) {
                        $item1 = HousingStatus::where('id', $request->input('selectedProjectStatus'))->first();
                    } else {
                        $item1 = HousingStatus::where('slug', $paramValue)->first();
                    }

                    $housingTypeParent = HousingTypeParent::where('slug', $paramValue)->first();

                    if (!empty($housingTypeSlugName)) {
                        $housingType = HousingType::where('slug', $paramValue)->first();
                    }

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
            }
        }


        if ($housingTypeParentSlug && $housingTypeParentSlug == "arsa") {

            $checkTitle = isset($parameters[count($parameters) - 2]) ? $parameters[count($parameters) - 2] : null;
        }


            if ($is_project) {
                $query = Project::with("city", "county", "roomInfo", 'user', "neighbourhood", 'brand', 'roomInfo', 'listItemValues', 'housingType')
                    ->where("projects.status", 1);

                if ($housingTypeParentSlug) {
                    $query->where("step1_slug", $housingTypeParentSlug);
                }

                if ($opt) {
                    $query->where("step2_slug", $opt);
                }

                if ($housingType) {
                    $query->where('housing_type_id', $housingType);
                }

                if ($slug && $slug != "1") {
                    $query->whereHas('housingTypes', function ($query) use ($slug) {
                        $query->where('housing_type_id', $slug);
                    });
                }

                if ($cityID || $request->input("selectedCity")) {
                    $query->where('city_id', $cityID ?? $request->input("selectedCity"));
                }
                if ($countyID || $request->input("selectedCounty")) {
                    $query->where('county_id', $countyID ?? $request->input("selectedCounty"));
                }

                if ($neighborhoodID || $request->input("selectedNeighborhood")) {
                    $query->where('neighborhood_id', $neighborhoodID ?? $request->input("selectedNeighborhood"));
                }


                if ($request->has('sortValue')) {
                    switch ($request->input('sortValue')) {
                        case 'date-asc':
                            $query->orderBy('created_at', 'asc');
                            break;
                        case 'date-desc':
                            $query->orderBy('created_at', 'desc');
                            break;
                    }
                } else {
                    $query->orderBy('created_at', 'desc');
                }

                if ($request->has('selectedRadio') && isset($request->input('selectedRadio')['corporate_type']) && $request->input('selectedRadio')['corporate_type'] !== null) {
                    $key = $request->input('selectedRadio')['corporate_type'];
                    if ($request->input('selectedRadio')['corporate_type'] == "tourism_purpose_rental") {
                        $key = "Turizm Amaçlı Kiralama";
                    } else if ($request->input('selectedRadio')['corporate_type'] == "construction_office") {
                        $key = "İnşaat Ofisi";
                    }

                    $query->join('users', 'users.id', '=', 'projects.user_id')
                        ->where('users.corporate_type', $key)
                        ->select('projects.*', 'users.corporate_type');
                }

                if ($request->has('selectedRadio.listing_date') && $request->input('selectedRadio.listing_date') && $request->input('selectedRadio.listing_date') != null) {
                    if ($request->input('selectedRadio.listing_date') == '24') {
                        $query->where('created_at', '>=', now()->subDay());
                    } else {
                        $query->where('created_at', '>=', now()->subDays($request->input('selectedListingDate')));
                    }
                }
                if ($request->has('selectedCheckboxes')) {
                    $selectedCheckboxes = $request->input('selectedCheckboxes');
                    $groupedConditions = [];
                    $bindings = [];
                
                    // Loop through each group of checkboxes
                    foreach ($selectedCheckboxes as $key => $values) {
                        $conditions = [];
                
                        // Loop through each checkbox within the group
                        foreach ($values as $subkey => $value) {
                            $cleanedSubkey = urldecode($subkey); // Decode the URL encoding
                            $cleanedValue = urldecode($value); // Decode the URL encoding
                
                            // Prepare the condition
                            $conditions[] = "(name = ? AND value = ?)";
                            $bindings[] = $key . '[]';
                            $bindings[] = $cleanedSubkey;
                        }
                
                        // Add conditions for this group to groupedConditions
                        if (!empty($conditions)) {
                            $groupedConditions[] = '(' . implode(' OR ', $conditions) . ')';
                        }
                    }
                
                    // Apply the grouped conditions with an AND relation
                    if (!empty($groupedConditions)) {
                        $query->whereHas('roomInfo', function ($query) use ($groupedConditions, $bindings) {
                            $query->whereRaw(implode(' AND ', $groupedConditions), $bindings);
                        });
                    }
                }
                
                if ($request->has('textInputs')) {
                    $textInputs = $request->input('textInputs');
                
                    $query->where(function ($query) use ($textInputs) {
                        foreach ($textInputs as $key => $values) {
                            // Tekil bir whereHas fonksiyonu oluştur
                            $query->where(function ($query) use ($key, $values) {
                                foreach ($values as $type => $amount) {
                                    $amount = str_replace('.', '', $amount); // Noktaları kaldır
                                    $amount = (int)$amount; // Convert to integer for comparison
                
                                    // Min değeri için işlem
                                    if ($type === 'min') {
                                        $query->whereHas('roomInfo', function ($query) use ($key, $amount) {
                                            $query->where('name', $key . '[]')
                                                ->whereRaw('CAST(value AS UNSIGNED) >= ?', [$amount]);
                                        });
                                    }
                
                                    // Max değeri için işlem
                                    elseif ($type === 'max') {
                                        $query->whereHas('roomInfo', function ($query) use ($key, $amount) {
                                            $query->where('name', $key . '[]')
                                                ->whereRaw('CAST(value AS UNSIGNED) <= ?', [$amount]);
                                        });
                                    }
                                }
                            });
                        }
                    });
                }
                

                $projects = $query->get();
            } else {
                $query = Housing::with('images')
                    ->select(
                        'housings.id',
                        'housings.slug',
                        'housings.title AS housing_title',
                        'housings.created_at',
                        'housings.step1_slug',
                        'housings.owner_id',
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
                        DB::raw('(SELECT status FROM cart_orders WHERE JSON_EXTRACT(cart, "$.type") = "housing" AND JSON_EXTRACT(cart, "$.item.id") = housings.id ORDER BY created_at DESC LIMIT 1) AS sold'),
                        'cities.title AS city_title',
                        'districts.ilce_title AS county_title',
                        'neighborhoods.mahalle_title AS neighborhood_title',
                        DB::raw('(SELECT discount_amount FROM offers WHERE housing_id = housings.id AND type = "housing" AND start_date <= "' . date('Y-m-d H:i:s') . '" AND end_date >= "' . date('Y-m-d H:i:s') . '" ORDER BY start_date DESC LIMIT 1) as discount_amount'),
                    )
                    ->leftJoin('housing_types', 'housing_types.id', '=', 'housings.housing_type_id')
                    ->leftJoin('project_list_items', 'project_list_items.housing_type_id', '=', 'housings.housing_type_id')
                    ->leftJoin('housing_status', 'housings.status_id', '=', 'housing_status.id')
                    ->leftJoin('cities', 'cities.id', '=', 'housings.city_id')
                    ->leftJoin('districts', 'districts.ilce_key', '=', 'housings.county_id')
                    ->leftJoin('neighborhoods', 'neighborhoods.mahalle_id', '=', 'housings.neighborhood_id')
                    ->where('housings.status', 1)
                    ->where('project_list_items.item_type', 2);

                if ($housingTypeParentSlug) {
                    $query->where("step1_slug", $housingTypeParentSlug);
                }

                if ($housingType) {
                    $query->where('housings.housing_type_id', $housingType);
                }



                if ($cityID || $request->input("selectedCity")) {
                    $query->where('city_id', $cityID ?? $request->input("selectedCity"));
                }

                if ($request->has('selectedCheckboxes')) {
                    $selectedCheckboxes = $request->input('selectedCheckboxes');
                    $groupedConditions = [];

                    foreach ($selectedCheckboxes as $key => $values) {
                        $conditions = [];
                        foreach ($values as $subkey => $value) {
                            $cleanedSubkey = urldecode($subkey); // URL kodlamasını çöz
                            $cleanedValue = urldecode($value); // URL kodlamasını çöz

                            if ($cleanedValue != false) {
                                // Karşılanan verideki Unicode karakterlerini çöz
                                $cleanedSubkey = json_encode(json_decode('"' . $cleanedSubkey . '"'));

                                // "Hayır" -> "Hay\\u0131r" eşitliği sağlamak için
                                $conditions[] = "JSON_CONTAINS(housings.housing_type_data, '$cleanedSubkey', '$.$key')";
                            }
                        }
                        if (!empty($conditions)) {
                            $groupedConditions[] = '(' . implode(' OR ', $conditions) . ')';
                        }
                    }

                    if (!empty($groupedConditions)) {
                        $query->whereRaw('(' . implode(' AND ', $groupedConditions) . ')');
                    }
                }



                if ($request->has('textInputs')) {
                    $textInputs = $request->input('textInputs');

                    foreach ($textInputs as $key => $values) {
                        if (isset($values['min'])) {
                            $minValue = str_replace('.', '', $values['min']); // Noktaları kaldır
                            $query->whereRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(housing_type_data, "$.' . $key . '[0]")) AS FLOAT) >= ?', [$minValue]);
                        }

                        if (isset($values['max'])) {
                            $maxValue = str_replace('.', '', $values['max']);
                            $query->whereRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(housing_type_data, "$.' . $key . '[0]")) AS FLOAT) <= ?', [$maxValue]);
                        }
                    }
                }

                if ($countyID || $request->input("selectedCounty")) {
                    $query->where('county_id', $countyID ?? $request->input("selectedCounty"));
                }

                if ($neighborhoodID || $request->input("selectedNeighborhood")) {
                    $query->where('neighborhood_id', $neighborhoodID ?? $request->input("selectedNeighborhood"));
                }


                if ($opt) {
                    $query->where('step2_slug', $opt);
                }

                if ($slug == "emlak-ilanlari") {
                    $query->whereHas('housingStatus', function ($query) use ($slug) {
                        $query->where('housing_status_id', $slug);
                    });
    
                }
           

                if ($request->has('selectedRadio.listing_date') && $request->input('selectedRadio.listing_date') !== null) {
                    if ($request->input('selectedRadio.listing_date') == '24') {
                        $query->where('housings.created_at', '>=', now()->subDay());
                    } else {
                        $query->where('housings.created_at', '>=', now()->subDays($request->input('selectedRadio.listing_date')));
                    }
                }


                if ($request->has('sortValue')) {
                    switch ($request->input('sortValue')) {
                        case 'date-asc':
                            $query->orderBy('housings.created_at', 'asc');
                            break;
                        case 'date-desc':
                            $query->orderBy('housings.created_at', 'desc');
                            break;
                        case 'price-asc':
                            $query->orderByRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(housings.housing_type_data, "$.price[0]")) AS FLOAT) ASC');
                            break;
                        case 'price-desc':
                            $query->orderByRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(housings.housing_type_data, "$.price[0]")) AS FLOAT) DESC');
                            break;
                    }
                } else {
                    $query->orderBy('housings.created_at', 'desc');
                }

                if ($slug == "al-sat-acil") {
                    $query->whereHas('housingStatus', function ($query) {
                        $query->where('housing_status_id', 4);
                    });
                    $query->whereRaw('JSON_CONTAINS(housings.housing_type_data, \'["Evet"]\', "$.buysellurgent1")');
                }

                if ($slug == "paylasimli-ilanlar") {
                    $query->whereHas('housingStatus', function ($query) {
                        $query->where('housing_status_id', 4);
                    });
                    $query->whereNotNull('housings.owner_id');
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
        $newHousingType = HousingType::where('id', $housingType)->first();
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
                            // ->where('order_by' ,'asc')
                            ->whereIn('filter_name', $uniqueHousingTypeNames)
                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    } else {
                        $filtersDb = Filter::where('item_type', 1)
                            ->whereIn('housing_type_id', $uniqueHousingTypeIds)
                            ->get()
                            ->where("is_daily_rent", 1)
                            // ->where('order_by' ,'asc')

                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    }
                } else {

                    if ($slug == "al-sat-acil" && !$housingTypeSlugName) {
                        $filtersDb = Filter::where('item_type', 1)
                            ->get()
                            ->where("is_sale", 1)
                            // ->where('order_by' ,'asc')
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
                            // ->where('order_by' ,'asc')
                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    }
                }



                if (!empty($optName) && empty($newHousingType)) {

                    if ($optName == "Satılık") {
                        $filtersDb = Filter::where('item_type', 1)
                            ->whereIn('housing_type_id', $uniqueHousingTypeIds)
                            ->get()
                            ->where("is_sale", 1)
                            // ->where('order_by' ,'asc')
                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    } else if ($optName == "Kiralık") {
                        $filtersDb = Filter::where('item_type', 1)
                            ->whereIn('housing_type_id', $uniqueHousingTypeIds)
                            ->get()
                            ->where("is_rent", 1)
                            // ->where('order_by' ,'asc')
                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    } else if ($optName == "Günlük Kiralık") {
                        $filtersDb = Filter::where('item_type', 1)
                            ->whereIn('housing_type_id', $uniqueHousingTypeIds)
                            ->get()
                            ->where("is_daily_rent", 1)
                            // ->where('order_by' ,'asc')
                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    } else if ($optName == "Devren Satılık") {
                        $filtersDb = Filter::where('item_type', 1)
                            ->whereIn('housing_type_id', $uniqueHousingTypeIds)
                            ->get()
                            ->where("transfer_for_sale_status", 1)
                            // ->where('order_by' ,'asc')
                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    } else if ($optName == "Devren Kiralık") {
                        $filtersDb = Filter::where('item_type', 1)
                            ->whereIn('housing_type_id', $uniqueHousingTypeIds)
                            ->get()
                            ->where("transfer_for_rent_status", 1)
                            // ->where('order_by' ,'asc')
                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    }
                } else if (!empty($optName) && !empty($newHousingType)) {

                    if ($optName == "Satılık") {
                        $filtersDb = Filter::where('item_type', 2)
                            ->where('housing_type_id', $newHousingType->id)
                            ->get()
                            ->where("is_sale", 1)
                            // ->where('order_by' ,'asc')
                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    } else if ($optName == "Kiralık") {
                        $filtersDb = Filter::where('item_type', 2)
                            ->where('housing_type_id', $newHousingType->id)
                            ->get()
                            ->where("is_rent", 1)
                            // ->where('order_by' ,'asc')
                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    } else if ($optName == "Günlük Kiralık") {
                        $filtersDb = Filter::where('item_type', 2)
                            ->where('housing_type_id', $newHousingType->id)
                            ->get()
                            ->where("is_daily_rent", 1)
                            // ->where('order_by' ,'asc')
                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    } else if ($optName == "Devren Satılık") {
                        $filtersDb = Filter::where('item_type', 2)
                            ->whereIn('housing_type_id', $uniqueHousingTypeIds)
                            ->get()
                            ->where("transfer_for_sale_status", 1)
                            // ->where('order_by' ,'asc')
                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    } else if ($optName == "Devren Kiralık") {
                        $filtersDb = Filter::where('item_type', 2)
                            ->whereIn('housing_type_id', $uniqueHousingTypeIds)
                            ->get()
                            // ->where('order_by' ,'asc')
                            ->where("transfer_for_rent_status", 1)
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

            if (empty($housingTypeSlug) && !empty($housingTypeSlugName) || $newHousingType ||  $slug == "al-sat-acil" ||  $slug == "paylasimli-ilanlar") {

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
                            // ->where('order_by' ,'asc')
                            ->whereIn('filter_name', $uniqueHousingTypeNames)
                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    } else {
                        $filtersDb = Filter::where('item_type', 2)
                            ->whereIn('housing_type_id', $uniqueHousingTypeIds)
                            ->get()
                            ->where("is_daily_rent", 1)
                            // ->where('order_by' ,'asc')

                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    }
                } else {

                    if ($slug == "al-sat-acil" && !$housingTypeSlugName) {
                        $filtersDb = Filter::where('item_type', 2)
                            ->get()
                            ->where("is_sale", 1)
                            // ->where('order_by' ,'asc')
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
                            // ->where('order_by' ,'asc')
                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    }
                }


                if (!empty($optName) && !$newHousingType) {
                    if ($optName == "Satılık") {
                        $filtersDb = Filter::where('item_type', 2)
                            ->whereIn('housing_type_id', $uniqueHousingTypeIds)
                            ->get()
                            ->where("is_sale", 1)
                            // ->where('order_by' ,'asc')
                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    } else if ($optName == "Kiralık") {
                        $filtersDb = Filter::where('item_type', 2)
                            ->whereIn('housing_type_id', $uniqueHousingTypeIds)
                            ->get()
                            ->where("is_rent", 1)
                            // ->where('order_by' ,'asc')
                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    } else if ($optName == "Günlük Kiralık") {
                        $filtersDb = Filter::where('item_type', 2)
                            ->whereIn('housing_type_id', $uniqueHousingTypeIds)
                            ->get()
                            ->where("is_daily_rent", 1)
                            // ->where('order_by' ,'asc')
                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    } else if ($optName == "Devren Satılık") {
                        $filtersDb = Filter::where('item_type', 2)
                            ->whereIn('housing_type_id', $uniqueHousingTypeIds)
                            ->get()
                            ->where("transfer_for_sale_status", 1)
                            // ->where('order_by' ,'asc')
                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    } else if ($optName == "Devren Kiralık") {
                        $filtersDb = Filter::where('item_type', 2)
                            ->whereIn('housing_type_id', $uniqueHousingTypeIds)
                            ->get()
                            ->where("transfer_for_rent_status", 1)
                            // ->where('order_by' ,'asc')
                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    }
                } else if (!empty($optName) && $newHousingType) {

                    if ($optName == "Satılık") {
                        $filtersDb = Filter::where('item_type', 2)
                            ->where('housing_type_id', $newHousingType->id)
                            ->get()
                            ->where("is_sale", 1)
                            // ->where('order_by' ,'asc')
                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    } else if ($optName == "Kiralık") {
                        $filtersDb = Filter::where('item_type', 2)
                            ->where('housing_type_id', $newHousingType->id)
                            ->get()
                            ->where("is_rent", 1)
                            // ->where('order_by' ,'asc')
                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    } else if ($optName == "Günlük Kiralık") {
                        $filtersDb = Filter::where('item_type', 2)
                            ->where('housing_type_id', $newHousingType->id)
                            ->get()
                            ->where("is_daily_rent", 1)
                            // ->where('order_by' ,'asc')
                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    } else if ($optName == "Devren Satılık") {
                        $filtersDb = Filter::where('item_type', 2)
                            ->whereIn('housing_type_id', $uniqueHousingTypeIds)
                            ->get()
                            ->where("transfer_for_sale_status", 1)
                            // ->where('order_by' ,'asc')
                            ->unique('filter_name') // filter_name değerine göre tekil olanları al
                            ->values() // Anahtarları sıfırlamak için values() fonksiyonunu kullan
                            ->toArray();
                    } else if ($optName == "Devren Kiralık") {
                        $filtersDb = Filter::where('item_type', 2)
                            ->whereIn('housing_type_id', $uniqueHousingTypeIds)
                            ->get()
                            ->where("transfer_for_rent_status", 1)
                            // ->where('order_by' ,'asc')
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
            "meta_keywords" => "Emlak Sepette",
            "meta_description" => "Emlak Sepette projeleri sizler için muhteşem, benzersiz mimari tasarımı ve modern yaşam konseptiyle dikkat çekiyor. Doğa ile iç içe, lüks ve konfor dolu bir yaşamın kapılarını aralayın.Tasarımlarımıza göz gezdirin ve alışverişe başlayın!",
            "meta_author" => "Emlak Sepette",
        ];

        $pageInfo = json_encode($pageInfo);
        $pageInfo = json_decode($pageInfo);

        return response()->json([
            'neighborhoodTitle' => $neighborhoodTitle,
            'neighborhoodSlug' => $neighborhoodSlug,
            'countySlug' => $countySlug,
            'countyTitle' => $countyTitle,
            'citySlug' => $citySlug,
            'cityTitle' => $cityTitle,
            'cityID' => $cityID,
            'neighborhoodID' => $neighborhoodID,
            'countyID' => $countyID,
            'filters' => $filters,
            'slugItem' => $slugItem,
            'nslug' => $nslug,
            'checkTitle' => $checkTitle,
            'menu' => $menu,
            'opt' => $opt,
            'housingTypeSlug' => $housingTypeSlug,
            'housingTypeParentSlug' => $housingTypeParentSlug,
            'optional' => $optional,
            'optName' => $optName,
            'housingTypeName' => $housingTypeName,
            'housingTypeSlug' => $housingTypeSlug,
            'housingTypeSlugName' => $housingTypeSlugName,
            'slugName' => $slugName,
            'housingTypeParent' => $housingTypeParent,
            'housingType' => $housingType,
            'projects' => $projects,
            'slug' => $slug,
            'secondhandHousings' => $secondhandHousings,
            'housingStatuses' => $housingStatuses,
            'cities' => $cities,
            'title' => $title,
            'type' => $type,
            'term' => $term,
        ]);
    }

    public function profileInfo(){
        $user = auth()->user();

       if($user){
            $activeAdvertProjects = Project::where('status','1')->where('user_id', $user->id)->count();
            $activeAdvertHousings = Housing::where('status','1')->where('user_id', $user->id)->count();
            $pendingAdvertProjects = Project::where('status','2')->where('user_id', $user->id)->count();
            $pendingAdvertHousings = Housing::where('status','2')->where('user_id', $user->id)->count();
            $passiveAdvertHousings = Housing::where('status','0')->where('user_id', $user->id)->count();
            $passiveAdvertProjects = Project::where('status','0')->where('user_id', $user->id)->count();
            $rejectAdvertProjects = Project::where('status','3')->where('user_id', $user->id)->count();
            $rejectAdvertHousings = Housing::where('status','3')->where('user_id', $user->id)->count();

            // $userDetails = User::select('profile_image', 'name', 'email', 'corporate_type')->find($user->id);
            $viewCountProjects = Project::where('user_id', $user->id)->pluck('view_count')->sum();
            $viewCountHousings = Housing::where('user_id', $user->id)->pluck('view_count')->sum();
            $mostViewedHousings = Housing::where('user_id', $user->id)->orderBy('view_count', 'desc')->limit(5)->get(); 
            $mostViewedProjects = Project::where('user_id', $user->id)->orderBy('view_count', 'desc')->limit(5)->get(); 
            
            $totalSales = CartOrder::where('status','1')->where('store_id',$user->id)->sum('amount');
            $bidsCount = Bid::where('user_id',$user->id)->count();

       }
       return response()->json([
        'user' => $user,
        'activeAdvertProjects' => $activeAdvertProjects,
        'activeAdvertHousings' => $activeAdvertHousings,
        'pendingAdvertProjects' => $pendingAdvertProjects,
        'pendingAdvertHousings' => $pendingAdvertHousings,
        'passiveAdvertHousings' => $passiveAdvertHousings,
        'passiveAdvertProjects' => $passiveAdvertProjects,
        'rejectAdvertProjects' => $rejectAdvertProjects,
        'rejectAdvertHousings' => $rejectAdvertHousings,
        'viewCountProjects' => $viewCountProjects,
        'viewCountHousings' => $viewCountHousings,
        'mostViewedHousings' => $mostViewedHousings,
        'mostViewedProjects' => $mostViewedProjects,
        'totalSales' => $totalSales,
        'bidsCount' => $bidsCount
    ]);
       
    }//End
}