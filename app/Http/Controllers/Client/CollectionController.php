<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller {
    public function getCollections() {
        $collections = Collection::where("user_id", Auth::user()->id)->get();

        return response()->json( [ 'collections' => $collections ] );
    }

    public function store( Request $request ) {
        $request->validate( [
            'collection_name' => 'required|string|max:255|unique:collections,name,NULL,id,user_id,' . auth()->id(),
        ] );

        $collection = new Collection( [
            'name' => $request->input( 'collection_name' ),
            'user_id' => Auth::user()->id,
        ] );

        $collection->save();

        return response()->json( [ 'collection' => $collection ] );    }
}
