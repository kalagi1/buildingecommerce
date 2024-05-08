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

    public function removeFromCollection(Request $request)
    {
        $itemType = $request->input('itemType');
        $itemId = $request->input('itemId');
        $projectId = $request->input('projectId');
    
        try {
            if ($itemType == 'project') {
                $link = ShareLink::where('item_id', $projectId)->where('item_type', 1)->where("room_order", $itemId)->first();
    
                if ($link) {
                    $link->delete();
                    return response()->json(['success' => true, 'message' => 'Item removed from the collection.']);
                } else {
                    return response()->json(['success' => false, 'message' => 'Link not found in the collection.']);
                }
            } elseif ($itemType == 'housing') {
                $link = ShareLink::where('item_id', $itemId)->where('item_type', 2)->first();
    
                if ($link) {
                    $link->delete();
                    return response()->json(['success' => true, 'message' => 'Item removed from the collection.']);
                } else {
                    return response()->json(['success' => false, 'message' => 'Link not found in the collection.']);
                }
            } else {
                return response()->json(['success' => false, 'message' => 'Invalid item type.']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error removing item from the collection.']);
        }
    }
    

    public function store( Request $request ) {
        return response()->json($request->all()) ;
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
            $sharerLinksProjects = ShareLink::select( 'room_order', 'item_id' ,"collection_id")->where( 'user_id', auth()->user()->id )->where( 'item_type', 1 )->get()->keyBy( 'item_id' )->toArray();
            $isHas = false;
            $ext = ShareLink::where("item_id", $project)->where("room_order",$id)->where("collection_id",$request->input( 'selectedCollectionId' ))->first();
            if ( $ext  ) {
                $isHas = true;
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
