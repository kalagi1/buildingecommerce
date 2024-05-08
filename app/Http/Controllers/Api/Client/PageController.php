<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\ShareLink;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class PageController extends Controller
{
    public function getCollections() {
        $collections = Collection::where("user_id", Auth::user()->id)->get();

        return response()->json( [ 'collections' => $collections ] );
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

    public function contracts_show(){   
        $contract_pages = Page::where('is_contract_page',1)->get();

        return response()->json($contract_pages );
        
    }//End

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
    }//End

    public function clientCollections(){

        $sharer = User::where('id', auth()->user()->id)->first();
        $items = ShareLink::where('user_id', auth()->user()->id)->get();
        $collections = Collection::with('links', "clicks")->where('user_id', auth()->user()->id)->orderBy("id", "desc")->get();
        $itemsArray = [];
        foreach ($items as $item) {
            $item['project_values'] = $item->projectHousingData($item->item_id)->pluck('value', 'name')->toArray();
            $item['housing'] = $item->housing;
        }

        return response()->json([
            'success' => 'Koleksiyonlar başarıyla listelendi',
            'sharer' => $sharer,
            'items' => $items,
            'collections' => $collections
        ]);
    }//End

    public function editCollection($id, Request $request){
        $collection = Collection::findOrFail($id);
        $collection->update([
            "name" => $request->input("collectionName")
        ]);

        return response()->json([
            'success'    => "Koleksiyon başarıyla güncellendi.",
            'collection' => $collection
        ]);

    }//End

    public function deleteCollection($id){
        $collection = Collection::findOrFail($id);
        $collection->delete();

        return response()->json([
            'success' => "Koleksiyon başarıyla silindi."
        ]);
    }//End

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