<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

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
    
}