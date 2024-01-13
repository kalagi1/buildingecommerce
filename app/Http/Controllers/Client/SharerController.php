<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\CartOrder;
use App\Models\Collection;
use App\Models\ShareLink;
use App\Models\SharerPrice;
use App\Models\User;
use App\Models\Housing;
use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;

class SharerController extends Controller {
    public function index() {
        $sharer = User::where( 'id', auth()->user()->id )->first();
        $items = ShareLink::where( 'user_id', auth()->user()->id )->get();
        $collections = Collection::with( 'links' )->where( 'user_id', auth()->user()->id )->get();
        $itemsArray = [];
        foreach ( $items as $item ) {
            $item[ 'project_values' ] = $item->projectHousingData( $item->item_id )->pluck( 'value', 'name' )->toArray();
            $item[ 'housing' ] = $item->housing;

        }

        return view( 'institutional.sharer-panel.index', compact( 'items', 'sharer', 'collections' ) );
    }

    public function showClientLinks($slug, $id)
    {
        $institutional = User::where('type', 21)->where('name', Str::slug($slug))->firstOrFail();
    
        $store = User::with('projects.housings', 'housings', 'city', 'town', 'district', 'neighborhood', 'brands', 'banners')
            ->findOrFail($institutional->id);
    
        $projects = Project::with("brand", "roomInfo", "housingType", "county", "city", 'user.projects.housings', 'user.brands', 'user.housings', 'images')
            ->where("user_id", $store->id)->where("status", 1)->orderBy("id", "desc")->limit(3)->get();
    
        $collections = Collection::with('links')->where('user_id', $institutional->id)->get();
    
        $collection = Collection::findOrFail($id);
        $sharer = User::findOrFail(auth()->user()->id);
    
        $items = ShareLink::where('user_id', auth()->user()->id)->where('collection_id', $collection->id)->get();
        $itemsArray = $items->map(function ($item) use ($store) {
            $action = null;
            $offSale = null;
    
            if ($item->item_type == 2) {
                $cartStatus = CartOrder::whereRaw("JSON_UNQUOTE(json_extract(cart, '$.type')) = 'housing'")
                    ->whereRaw("JSON_UNQUOTE(json_extract(cart, '$.item.id')) = ?", [$item->item_id])
                    ->value('status');
    
                $action = $cartStatus !== null ? (
                    ($cartStatus == 0) ? 'payment_await' : (
                        ($cartStatus == 1) ? 'sold' : (
                            ($cartStatus == 2) ? 'tryBuy' : ''
                        )
                    )
                ) : 'noCart';
    
                $housingTypeData = json_decode($item->housing->housing_type_data, true);
                $offSale = isset($housingTypeData['off_sale1']);
            }
    
            if ($item->item_type == 1) {
                $userProjectIds = $store->projects->pluck('id');
                $status = CartOrder::selectRaw('COUNT(*) as count, MAX(status) as status')
                    ->whereIn('json_extract(cart, "$.item.id")', $userProjectIds)
                    ->get()
                    ->pluck('status', 'item.id')
                    ->get($item->project->id);
    
                $action = $status !== null ? (
                    ($status == 0) ? 'payment_await' : (
                        ($status == 1) ? 'sold' : (
                            ($status == 2) ? 'tryBuy' : ''
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
            ];
        });

        $mergedItems = array_map(function($item, $itemArray) {
            return array_merge($item, $itemArray);
        }, $items->toArray(), $itemsArray->toArray());

        return view('client.club.show', compact("store", "mergedItems","collections", "slug", 'projects', 'itemsArray', 'sharer', 'collections', 'collection', 'items'));
    }
    
    

    public function showLinks( $id ) {
        $collection = Collection::where( 'id', $id )->first();
        $sharer = User::where( 'id', auth()->user()->id )->first();
        $items = ShareLink::where( 'user_id', auth()->user()->id )->where( 'collection_id', $collection->id )->get();
        $collections = Collection::with( 'links' )->where( 'user_id', auth()->user()->id )->get();
        $itemsArray = [];
        foreach ( $items as $item ) {
            $item[ 'project_values' ] = $item->projectHousingData( $item->item_id )->pluck( 'value', 'name' )->toArray();
            $item[ 'housing' ] = $item->housing;
            $item[ 'project' ] = $item->project;
        }
        return view( 'institutional.sharer-panel.show', compact( 'items', 'sharer', 'collections', 'collection' ) );
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
