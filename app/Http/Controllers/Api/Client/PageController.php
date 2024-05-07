<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\ShareLink;
use App\Models\User;

class PageController extends Controller
{
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
    
}