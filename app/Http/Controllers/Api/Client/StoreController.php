<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class StoreController extends Controller {
    public function getFeaturedStores() {
        $brands = User::where( 'type', '2' )->where( 'corporate_type', 'İnşaat Ofisi' )->where( 'status', '1' )->where( 'is_show', 'yes' )->where( 'corporate_account_status', '1' )->orderBy( 'order', 'asc' )->get();

        return response()->json( $brands );
    }

    public function getFeaturedEstateStores() {
        $brands = User::where( 'type', '2' )->where( 'corporate_type', 'Emlak Ofisi' )->where( 'status', '1' )->where( 'is_show', 'yes' )->where( 'corporate_account_status', '1' )->orderBy( 'order', 'asc' )->get();

        return response()->json( $brands );
    }
}
