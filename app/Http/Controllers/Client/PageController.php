<?php

namespace App\Http\Controllers\Client;

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
            abort(404);
        }
    
        return view('client.blank', compact('pageInfo'));
    }
    
}