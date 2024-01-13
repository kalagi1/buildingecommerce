<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
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

    public function showClientLinks( $slug, $id) {
        $users = User::all();
        foreach ($users as $institutional) {
          
            $slugName = Str::slug($institutional->name);
            if ($slugName === $slug) {
                if (!$institutional || $institutional->type != 21) {
                    abort(404);
                }

                $store = User::where("id", $institutional->id)->with('projects.housings', 'housings', 'city', 'town', 'district', "neighborhood", 'brands', "banners")->first();
                $projects = Project::where("user_id", $store->id)->with("brand", "roomInfo", "housingType", "county", "city", 'user.projects.housings', 'user.brands', 'user.housings', 'images')->orderBy("id", "desc")->where("status", "1")->limit(3)->get();
                
                
                $collections = Collection::with( 'links' )->where( 'user_id', $institutional->id )->get();
    
                $collection = Collection::findOrFail($id);
                $sharer = User::findOrFail(auth()->user()->id);
                $items = ShareLink::where('user_id', auth()->user()->id)->where('collection_id', $collection->id)->get();
            
                $itemsArray = $items->map(function ($item) {
                    $item['project_values'] = $item->projectHousingData($item->item_id)->pluck('value', 'name')->toArray();
                    $item['housing'] = $item->housing;
                    $item['project'] = $item->project;
                });

            
                return view('client.club.show', compact("store", "collections", "slug", 'projects','itemsArray', 'sharer', 'collections', 'collection','items'));           
            }
        }
    
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
