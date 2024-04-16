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

class ClubController extends Controller {
    public function dashboard( $slug, $userID ) {

        $user = User::where( 'id', $userID )->first();

        $store = User::where( 'id', $user->id )->with( 'projects.housings', 'housings', 'city', 'town', 'district', 'neighborhood', 'brands',"child.collections.clicks", 'banners' )->first();

        $collections = Collection::with( 'links.project', 'links.housing' )->where( 'status', 1 )->where( 'user_id', $user->id )->get();
        return view( 'client.club.dashboard', compact( 'store', 'collections', 'slug' ) );
    }
}
