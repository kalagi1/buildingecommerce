<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\ShareLink;
use App\Models\SharerPrice;
use App\Models\User;
use Illuminate\Http\Request;

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
}
