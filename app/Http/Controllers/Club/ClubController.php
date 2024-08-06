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
    public function dashboard( $parentSlug = null, $slug, $userID, )
    {    
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
    public function dashboardSatisNoktalari($slug, $userID)
    {
        // Mağazayı ve ilişkili verileri al
        $store = User::where('id', $userID)
            ->with('projects.housings', 'housings', 'city', 'town', 'district', 'parent', 'neighborhood', 'brands', 'child.collections.clicks', 'banners')
            ->first();
    
        // Kullanıcının emlak ilanlarını ve projelerini al
        $projects = $store->projects; // Mağazanın projeleri
        $housings = $store->housings; // Mağazanın emlak ilanları
    
        // Proje ve emlak ilanlarını içeren koleksiyonları al
        $collectionsWithProjects = Collection::whereHas('links.project', function($query) use ($projects) {
            $query->whereIn('id', $projects->pluck('id'));
        })->with('user')->get();
    
        $collectionsWithHousings = Collection::whereHas('links.housing', function($query) use ($housings) {
            $query->whereIn('id', $housings->pluck('id'));
        })->with('user')->get();
    
        // Koleksiyonların kullanıcılarını al
        $usersFromCollections = $collectionsWithProjects->merge($collectionsWithHousings)
        ->load('links', 'parent') // İlgili ilişkileri yükle

            ->pluck('user')
            ->unique()
            ->values();
    
            return $usersFromCollections;
        return view('client.club.dashboardSatisNoktalari', [
            'usersFromCollections' => $usersFromCollections,
            'store' => $store
        ]);
    }
    

    public function dashboard2( $slug, $userID, )
    {    
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
