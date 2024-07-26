<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\HousingComment;
use App\Models\Page;
use App\Models\ProjectComment;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index($slug)
    {
        $pageInfo = Page::where('slug', $slug)->first();
        // Sayfa bulunamazsa 404 hatası döndür
        if (!$pageInfo) {
            return redirect('/')
            ->with('error', 'Sayfa bulunamadı.');
        }
    
        return view('client.blank', compact('pageInfo'));
    }

    public function contracts_show(){   
        $title = "Sözleşmeler";
        $contract_pages = Page::where('is_contract_page',1)->get();
        return view('client.pages.contracts',compact('contract_pages','title'));
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

    public function myReviews(Request $request)
    {
        // Retrieve comments from both tables for the authenticated user
        $housing_comments = HousingComment::where('user_id', auth()->user()->id)->get();
        $project_comments = ProjectComment::where('user_id', auth()->user()->id)->get();
        
        // Merge comments and add a type field to distinguish between them
        $all_comments = $housing_comments->map(function ($comment) {
            $comment->type = 'Emlak'; // Set type for housing comments
            return $comment;
        })->concat($project_comments->map(function ($comment) {
            $comment->type = 'Proje'; // Set type for project comments
            return $comment;
        }))->sortByDesc('created_at'); // Sort comments by creation date
        
        // Return view with the merged and sorted comments
        return view('client.panel.my_reviews.index', compact('all_comments'));
    }
    
    
    
}