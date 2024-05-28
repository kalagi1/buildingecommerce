<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\CartOrder;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\Housing;
use App\Models\Invoice;
use App\Models\Offer;
use App\Models\Project;
use App\Models\Rate;
use App\Models\ShareLink;
use App\Models\SharerPrice;
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

        // Handle removal for project type
        if ($itemType == 'project') {
            $link = ShareLink::where('item_id', $projectId)
                             ->where('item_type', 1)
                             ->where('room_order', $itemId)
                             ->first();
        }
        // Handle removal for housing type
        elseif ($itemType == 'housing') {
            $link = ShareLink::where('item_id', $itemId)
                             ->where('item_type', 2)
                             ->first();
        }

        // If the link is found, delete it
        if ($link) {
            $link->delete();
            return response()->json(['success' => true, 'message' => 'Item removed from the collection.']);
        }
        // If the link is not found
        else {
            return response()->json(['success' => false, 'message' => 'Link not found in the collection.'], 404);
        }
    }


    public function getCollections()
    {
        $collections = Collection::where("user_id", Auth::user()->id)->get();

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
                    ->with("brand", "roomInfo", "housingType", "county", "city", 'user.projects.housings', 'user.brands', 'user.housings', 'images')
                    ->first();
            } else {
                // Retrieve the housing with its related user data
                $project = Housing::where("id", $cart->item->id)->with("user")->first();
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
        $order = CartOrder::with("user", "store")->where('id', $id)->first();
        $orderCart = json_decode($order->cart, true);
        $housing = null;
        $project = null;

        if ($orderCart['type'] == 'housing') {
            $housing = Housing::where('id', $orderCart['item']['id'])->first();
        } else {
            $project = Project::where('id', $orderCart['item']['id'])->first();
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
                $discountRate = json_decode($item['housing']['housing_type_data'])
                    ->discount_rate[0];

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
        $collections = Collection::with('links', "clicks")->where('user_id', auth()->user()->id)->orderBy("id", "desc")->get();
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
}
