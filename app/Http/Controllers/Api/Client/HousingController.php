<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Housing;
use App\Models\HousingComment;
use App\Models\HousingStatus;
use App\Models\HousingType;
use App\Models\HousingTypeParent;
use App\Models\Project;
use App\Models\ProjectHouseSetting;
use Illuminate\Http\Request;

class HousingController extends Controller {
    public function getDashboardStatuses() {

        $dashboardStatuses = HousingStatus::where( 'in_dashboard', 1 )->orderBy( 'dashboard_order' )->where( 'status', '1' )->get();
        return response()->json( $dashboardStatuses );

    }

    public function show( Housing $housing ) {
        $housing = Housing::with( 'neighborhood', 'images', 'reservations', 'user.housings', 'user.banners', 'brand', 'city', 'county' )
        ->where( 'id', $housing->id )
        ->where( 'status', 1 )->first();

        $housing->increment( 'views_count' );
        $housingSetting = ProjectHouseSetting::all();
        $housingComments = HousingComment::where( 'housing_id', $housing->id )->where( 'status', 1 )->with( 'user' )->get();

        $labels = [];
        $housingTypeData = json_decode( $housing->housing_type_data, true );

        $housingType = HousingType::find( $housing->housing_type_id );
        foreach ( $housingTypeData as $key => $value ) {

            if ( $housingType ) {
                $formJsonItems = json_decode( $housingType->form_json, true ) ?? [];

                foreach ( $formJsonItems as $formJsonItem ) {
                    $formJsonItemName = rtrim( $formJsonItem[ 'name' ], '[]' );

                    // Remove the last character '1' if it exists in the key
                    $keyWithoutLastCharacter = rtrim( $key, '1' );

                    // Check for equality after removing the last character
                    if ( isset( $formJsonItem[ 'name' ] ) && $formJsonItemName === $keyWithoutLastCharacter ) {
                        $labels[ $formJsonItem[ 'label' ] ] = $value;
                        break;
                    }
                }
            }
        }

        $pageInfo = [
            'meta_title' => $housing->title,
            'meta_keywords' => 'Emlak Sepette,İkinci el konut,konut',
            'meta_description' => 'Emlak Kulüpte ' . $housing->title . ' ile hayallerinizdeki konutu bulabilirsiniz. Geniş seçenekler, uygun fiyatlar ve 
                konforlu yaşam standartları sizi bekliyor. Her bütçeye uygun ev seçenekleriyle kaliteli bir yaşam sizleri bekliyor!',
            'meta_author' => 'Emlak Sepette',
        ];

        $pageInfo = json_encode( $pageInfo );
        $pageInfo = json_decode( $pageInfo );
        $parent = HousingTypeParent::where( 'slug', $housing->step1_slug )->first();

        return json_encode( [
            'pageInfo' => $pageInfo,
            'housing' => $housing,
            'parent' => $parent,
            'housingSetting' => $housingSetting,
            'housingID' => $housing->id,
            'housingComments' => $housingComments,
            'labels' => $labels
        ] );
    }


    public function getMyHousings(){
        $activeHousingTypes = Housing::with( 'city', 'county', 'neighborhood' )
        ->where( 'status', 1 )
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
        ->where( 'user_id', auth()->guard('api')->user()->parent_id ?  auth()->guard('api')->user()->parent_id : auth()->guard('api')->user()->id )
        ->orderByDesc( 'housings.updated_at' )
        ->get();

        $inactiveHousingTypes = Housing::with( 'city', 'county', 'neighborhood' )
        ->where( 'status', 0 )
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
        ->where( 'user_id', auth()->guard('api')->user()->parent_id ?  auth()->guard('api')->user()->parent_id : auth()->guard('api')->user()->id )
        ->orderByDesc( 'housings.updated_at' )
        ->get();

        $disabledHousingTypes = Housing::with( 'city', 'county', 'neighborhood' )
        ->where( 'status', 3 )
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
        ->where( 'user_id', auth()->guard('api')->user()->parent_id ?  auth()->guard('api')->user()->parent_id : auth()->guard('api')->user()->id )
        ->orderByDesc( 'housings.updated_at' )
        ->get();

        $pendingHousingTypes = Housing::with( 'city', 'county', 'neighborhood' )
        ->where( 'status', 2 )
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
        ->where( 'user_id', auth()->guard('api')->user()->parent_id ?  auth()->guard('api')->user()->parent_id : auth()->guard('api')->user()->id )
        ->orderByDesc( 'housings.updated_at' )
        ->get();

        return json_encode([
            "pendingHousingTypes" => $pendingHousingTypes,
            "disabledHousingTypes" => $disabledHousingTypes,
            "inactiveHousingTypes" => $inactiveHousingTypes,
            "activeHousingTypes" => $activeHousingTypes,
        ]);
    }
}
