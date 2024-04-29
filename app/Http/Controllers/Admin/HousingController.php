<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\City;
use App\Models\DefaultMessage;
use App\Models\Housing;
use App\Models\HousingStatus;
use App\Models\HousingType;
use App\Models\User;
use App\Models\Log;
use App\Models\HousingComment;
use App\Models\HousingTypeParent;
use App\Models\ShareLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Services\SmsService;
class HousingController extends Controller {
    /**
    * Display a listing of the resource.
    */

    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }


    public function index() {
        $activeHousingTypes = Housing::with( 'city', 'county', 'neighborhood' )
        ->where( 'status', 1 )
        ->where('is_share', '!=', 1)
        ->leftJoin( 'housing_types', 'housing_types.id', '=', 'housings.housing_type_id' )
        ->select(
            'housings.id',
            'housings.title AS housing_title',
            'housings.status AS status',
            'housings.address',
            'housings.created_at',
            'housing_types.title as housing_type',
            'housing_types.slug',
            'housings.city_id',
            'housings.deleted_at',
            'housings.county_id',
            'housings.neighborhood_id',
            'housing_types.form_json'
        )
        ->orderByDesc( 'housings.updated_at' )
        ->get();

        $inactiveHousingTypes = Housing::with( 'city', 'county', 'neighborhood' )
        ->where( 'status', 0 )
        ->where('is_share', '!=', 1)
        ->leftJoin( 'housing_types', 'housing_types.id', '=', 'housings.housing_type_id' )
        ->select(
            'housings.id',
            'housings.title AS housing_title',
            'housings.status AS status',
            'housings.address',
            'housings.created_at',
            'housing_types.title as housing_type',
            'housing_types.slug',
            'housings.deleted_at',
            'housings.city_id',
            'housings.county_id',
            'housings.neighborhood_id',
            'housing_types.form_json'
        )
        ->orderByDesc( 'housings.updated_at' )
        ->get();

        $disabledHousingTypes = Housing::with( 'city', 'county', 'neighborhood' )
        ->where( 'status', 3 )
        ->where('is_share', '!=', 1)
        ->leftJoin( 'housing_types', 'housing_types.id', '=', 'housings.housing_type_id' )
        ->select(
            'housings.id',
            'housings.title AS housing_title',
            'housings.status AS status',
            'housings.address',
            'housings.created_at',
            'housing_types.title as housing_type',
            'housing_types.slug',
            'housings.city_id',
            'housings.county_id',
            'housings.neighborhood_id',
            'housing_types.form_json'
        )
        ->where( 'user_id', auth()->user()->parent_id ?  auth()->user()->parent_id : auth()->user()->id )
        ->orderByDesc( 'housings.updated_at' )
        ->get();

        $disabledHousingTypes = Housing::with( 'city', 'county', 'neighborhood' )
        ->where( 'status', 3 )
        ->where('is_share', '!=', 1)
        ->leftJoin( 'housing_types', 'housing_types.id', '=', 'housings.housing_type_id' )
        ->select(
            'housings.id',
            'housings.title AS housing_title',
            'housings.status AS status',
            'housings.address',
            'housings.created_at',
            'housing_types.title as housing_type',
            'housing_types.slug',
            'housings.deleted_at',
            'housings.city_id',
            'housings.county_id',
            'housings.neighborhood_id',
            'housing_types.form_json'
        )
        ->orderByDesc( 'housings.updated_at' )
        ->get();

        $pendingHousingTypes = Housing::with( 'city', 'county', 'neighborhood' )
        ->where( 'status', 2 )
        ->where('is_share', '!=', 1)
        ->leftJoin( 'housing_types', 'housing_types.id', '=', 'housings.housing_type_id' )
        ->select(
            'housings.id',
            'housings.title AS housing_title',
            'housings.status AS status',
            'housings.address',
            'housings.created_at',
            'housing_types.title as housing_type',
            'housing_types.slug',
            'housings.deleted_at',
            'housings.city_id',
            'housings.county_id',
            'housings.neighborhood_id',
            'housing_types.form_json'
        )
        ->orderByDesc( 'housings.updated_at' )
        ->get();

        $deletedHousings = Housing::with( 'city', 'county', 'neighborhood' )
        ->where('is_share', '!=', 1)
        ->leftJoin( 'housing_types', 'housing_types.id', '=', 'housings.housing_type_id' )
        ->select(
            'housings.id',
            'housings.title AS housing_title',
            'housings.status AS status',
            'housings.address',
            'housings.created_at',
            'housing_types.title as housing_type',
            'housing_types.slug',
            'housings.city_id',
            'housings.deleted_at',
            'housings.county_id',
            'housings.neighborhood_id',
            'housing_types.form_json',
            'housings.deleteReason',
        )
        ->onlyTrashed()
        ->get();

        return view( 'admin.housings.index', compact( 'activeHousingTypes', 'disabledHousingTypes', 'disabledHousingTypes', 'pendingHousingTypes', 'deletedHousings', 'inactiveHousingTypes' ) );
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
        $parent = HousingTypeParent::where( 'slug', $housing->step1_slug )->first();

        return vieW( 'admin.housings.detail', compact( 'housing', 'parent', 'defaultMessages', 'housingData', 'housingTypeData' ) );
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
        $housingUpdate = Housing::where( 'id', $housingId )->update( [
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
                'reason' => '#'.$code." No'lu emlak ilanınız admin tarafından pasife alındı.",
                'is_rejected' => 0
            ] );

            ShareLink::where( 'item_type', 2 )->where( 'item_id', $housingId )->delete();

        } else {
            Log::create( [
                'item_type' => 2,
                'item_id' => $housingId,
                'user_id' => auth()->user()->id,
                'reason' => '#'.$code." No'lu emlak ilanınız admin tarafından aktif edildi.",
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


    public function isShareİndex(){

        $activeHousingTypes = Housing::with( 'city', 'county', 'neighborhood','owner' )
        ->where( 'status', 1 )
        ->where( 'is_share', 1 )
        ->leftJoin( 'housing_types', 'housing_types.id', '=', 'housings.housing_type_id' )
        ->select(
            'housings.id',
            'housings.title AS housing_title',
            'housings.status AS status',
            'housings.address',
            'housings.created_at',
            'housing_types.title as housing_type',
            'housing_types.slug',
            'housings.city_id',
            'housings.deleted_at',
            'housings.county_id',
            'housings.neighborhood_id',
            'housing_types.form_json',
            'housings.is_share',
            'owner_id',
        )
        ->orderByDesc( 'housings.updated_at' )
        ->get();

        if ($activeHousingTypes->isNotEmpty()) {
            foreach ($activeHousingTypes as $housing) {
                if (!is_null($housing->owner_id)) {
                    $owner = User::find($housing->owner_id);
                    $housing->owner = $owner;
                } else {
                    $housing->owner = null;
                }
            }
        }

        $inactiveHousingTypes = Housing::with( 'city', 'county', 'neighborhood','owner' )
        ->where( 'status', 0 )
        ->where( 'is_share', 1 )
        ->leftJoin( 'housing_types', 'housing_types.id', '=', 'housings.housing_type_id' )
        ->select(
            'housings.id',
            'housings.title AS housing_title',
            'housings.status AS status',
            'housings.address',
            'housings.created_at',
            'housing_types.title as housing_type',
            'housing_types.slug',
            'housings.deleted_at',
            'housings.city_id',
            'housings.county_id',
            'housings.neighborhood_id',
            'housing_types.form_json',
            'housings.is_share',
            'owner_id',
            
        )
        ->orderByDesc( 'housings.updated_at' )
        ->get();

        if ($inactiveHousingTypes->isNotEmpty()) {
            foreach ($activeHousingTypes as $housing) {
                if (!is_null($housing->owner_id)) {
                    $owner = User::find($housing->owner_id);
                    $housing->owner = $owner;
                } else {
                    $housing->owner = null;
                }
            }
        }

        $disabledHousingTypes = Housing::with( 'city', 'county', 'neighborhood','owner' )
        ->where( 'status', 3 )
        ->where( 'is_share', 1 )
        ->leftJoin( 'housing_types', 'housing_types.id', '=', 'housings.housing_type_id' )
        ->select(
            'housings.id',
            'housings.title AS housing_title',
            'housings.status AS status',
            'housings.address',
            'housings.created_at',
            'housing_types.title as housing_type',
            'housing_types.slug',
            'housings.city_id',
            'housings.county_id',
            'housings.neighborhood_id',
            'housing_types.form_json',
            'housings.is_share',
            'owner_id',
        )
        ->where( 'user_id', auth()->user()->parent_id ?  auth()->user()->parent_id : auth()->user()->id )
        ->orderByDesc( 'housings.updated_at' )
        ->get();

        if ($disabledHousingTypes->isNotEmpty()) {
            foreach ($activeHousingTypes as $housing) {
                if (!is_null($housing->owner_id)) {
                    $owner = User::find($housing->owner_id);
                    $housing->owner = $owner;
                } else {
                    $housing->owner = null;
                }
            }
        }
       

        $pendingHousingTypes = Housing::with( 'city', 'county', 'neighborhood','owner' )
        ->where( 'status', 2 )
        ->where( 'is_share', 1 )
        ->leftJoin( 'housing_types', 'housing_types.id', '=', 'housings.housing_type_id' )
        ->select(
            'housings.id',
            'housings.title AS housing_title',
            'housings.status AS status',
            'housings.address',
            'housings.created_at',
            'housing_types.title as housing_type',
            'housing_types.slug',
            'housings.deleted_at',
            'housings.city_id',
            'housings.county_id',
            'housings.neighborhood_id',
            'housing_types.form_json',
            'housings.is_share',
            'owner_id',
        )
        ->orderByDesc( 'housings.updated_at' )
        ->get();

        if ($pendingHousingTypes->isNotEmpty()) {
            foreach ($activeHousingTypes as $housing) {
                if (!is_null($housing->owner_id)) {
                    $owner = User::find($housing->owner_id);
                    $housing->owner = $owner;
                } else {
                    $housing->owner = null;
                }
            }
        }

        $deletedHousings = Housing::with( 'city', 'county', 'neighborhood','owner' )
        ->where( 'is_share', 1 )
        ->leftJoin( 'housing_types', 'housing_types.id', '=', 'housings.housing_type_id' )
        ->select(
            'housings.id',
            'housings.title AS housing_title',
            'housings.status AS status',
            'housings.address',
            'housings.created_at',
            'housing_types.title as housing_type',
            'housing_types.slug',
            'housings.city_id',
            'housings.deleted_at',
            'housings.county_id',
            'housings.neighborhood_id',
            'housing_types.form_json',
            'housings.is_share',
            'owner_id',
        )
        ->onlyTrashed()
        ->get();

        if ($deletedHousings->isNotEmpty()) {
            foreach ($activeHousingTypes as $housing) {
                if (!is_null($housing->owner_id)) {
                    $owner = User::find($housing->owner_id);
                    $housing->owner = $owner;
                } else {
                    $housing->owner = null;
                }
            }
        }

        return view( 'admin.housings.is_share_index', compact( 'activeHousingTypes', 'disabledHousingTypes', 'disabledHousingTypes', 'pendingHousingTypes', 'deletedHousings', 'inactiveHousingTypes') );

    }

    public function isShareDetail( $housingId ) {

        $defaultMessages = DefaultMessage::get();
       $housing = Housing::where('id', $housingId)
                    ->with('owner', 'user')
                    ->first();

        $housingData = json_decode( $housing->housing_type_data );
        $housingTypeData = HousingType::where( 'id', $housing->housing_type_id )->first();
        $housingTypeData = json_decode( $housingTypeData->form_json );
        $parent = HousingTypeParent::where( 'slug', $housing->step1_slug )->first();
        $housingCityId = (int) $housing->city_id;

      // $ownerCityId = (int) $housing->owner->id;
        $nearestUsers = User::with('city')
        ->select('id', 'name', 'city_id', DB::raw('ABS(CAST(city_id AS SIGNED) - ' . $housingCityId . ') as distance'))
        ->where('type', '=', 2) // type 2 olanları al
        ->where('corporate_type', '=', 'Emlak Ofisi') 
        ->whereNotNull('city_id') // city_id değeri null olmayanları al
        ->whereNull('parent_id') // parent_id değeri null olanları al
        ->orderBy('distance') // distance'a göre sıralama yap (en yakından en uzağa)
        ->get();
    

        return vieW( 'admin.housings.is_share_detail', compact( 'housing', 'parent', 'defaultMessages', 'housingData', 'housingTypeData' ,'nearestUsers' ) );
    }

    public function isShareSetStatus( $housingId, Request $request ) {
        
        $housing = Housing::where( 'id', $housingId )->firstOrFail();
        $housingUpdate = Housing::where( 'id', $housingId )->update( [
            'status' => '1',
            'user_id' => $request->input( 'user_id' ),
        ] );

        if ($housing) {
            $user = auth()->user();
            // Kullanıcının telefon numarasını kontrol et
            if ($housing->owner->mobile_phone) {
                
             

                // Eğer kullanıcıya ait bir telefon numarası varsa, SMS gönderme işlemi gerçekleştirilir
                $userPhoneNumber = $housing->owner->mobile_phone;
                $message = $housing->id + 2000000 .  " No'lu Emlak İlanınız " . $housing->owner->name . " mağazasında yayınlanmıştır. İlan detayı: " . url('ilan/' . $housing->slug . "/" . $housing->id + 2000000  . '/detay');; // Göndermek istediğiniz mesajı buraya ekleyin
        
                // SmsService sınıfını kullanarak SMS gönderme işlemi
                $smsService = new SmsService();
                $source_addr = 'MaliyetinEv'; // Kaynak adresi değiştirin, gerektiğinde.
        
                $smsService->sendSms($source_addr, $message, $userPhoneNumber);
            }
        }

       return redirect()->back();
    }
}
