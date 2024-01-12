<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\ShareLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller {
    public function getCollections() {
        $collections = Collection::where("user_id", Auth::user()->id)->get();

        return response()->json( [ 'collections' => $collections ] );
    }

    public function store( Request $request ) {

        $cart = $request->input("cart");

        $request->validate( [
            'collection_name' => 'required|string',
        ] );

        $collection = new Collection( [
            'name' => $request->input( 'collection_name' ),
            'user_id' => Auth::user()->id,
        ] );

        $collection->save();

        $type = $cart['type'];
        $id = $cart['id'];
        $project = $cart['project'];

        if ( $type == 'project' ) {
            $sharerLinksProjects = ShareLink::select( 'room_order', 'item_id' )->where( 'user_id', auth()->user()->id )->where( 'item_type', 1 )->get()->keyBy( 'item_id' )->toArray();
            $isHas = false;
            foreach ( $sharerLinksProjects as $linkProject ) {
                if ( $linkProject[ 'item_id' ] == $project && $linkProject[ 'room_order' ] == $id && $linkProject[ 'collection_id' ] == $collection->id ) {
                    $isHas = true;
                }
            }
            if ( !$isHas ) {
                ShareLink::create( [
                    'user_id' => auth()->user()->id,
                    'item_type' => 1,
                    'collection_id' =>  $collection->id,
                    'item_id' => $project,
                    'room_order' => $id
                ] );
            }else{
                return response( [ 'failed' => 'success' ] );
            }
                

        } else {
            $sharerLinks = array_values( array_keys( ShareLink::where( 'user_id', auth()->user()->id )->where( 'item_type', 2 )->where('collection_id', $collection->id )->get()->keyBy( 'item_id' )->toArray() ) );
            if ( !in_array( $id, $sharerLinks ) ) {
                ShareLink::create( [
                    'user_id' => auth()->user()->id,
                    'item_type' => 2,
                    'item_id' => $id,
                    'collection_id' =>  $collection->id,

                ] );
            }else{
                return response( [ 'failed' => 'success' ] );

            }

        }

        return response()->json( [ 'collection' => $collection ] );    }
}
