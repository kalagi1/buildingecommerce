<?php

namespace App\Http\Controllers\Club;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\User;
use App\Models\Housing;
use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClubController extends Controller
{
    public function dashboard( $slug, $userID)
    {    
        dd("asad");

        $store = User::where('id', $userID)
            ->with('projects.housings', 'housings', 'city', 'town', 'district', "parent",'neighborhood', 'brands', "child.collections.clicks", 'banners')
            ->first();

        if (empty($store->parent_id)) {
            $collections = Collection::with('links.project', 'links.housing')
                ->where('status', 1)
                ->where('user_id', $store->id)
                ->get();
        } else {
            $collections = Collection::with('links.project', 'links.housing')
                ->where('user_id', $store->id)
                ->get();
        }
    
        // Hiç link yoksa koleksiyonu filtrele
        $collections = $collections->reject(function ($collection) {
            return $collection->links->isEmpty();
        });
    
        return view('client.club.dashboard', compact('store', 'collections', 'slug'));
    }
    
}
