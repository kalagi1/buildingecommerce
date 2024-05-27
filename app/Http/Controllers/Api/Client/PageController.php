<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\CartOrder;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\Housing;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\ShareLink;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class PageController extends Controller
{
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
        $invoice = Invoice::where("order_id", $order->id)->with("order.user","order.store", "order.bank")->first();
    
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
                $rates = $item['housing']['rates'];
                $sales_rate_club = null;
                $share_percent_earn = null;
        
                foreach ($rates as $rate) {
                    if (auth()->user()->corporate_type == $rate->institution->name) {
                        $sales_rate_club = $rate->sales_rate_club;
                    }
                    if ($item['housing']['user']['corporate_type'] == $rate->institution->name) {
                        $share_percent_earn = $rate->default_deposit_rate;
                    }
                }
        
                if ($sales_rate_club === null && count($rates) > 0) {
                    $sales_rate_club = $rates[count($rates) - 1]->sales_rate_club;
                }
        
                $total = $item['discountedPrice'] * 0.04 * $share_percent_earn;
                $earningAmount = $total * $sales_rate_club;
            } elseif ($item['item_type'] == 1) {
                $deposit_rate = $item['project']->deposit_rate / 100;
                $sharePercent = 0.5;
                $discountedPrice = $item['discountedPrice'] ?? $item['project_values']['daily_rent[]'];
                $earningAmount = $discountedPrice * $deposit_rate * $sharePercent;
            }
        
            return $earningAmount;
        }
        $sharer = User::where('id', auth()->user()->id)->first();
        $items = ShareLink::where('user_id', auth()->user()->id)->get();
        $collections = Collection::with('links', "clicks")->where('user_id', auth()->user()->id)->orderBy("id", "desc")->get();
        $itemsArray = [];
        foreach ($items as $item) {
            
            $itemData = [
                'project_values' => $item->projectHousingData($item->item_id)->pluck('value', 'name')->toArray(),
                'housing' => $item->housing,
                'project' => $item->project,
            ];
    
            // Kazanç miktarını hesapla
            $earningAmount = calculateEarning($itemData);
            $itemData['earningAmount'] = $earningAmount;
    
            array_push($itemsArray, $itemData);
        }
        
        return response()->json([
            'success' => 'Koleksiyonlar başarıyla listelendi',
            'sharer' => $sharer,
            'items' => $items,
            'itemsArray' => $itemsArray,
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
    } //End

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
