<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\City;
use App\Models\DefaultMessage;
use App\Models\Housing;
use App\Models\HousingStatus;
use App\Models\HousingType;
use App\Models\Log;
use App\Models\HousingComment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class HousingController extends Controller {
    /**
    * Display a listing of the resource.
    */

    public function index() {
        $housing = Housing::select(
            'housings.id',
            'housings.title AS housing_title',
            'housings.status AS status',
            'housings.address',
            'housings.created_at',
            'housing_types.title as housing_type',
            'housing_types.slug',
            'housing_types.form_json'
        )->leftJoin( 'housing_types', 'housing_types.id', '=', 'housings.housing_type_id' )
        ->orderByDesc( 'housings.id' )
        ->get();
        return view( 'admin.housings.index', [ 'housing' => $housing ] );
        //
    }

    /**
    * Display a listing of the comments.
    */

    public function comments() {
        $housing = HousingComment::all();
        return view( 'admin.housings.comments', [ 'housing' => $housing ] );
        //
    }

    public function approveComment( Request $request, $id ) {
        HousingComment::where( 'id', $id )->update( [ 'status' => 1 ] );
        return redirect()->back();
    }

    public function unapproveComment( Request $request, $id ) {
        HousingComment::where( 'id', $id )->update( [ 'status' => 0 ] );
        return redirect()->back();
    }

    /**
    * Show the form for creating a new resource.
    */

    public function create() {
        $brands = Brand::where( 'user_id', Auth::user()->id )->where( 'status', 1 )->get();
        $cities = City::get();
        $housing_types = HousingType::all();
        $housing_status = HousingStatus::all();
        return view( 'admin.housings.create', [ 'housing_types' => $housing_types, 'housing_status' => $housing_status, 'cities' => $cities, 'brands' => $brands ] );
    }

    public function detail( $housingId ) {
        $defaultMessages = DefaultMessage::get();
        $housing = Housing::where( 'id', $housingId )->first();
        $housingData = json_decode( $housing->housing_type_data );
        $housingTypeData = HousingType::where( 'id', $housing->housing_type_id )->first();
        $housingTypeData = json_decode( $housingTypeData->form_json );
        return vieW( 'admin.housings.detail', compact( 'housing', 'defaultMessages', 'housingData', 'housingTypeData' ) );
    }

    public function setStatus( $housingId, Request $request ) {
        $reason = '';
        $isRejected = 0;
        $code = $housingId + 2000000;
        if ( $request->input( 'status' ) == 3 ) {
            $isRejected = 1;
            $reason = $request->input( 'reason' );
        } else if ( $request->input( 'status' ) == 1 ) {
            $reason =  '#'.$code. "No'lu emlak ilanınız başarıyla yayınlandı.";
        } else {
            $reason = '#'.$code. "No'lu emlak ilanınız pasife alındı.";
        }
        $housing = Housing::where( 'id', $housingId )->firstOrFail();
        Housing::where( 'id', $housingId )->update( [
            'status' => $request->input( 'status' )
        ] );

        Log::create( [
            'item_type' => 2,
            'item_id' => $housingId,    
            'reason' => $reason,
            'user_id' => auth()->user()->id,
            'is_rejected' => $isRejected
        ] );

        return json_encode( [
            'status' => true
        ] );
    }

    public function setStatusGet( $housingId ) {
        $housing = Housing::where( 'id', $housingId )->firstOrFail();
        $code = $housingId + 2000000;

        if ( $housing->status == 0 || $housing->status == 2 ) {
            Housing::where( 'id', $housingId )->update( [
                'status' => 1
            ] );
        } else {
            Housing::where( 'id', $housingId )->update( [
                'status' => 0
            ] );
        }

        if ( $housing->status == 1 ) {
            Log::create( [
                'item_type' => 2,
                'item_id' => $housingId,
                'user_id' => auth()->user()->id,
                'reason' => "#".$code." No'lu emlak ilanınız admin tarafından pasife alındı.",
                'is_rejected' => 0
            ] );
        } else {
            Log::create( [
                'item_type' => 2,
                'item_id' => $housingId,
                'user_id' => auth()->user()->id,
                'reason' => "#".$code." No'lu emlak ilanınız admin tarafından aktif edildi.",
                'is_rejected' => 0
            ] );
        }

        return redirect()->route( 'admin.housings.detail', $housingId );
    }

    /**
    * Store a newly created resource in storage.
    */

    public function store( Request $request ) {
        $postData = $request->all();
        $vData = $request->validate( [
            'title' => 'required|string',
            'address' => 'required|string|max:128',
            'housing_type' => 'required|integer',
            'status' => 'required|in:1,2,3',
            'location' => 'required|string',
            'brand_id' => 'required',
            'city_id' => 'required',
            'county_id' => 'required',
        ] );

        $title = $vData[ 'title' ];
        $address = $vData[ 'address' ];
        $housing_type = $vData[ 'housing_type' ];
        $status = $vData[ 'status' ];
        $location = explode( ',', $vData[ 'location' ] );
        $latitude = $location[ 0 ];
        $longitude = $location[ 1 ];

        $unsetKeys = [
            //Housing type için gelen form inputlarını ayırt etmek için
            '_token',
            'housing_type',
            'address',
            'title',
            'status',
            'location',
            'description',
            'brand_id',
            'city_id',
            'county_id',
        ];

        $files = [];

        for ( $k = 0; $k < count( $request->file( 'images' ) );
        $k++ ) {
            $image = $request->file( 'images' )[ $k ][ 0 ];
            $imageName = Str::slug( Str::slug( $request->input( 'title' ) ) ) . '-' . $k . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move( public_path( '/housing_images' ), $imageName );
            array_push( $files, $imageName );
        }

        if ( $request->hasFile( 'image' ) ) {
            $image = $request->file( 'image' )[ 0 ];
            $imageName = Str::slug( $request->input( 'title' ) ) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move( public_path( '/housing_images' ), $imageName );
        }

        $postData[ 'images' ] = json_encode( $files );
        $postData[ 'image' ] = $imageName;

        foreach ( $unsetKeys as $key ) {
            unset( $postData[ $key ] );
        }

        $lastId = Housing::create(
            [
                'address' => $address,
                'title' => $title,
                'housing_type_id' => $housing_type,
                'status_id' => $status,
                'housing_type_data' => json_encode( $postData ),
                'user_id' => 1,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'brand_id' => $request->input( 'brand_id' ),
                'city_id' => $request->input( 'city_id' ),
                'county_id' => $request->input( 'county_id' ),
                'description' => $request->input( 'description' ),
            ]
        )->id;
    }

    /**
    * Display the specified resource.
    */

    public function show( string $id ) {
        //
    }

    /**
    * Show the form for editing the specified resource.
    */

    public function edit( string $id ) {
        //
    }

    /**
    * Update the specified resource in storage.
    */

    public function update( Request $request, string $id ) {
        //
    }

    /**
    * Remove the specified resource from storage.
    */

    public function destroy( string $id ) {
        //
    }

    public function logs( $housingId ) {
        $logs = Log::where( 'item_type', 2 )->where( 'item_id', $housingId )->orderByDesc( 'created_at' )->get();
        return view( 'admin.housings.logs', compact( 'logs' ) );
    }
}
