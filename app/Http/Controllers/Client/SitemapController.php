<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Sitemap\SitemapGenerator;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = SitemapGenerator::create(config('app.url'))
            ->getSitemap();

        return $sitemap->render();
    }
}
