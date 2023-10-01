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
        return view('client.blank', compact('pageInfo'));
    }
}