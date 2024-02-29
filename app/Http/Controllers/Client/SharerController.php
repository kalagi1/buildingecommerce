<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\CartOrder;
use App\Models\Click;
use App\Models\Collection;
use App\Models\ShareLink;
use App\Models\SharerPrice;
use App\Models\User;
use App\Models\Housing;
use App\Models\Offer;
use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as FacadesRequest;

class SharerController extends Controller {

    public function view() {
        $pageInfo = [
            "meta_title" => "Emlak Kulüp",
            "meta_keywords" => "Emlak Sepette,Emlak Kulüp",
            "meta_description" => "Emlak Kulüp",
            "meta_author" => "Emlak Sepette",
        ];

        $pageInfo = json_encode($pageInfo);
        $pageInfo = json_decode($pageInfo);

        return view("client.sharer-panel.view",compact('pageInfo'));
    }
    public function index() {
        $sharer = User::where( 'id', auth()->user()->id )->first();
        $items = ShareLink::where( 'user_id', auth()->user()->id )->get();
        $collections = Collection::with( 'links' ,"clicks")->where( 'user_id', auth()->user()->id )->get();
        $itemsArray = [];
        foreach ( $items as $item ) {
            $item[ 'project_values' ] = $item->projectHousingData( $item->item_id )->pluck( 'value', 'name' )->toArray();
            $item[ 'housing' ] = $item->housing;

        }

        return view( 'institutional.sharer-panel.index', compact( 'items', 'sharer', 'collections' ) );
    }
    public function earnings() {
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

            $collections = Collection::with("links")->where("user_id",Auth::user()->id)->get();
            $totalStatus1Count = $balanceStatus1Lists->count();
            $successPercentage = $totalStatus1Count > 0 ? ($totalStatus1Count / ($totalStatus1Count + $balanceStatus0Lists->count() + $balanceStatus2Lists->count())) * 100 : 0;
    
        return view("institutional.earnings.index", compact("balanceStatus0","successPercentage", "collections","balanceStatus1", "balanceStatus2", "balanceStatus0Lists","balanceStatus1Lists","balanceStatus2Lists"));
    }
    
    public function showClientLinks($slug,$userid, $id, Request $request)
    {
        $users = User::all();
        $collection = Collection::where("id",$id)->first();
        
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
                    // $sharer = User::findOrFail(auth()->user()->id);
                
                    $items = ShareLink::where('user_id', $userid)->where('collection_id', $collection->id)->get();
                    $itemsArray = $items->map(function ($item) use ($store) {
                        $action = null;
                        $offSale = null;
                
                        if ($item->item_type == 2) {
                            $cartStatus = CartOrder::whereRaw("JSON_UNQUOTE(json_extract(cart, '$.type')) = 'housing'")
                                ->whereRaw("JSON_UNQUOTE(json_extract(cart, '$.item.id')) = ?", [$item->item_id])
                                ->first();
                
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
                
                        if ($item->item_type == 1) {
    
                            $userProjectIds = $store->projects->pluck('id');
                            $discount_amount = Offer::where( 'type', 'project' )
                            ->where( 'project_id', $item->project->id )
                            ->where('project_housings', 'LIKE', '%' . $item->room_order . '%')
                            ->where( 'start_date', '<=', date( 'Y-m-d H:i:s' ) )->where( 'end_date', '>=', date( 'Y-m-d H:i:s' ) )->first()->discount_amount ?? 0;
    
                            $status = CartOrder::where(DB::raw('JSON_EXTRACT(cart, "$.item.housing")'), $item->room_order)
                                ->where(DB::raw('JSON_EXTRACT(cart, "$.item.id")'), $item->item_id)
                                ->first();
    
                                
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
                            'discount_amount' => $discount_amount
                        ];
                    });
            
                    $mergedItems = array_map(function($item, $itemArray) {
                        return array_merge($item, $itemArray);
                    }, $items->toArray(), $itemsArray->toArray());
            
                    return view('client.club.show', compact("store", "mergedItems","collections", "slug", 'projects', 'itemsArray', 'collections', 'collection', 'items'));
                
            
        }else{
            return view("errors.404");
        }

     
       
    }

    public function viewsLinks( $id ) {
        $collection = Collection::with("clicks.user")->where( 'id', $id )->first();
        return view( 'institutional.sharer-panel.views', compact( "collection" ) );
    }
    

    public function showLinks( $id ) {
        $collection = Collection::where( 'id', $id )->first();
        $sharer = User::findOrFail(auth()->user()->id);
            
        $items = ShareLink::where('user_id', auth()->user()->id)->where('collection_id', $collection->id)->get();
        $itemsArray = $items->map(function ($item) use ($sharer) {
            $action = null;
            $offSale = null;
    
            if ($item->item_type == 2) {
                $cartStatus = CartOrder::whereRaw("JSON_UNQUOTE(json_extract(cart, '$.type')) = 'housing'")
                    ->whereRaw("JSON_UNQUOTE(json_extract(cart, '$.item.id')) = ?", [$item->item_id])
                    ->first();
    
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
                $discount_amount = Offer::where( 'type', 'project' )->where( 'project_id', $item->project->id )
                ->where('project_housings', 'LIKE', '%' . $item->room_order . '%')->where( 'start_date', '<=', date( 'Y-m-d H:i:s' ) )->where( 'end_date', '>=', date( 'Y-m-d H:i:s' ) )->first()->discount_amount ?? 0;

               
                $status = CartOrder::where(DB::raw('JSON_EXTRACT(cart, "$.item.housing")'), $item->room_order)
                ->where(DB::raw('JSON_EXTRACT(cart, "$.item.id")'), $item->item_id)
                ->first();

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

        $mergedItems = array_map(function($item, $itemArray) {
            return array_merge($item, $itemArray);
        }, $items->toArray(), $itemsArray->toArray());

        return view( 'institutional.sharer-panel.show', compact( 'mergedItems','items', 'sharer', 'collection' ) );
    }

    public function sharerPanel() {
        $orders = SharerPrice::where( 'user_id', auth()->user()->id )->get();
        return view( 'client.sharer-panel.panel', compact( 'orders' ) );
    }

    public function sharerPanelByAnotherUser( $username ) {
        $sharer = User::where( 'username', $username )->first();
        $items = ShareLink::where( 'user_id', $sharer->id )->get();
        $itemsArray = [];
        foreach ( $items as $item ) {
            if ( $item->projectHousingData( $item->item_id ) ) {
                if ( isset( $item->projectHousingData( $item->item_id )[ 0 ] ) ) {
                    $item[ 'room_order' ] = $item->projectHousingData( $item->item_id )[ 0 ][ 'room_order' ];
                }
                $item[ 'project_values' ] = $item->projectHousingData( $item->item_id )->pluck( 'value', 'name' )->toArray();
            }
        }

        return view( 'client.sharer-panel.index', compact( 'items', 'sharer' ) );
    }

    public function deleteCollection($id)
{
    $collection = Collection::findOrFail($id);
    $collection->delete();

    return redirect()->back();
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
