<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Housing;
use App\Models\HousingComment;
use App\Models\HousingType;
use App\Models\BankAccount;
use App\Models\HousingTypeParent;
use App\Models\Menu;
use App\Models\ProjectHouseSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HousingController extends Controller {
    public function alert() {

        $secondhandHousings =  Housing::with( 'images' )
        ->select(
            'housings.id',
            'housings.slug',
            'housings.title AS housing_title',
            'housings.created_at',
            'housings.step1_slug',
            'housings.step2_slug',
            'housing_types.title as housing_type_title',
            'housings.housing_type_data',
            'project_list_items.column1_name as column1_name',
            'project_list_items.column2_name as column2_name',
            'project_list_items.column3_name as column3_name',
            'project_list_items.column4_name as column4_name',
            'project_list_items.column1_additional as column1_additional',
            'project_list_items.column2_additional as column2_additional',
            'project_list_items.column3_additional as column3_additional',
            'project_list_items.column4_additional as column4_additional',
            'housings.address',
            \Illuminate\Support\Facades\DB::raw( '(SELECT status FROM cart_orders WHERE JSON_EXTRACT(cart, "$.type") = "housing" AND JSON_EXTRACT(cart, "$.item.id") = housings.id) AS sold' ),
            \Illuminate\Support\Facades\DB::raw( '(SELECT created_at FROM stand_out_users WHERE item_type = 2 AND item_id = housings.id AND housing_type_id = 0) as doping_time' ),
            'cities.title AS city_title',
            'districts.ilce_title AS county_title',
            'neighborhoods.mahalle_title AS neighborhood_title',
            DB::raw( '(SELECT discount_amount FROM offers WHERE housing_id = housings.id AND type = "housing" AND start_date <= "' . date( 'Y-m-d H:i:s' ) . '" AND end_date >= "' . date( 'Y-m-d H:i:s' ) . '") as discount_amount' ),
        )
        ->leftJoin( 'housing_types', 'housing_types.id', '=', 'housings.housing_type_id' )
        ->leftJoin( 'project_list_items', 'project_list_items.housing_type_id', '=', 'housings.housing_type_id' )
        ->leftJoin( 'housing_status', 'housings.status_id', '=', 'housing_status.id' )
        ->leftJoin( 'cities', 'cities.id', '=', 'housings.city_id' )
        ->leftJoin( 'districts', 'districts.ilce_key', '=', 'housings.county_id' )
        ->leftJoin( 'neighborhoods', 'neighborhoods.mahalle_id', '=', 'housings.neighborhood_id' )
        ->where( 'housings.status', 1 )
        ->where( 'project_list_items.item_type', 2 )
        ->orderByDesc( 'doping_time' )
        ->orderByDesc( 'housings.created_at' )
        ->get();

        return $secondhandHousings;
    }

    public function sendComment( Request $request, $id ) {
        $housing = Housing::where( 'id', $id )->with( 'user' )->first();
        $validator = Validator::make(
            $request->all(),
            [
                'rate' => 'required|string|in:1,2,3,4,5',
                'comment' => 'required|string',
            ]
        );

        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator->errors() );
        }

        $rate = $request->input( 'rate' );
        $comment = $request->input( 'comment' );

        $images = [];
        if ( is_array( $request->images ) ) {
            foreach ( $request->images as $image ) {
                $images[] = $image->store( 'public/housing-comment-images' );
            }
        }

        HousingComment::create(
            [
                'user_id' => auth()->user()->id,
                'housing_id' => $id,
                'comment' => $comment,
                'rate' => $rate,
                'images' => json_encode( $images ),
                'owner_id' => $housing->user_id,
            ]
        );

        return redirect()->back();
    }

    public function show( $housingSlug, $housingID ) {

        $menu = Menu::getMenuItems();
        $bankAccounts = BankAccount::all();

        $realHousingID  = $housingID;

        if ( intval( $housingID ) > 2000000 ) {
            $realHousingID = intval( $housingID ) - 2000000;

        }

        $housing = Housing::with( 'neighborhood', 'images', 'reservations', 'user.housings', 'user.banners', 'brand', 'city', 'county' )
        ->where( 'id', $realHousingID )
        ->where( 'status', 1 )->first();

        if ( $housing ) {

            $housingSetting = ProjectHouseSetting::all();
            $housingComments = HousingComment::where( 'housing_id', $realHousingID )->where( 'status', 1 )->with( 'user' )->get();

            $labels = [];
            $housingTypeData = json_decode( $housing->housing_type_data, true );

            foreach ( $housingTypeData as $key => $value ) {
                $housingType = HousingType::find( $housing->housing_type_id );

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

            return view( 'client.housings.detail', compact( 'pageInfo', 'housing', 'bankAccounts', 'parent', 'menu', 'housingSetting', 'housingID', 'housingComments', 'labels' ) );
        } else {
            return redirect( '/' )
            ->with( 'error', 'İlan yayından kaldırıldı veya bulunamadı.' );
        }
    }

    public function list( Request $request ) {
        $housings = Housing::query();
        if ( $request->input( 'search' ) ) {
            $housings = $housings->where( 'title', 'LIKE', '%' . $request->input( 'search' ) . '%' );
        }

        if ( $request->input( 'city' ) ) {
            $housings = $housings->where( 'city_id', $request->input( 'city' ) );
        }

        if ( $request->input( 'housing_type' ) ) {
            $housings = $housings->where( 'housing_type_id', $request->input( 'housing_type' ) );
        }

        $housings = $housings->get();
        if ( $request->input( 'min-price' ) != '' && $request->input( 'max-price' ) != '' ) {
            $housingsTemp = [];
            $maxPrice = intval( str_replace( ',', '', $request->input( 'max-price' ) ) );
            $minPrice = intval( str_replace( ',', '', $request->input( 'min-price' ) ) );
            foreach ( $housings as $housing ) {
                $housingTypeData = json_decode( $housing->housing_type_data );
                $housingPrice = floatval( $housingTypeData->price[ 0 ] );
                if ( $housingPrice >= $minPrice && $housingPrice <= $maxPrice ) {
                    array_push( $housingsTemp, $housing );
                }
            }

            $housings = $housingsTemp;
        }

        if ( $request->input( 'min-square-meters' ) != '' && $request->input( 'max-square-meters' ) != '' ) {
            $housingsTemp = [];
            $maxSquareMeters = intval( str_replace( ',', '', $request->input( 'max-square-meters' ) ) );
            $minSquareMeters = intval( str_replace( ',', '', $request->input( 'min-square-meters' ) ) );
            foreach ( $housings as $housing ) {
                $housingTypeData = json_decode( $housing->housing_type_data );
                $housingSquareMeters = floatval( $housingTypeData->squaremeters[ 0 ] );
                if ( $housingSquareMeters >= $minSquareMeters && $housingSquareMeters <= $maxSquareMeters ) {
                    array_push( $housingsTemp, $housing );
                }
            }
            $housings = $housingsTemp;
        }

        if ( $request->input( 'room_count' ) != '' ) {
            $housingsTemp = [];
            foreach ( $housings as $housing ) {
                $housingTypeData = json_decode( $housing->housing_type_data );
                $housingRoomCount = $housingTypeData->room_count[ 0 ];
                if ( $request->input( 'room_count' ) == $housingRoomCount ) {
                    array_push( $housingsTemp, $housing );
                }
            }
            $housings = $housingsTemp;
        }

        $menu = Menu::getMenuItems();
        $cities = City::get();
        $housingTypes = HousingType::get();

        return view( 'client.housings.list', compact( 'housings', 'menu', 'cities', 'housingTypes' ) );
    }
}
