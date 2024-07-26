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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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
        foreach ($housingTypeData as $key => $value) {
            if ($housingType) {
                $formJsonItems = json_decode($housingType->form_json, true) ?? [];
        
                foreach ($formJsonItems as $formJsonItem) {
                    // Check if $formJsonItem is an array
                    if (is_array($formJsonItem)) {
                        // Proceed with operations on $formJsonItem
                        if (isset($formJsonItem['name'])) {
                            $formJsonItemName = rtrim($formJsonItem['name'], '[]');
                            
                            // Remove the last character '1' if it exists in the key
                            $keyWithoutLastCharacter = rtrim($key, '1');
        
                            // Check for equality after removing the last character
                            if ($formJsonItemName === $keyWithoutLastCharacter) {
                                // Ensure $formJsonItem has 'label' key before accessing it
                                if (isset($formJsonItem['label'])) {
                                    $labels[$formJsonItem['label']] = $value;
                                }
                                break; // Exit the inner loop once a match is found
                            }
                        }
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


    public function getMyHousings(Request $request)
    {
        $user = auth()->guard('api')->user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
    
        $userId = $user->parent_id ? $user->parent_id : $user->id;
    
        $orderBy = $request->input('orderByHousings');
        
        $query = Housing::with('city', 'county', 'neighborhood')
            ->leftJoin('housing_types', 'housing_types.id', '=', 'housings.housing_type_id')
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
                DB::raw('JSON_UNQUOTE(JSON_EXTRACT(housings.housing_type_data, "$.price[0]")) as price')
            )
            ->where('user_id', $userId);

            if (isset($orderBy)) {
                if ($orderBy === 'asc-date') {
                    $query->orderBy('housings.created_at', 'asc');
                } elseif ($orderBy === 'desc-date') {
                    $query->orderBy('housings.created_at', 'desc');
                } elseif ($orderBy === 'asc-price') {
                    $query->orderByRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(housings.housing_type_data, "$.price[0]")) AS UNSIGNED) asc');
                } elseif ($orderBy === 'desc-price') {
                    $query->orderByRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(housings.housing_type_data, "$.price[0]")) AS UNSIGNED) desc');
                }
            }else{
                $query->orderBy('housings.created_at', 'desc');

            }
        
      
    
        $housingTypes = $query->get()->toArray();
    
        $activeHousingTypes = array_values(array_filter($housingTypes, function ($housing) {
            return $housing['status'] == 1;
        }));
    
        $inactiveHousingTypes = array_values(array_filter($housingTypes, function ($housing) {
            return $housing['status'] == 0;
        }));
    
        $disabledHousingTypes = array_values(array_filter($housingTypes, function ($housing) {
            return $housing['status'] == 3;
        }));
    
        $pendingHousingTypes = array_values(array_filter($housingTypes, function ($housing) {
            return $housing['status'] == 2;
        }));
    
        return response()->json([
            "pendingHousingTypes" => $pendingHousingTypes,
            "disabledHousingTypes" => $disabledHousingTypes,
            "inactiveHousingTypes" => $inactiveHousingTypes,
            "activeHousingTypes" => $activeHousingTypes,
        ]);
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

       $housingComment = HousingComment::create(
            [
                'user_id' => auth()->user()->id,
                'housing_id' => $id,
                'comment' => $comment,
                'rate' => $rate,
                'images' => json_encode( $images ),
                'owner_id' => $housing->user_id,
            ]
        );

        return response()->json(['message' => 'success'], 200);
    }
}
