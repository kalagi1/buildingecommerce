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

    public function show( $housing ) {
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
            'meta_description' => 'Emlak Kulüpte' . $housing->title,
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
}
