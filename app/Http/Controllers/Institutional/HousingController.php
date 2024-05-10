<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\City;
use App\Models\County;
use App\Models\District;
use App\Models\DocumentNotification;
use App\Models\Housing;
use App\Models\User;
use App\Models\HousingStatus;
use App\Models\HousingStatusConnection;
use App\Models\HousingType;
use App\Models\HousingTypeParent;
use App\Models\HousingTypeParentConnection;
use App\Models\Log;
use App\Models\Neighborhood;
use App\Models\SinglePrice;
use App\Models\StandOutUser;
use App\Models\TempOrder;
use App\Models\UserPlan;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Throwable;

class HousingController extends Controller {
    public function create() {
        $brands = Brand::where( 'user_id', auth()->user()->parent_id ?? auth()->user()->id )->where( 'status', 1 )->get();
        $cities = City::get();
        $housing_types = HousingType::all();
        $housing_status = HousingStatus::all();
        return view( 'institutional.housings.create', compact( 'brands', 'cities', 'housing_types', 'housing_status' ) );
    }

    public function createV2() {

        $housingTypeParent = HousingTypeParent::whereNull( 'parent_id' )->get();
        $prices = SinglePrice::where( 'item_type', 2 )->get();
        $cities = City::get()->toArray();
        $turkishAlphabet = [
            'A', 'B', 'C', 'Ç', 'D', 'E', 'F', 'G', 'Ğ', 'H', 'I', 'İ', 'J', 'K', 'L',
            'M', 'N', 'O', 'Ö', 'P', 'R', 'S', 'Ş', 'T', 'U', 'Ü', 'V', 'Y', 'Z'
        ];
        
        usort($cities, function($a, $b) use ($turkishAlphabet) {
            $priorityCities = ["İSTANBUL", "İZMİR", "ANKARA"];
            $endPriorityLetters = ["Y", "Z"];
        
            // Check if $a and $b are in the priority list
            $aPriority = array_search(strtoupper($a['title']), $priorityCities);
            $bPriority = array_search(strtoupper($b['title']), $priorityCities);
        
            // If both are in the priority list, sort based on their position in the list
            if ($aPriority !== false && $bPriority !== false) {
                return $aPriority - $bPriority;
            }
        
            // If only $a is in the priority list, move it to the top
            elseif ($aPriority !== false) {
                return -1;
            }
        
            // If only $b is in the priority list, move it to the top
            elseif ($bPriority !== false) {
                return 1;
            }
        
            // If neither $a nor $b is in the priority list, sort based on the first letter of the title
            else {
                $comparison = array_search(mb_substr($a['title'], 0, 1), $turkishAlphabet) - array_search(mb_substr($b['title'], 0, 1), $turkishAlphabet);
        
                // If the first letters are the same, check if they are 'Y' or 'Z'
                if ($comparison === 0 && in_array(mb_substr($a['title'], 0, 1), $endPriorityLetters)) {
                    return 1;
                } elseif ($comparison === 0 && in_array(mb_substr($b['title'], 0, 1), $endPriorityLetters)) {
                    return -1;
                }
        
                return $comparison;
            }
        });
        $housing_status = HousingStatus::where( 'is_housing', 1 )->where( 'is_default', 0 )->get();
        $tempDataFull = TempOrder::where( 'item_type', 2 )->where( 'user_id', auth()->guard()->user()->id )->first();

        if ( $tempDataFull ) {
            $hasTemp = true;
            $tempData = json_decode( $tempDataFull->data );
        } else {
            $hasTemp = false;
            $tempData = json_decode( '{}' );
        }

        $areaSlugs = [];
        if ( isset( $tempDataFull ) && isset( $tempData->step1_slug ) && $tempData->step1_slug ) {
            $topParent = HousingTypeParent::whereNull( 'parent_id' )->where( 'slug', $tempData->step1_slug )->first();
            array_push( $areaSlugs, $topParent->title );
            $secondAreaList = HousingTypeParent::where( 'parent_id', $topParent->id )->get();
        } else {
            $secondAreaList = null;
        }

        if ( isset( $tempDataFull ) && isset( $tempData->step2_slug ) && isset( $tempData->step1_slug ) && $tempData->step1_slug && $tempData->step2_slug ) {
            $topParent = HousingTypeParent::whereNull( 'parent_id' )->where( 'slug', $tempData->step1_slug )->first();
            $topParentSecond = HousingTypeParent::where( 'parent_id', $topParent->id )->where( 'slug', $tempData->step2_slug )->first();
            array_push( $areaSlugs, $topParentSecond->title );
            $housingTypes = HousingTypeParentConnection::where( 'parent_id', $topParentSecond->id )->join( 'housing_types', 'housing_types.id', '=', 'housing_type_parent_connections.housing_type_id' )->get();
        } else {
            $housingTypes = null;
        }

        if ( isset( $tempDataFull ) && isset( $tempData->step3_slug ) && isset( $tempData->step2_slug ) && isset( $tempData->step1_slug ) && $tempData->step1_slug && $tempData->step2_slug && $tempData->step3_slug ) {
            $housingTypeTemp = HousingTypeParentConnection::where( 'slug', $tempData->step3_slug )->where( 'parent_id', $topParentSecond->id )->join( 'housing_types', 'housing_types.id', '=', 'housing_type_parent_connections.housing_type_id' )->first();

            array_push( $areaSlugs, $housingTypeTemp->title );
        }
        if ( $tempDataFull && isset( $tempData->statuses ) ) {
            $selectedStatuses = HousingStatus::whereIn( 'id', $tempData->statuses )->get();
        } else {
            $selectedStatuses = [];
        }
        if ( $tempDataFull ) {
            $tempDataFull = $tempDataFull;
        } else {
            $tempDataFull = json_decode( '{"step_order" : 1}' );
        }

        $userPlan = UserPlan::where( 'user_id', auth()->user()->parent_id ?? auth()->user()->id )->first();
        return view( 'institutional.housings.create_v2', compact( 'housingTypeParent', 'cities', 'prices', 'tempData', 'housing_status', 'tempDataFull', 'selectedStatuses', 'userPlan', 'secondAreaList', 'housingTypes', 'areaSlugs', 'hasTemp' ) );
    }

    public function createV3() {
        return view( 'institutional.housings.create_v3');
    }

    public function finishByTemp( Request $request ) {
        DB::beginTransaction();
        $tempOrderFull = TempOrder::where( 'user_id',  auth()->user()->id )->where( 'item_type', 2 )->first();
        $tempOrder = json_decode( $tempOrderFull->data );
        $housingType = HousingType::where( 'slug', $tempOrder->step3_slug )->firstOrFail();
        $housingTypeInputs = json_decode( $housingType->form_json );

        // Dosya adını değiştirme işlemi

        if ( $tempOrderFull->step_order == 3 ) {
            $oldCoverImage = public_path( 'project_images/' . $tempOrder->cover_image );
            // Mevcut dosyanın yolu
            $extension = explode( '.', $tempOrder->cover_image );
            $newCoverImage = Str::slug( $tempOrder->name ) . ( Auth::user()->id ) . '.' . end( $extension );
            $newCoverImageName = public_path( 'housing_images/' . $newCoverImage );
            // Yeni dosya adı ve yolu
            File::move( $oldCoverImage, $newCoverImageName );

            $oldDocument = public_path( 'housing_documents/' . $tempOrder->document );
            // Mevcut dosyanın yolu
            $extension = explode( '.', $tempOrder->document );
            $newDocument = Str::slug( $tempOrder->name ) . '_verification_' . ( Auth::user()->id ) . '.' . end( $extension );
            $newDocumentFile = public_path( 'housing_documents/' . $newDocument );
            // Yeni dosya adı ve yolu
            File::move( $oldDocument, $newDocumentFile );

            $location = explode( ',', $tempOrder->location );
            $latitude = $location[ 0 ];
            $longitude = $location[ 1 ];
            if ( isset( $tempOrder->roomInfoKeys->price ) ) {
                $tempOrder->roomInfoKeys->price = str_replace( '.', '', $tempOrder->roomInfoKeys->price );

            }
            if ( isset( $tempOrder->roomInfoKeys-> {
                'daily_rent'}
            ) ) {
                $tempOrder->roomInfoKeys->daily_rent = str_replace( '.', '', $tempOrder->roomInfoKeys->daily_rent );
            }
            $postData = $tempOrder->roomInfoKeys;
            $postData->image = $newCoverImage;
            $tempImageNames = [];
            foreach ( $tempOrder->images as $key => $image ) {
                $eskiDosyaAdi = public_path( 'project_images/' . $image );
                // Mevcut dosyanın yolu
                $extension = explode( '.', $image );
                $newFileName = Str::slug( $tempOrder->name ) . '-' . ( $key + 1 ) . '.' . end( $extension );
                $yeniDosyaAdi = public_path( 'housing_images/' . $newFileName );
                // Yeni dosya adı ve yolu
                File::move( $eskiDosyaAdi, $yeniDosyaAdi );
                array_push( $tempImageNames, $newFileName );
            }
            $postData->images = $tempImageNames;
            $project = Housing::create(
                [
                    'housing_type_id' => $housingType->id,
                    'title' => $tempOrder->name,
                    'slug' => Str::slug($tempOrder->name),
                    'address' => 'asd',
                    'description' => $tempOrder->description,
                    'city_id' => $tempOrder->city_id,
                    'step1_slug' => $tempOrder->step1_slug,
                    'step2_slug' => $tempOrder->step2_slug,
                    'county_id' => $tempOrder->county_id,
                    'neighborhood_id' => $tempOrder->neighbourhood_id,
                    'status_id' => 1,
                    'document' => $newDocument,
                    'status' => 2,
                    'housing_type_data' => json_encode( $postData, JSON_UNESCAPED_UNICODE ),
                    'user_id' => auth()->user()->parent_id ?? auth()->user()->parent_id ?? auth()->user()->id,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'status' => 2,
                ]
            );
            $defaultHousingconnection = HousingStatus::where( 'is_default', 1 )->where( 'is_housing', 1 )->first();
            HousingStatusConnection::create( [
                'housing_status_id' => $defaultHousingconnection->id,
                'housing_id' => $project->id
            ] );

            if ( isset( $tempOrder->top_row ) && $tempOrder->top_row ) {
                $now = Carbon::now();
                $endDate = $now->addWeeks( $tempOrder->top_row_data_day );
                StandOutUser::create( [
                    'user_id' => auth()->user()->parent_id ?? auth()->user()->parent_id ?? auth()->user()->id,
                    'item_id' => $project->id,
                    'item_type' => 2,
                    'housing_type_id' => $tempOrder->housing_type_id,
                    'start_date' => $now->format( 'y-m-d' ),
                    'end_date' => $endDate->format( 'y-m-d' ),
                ] );
            }

            if ( isset( $tempOrder->featured ) && $tempOrder->featured ) {
                $now = Carbon::now();
                $endDate = $now->addWeeks( $tempOrder->featured_data_day );
                StandOutUser::create( [
                    'user_id' => auth()->user()->parent_id ?? auth()->user()->parent_id ?? auth()->user()->id,
                    'item_id' => $project->id,
                    'item_type' => 2,
                    'housing_type_id' => 0,
                    'start_date' => $now->format( 'y-m-d' ),
                    'end_date' => $endDate->format( 'y-m-d' ),
                ] );
            }

            UserPlan::where( 'user_id', auth()->user()->parent_id ?? auth()->user()->parent_id ?? auth()->user()->id )->decrement( 'housing_limit' );

            DocumentNotification::create(
                [
                    'user_id' => auth()->user()->parent_id ?? auth()->user()->id,
                    'text' => 'Yeni bir konut eklendi.',
                    'item_id' => auth()->user()->parent_id ?? auth()->user()->id,
                    'link' => route( 'admin.housings.detail', [ 'housing' => $project->id ] ),
                    'owner_id' => 4,
                    'is_visible' => true,
                ]
            );

            DB::commit();

            TempOrder::where( 'user_id', auth()->user()->parent_id ?? auth()->user()->id )->where( 'item_type', 2 )->delete();

            return json_encode( [
                'status' => true,
            ] );
        } else {
            return json_encode( [
                'status' => false,
                'message' => 'Son aşamada değilsiniz',
            ] );
        }

    }

    public function index() {
        $userId = auth()->user()->parent_id ? auth()->user()->parent_id : auth()->user()->id;
        $user = User::where("id", auth()->user()->id)->first();
    
        // Define a common base query for reuse
        $baseQuery = Housing::with('city', 'county', 'neighborhood',"owner","user","consultant")
            ->leftJoin('housing_types', 'housing_types.id', '=', 'housings.housing_type_id')
            ->select(
                'housings.id',
                'housings.title AS housing_title',
                'housings.status',
                'housings.address',
                'housings.created_at',
                'housing_types.title as housing_type',
                'housing_types.slug',
                'housings.city_id',
                'housings.county_id',
                'housings.neighborhood_id',
                'housing_types.form_json',
                'housings.is_share',
                'housings.owner_id',
                'housings.user_id',
                'housings.deleted_at',
                'housings.is_sold',
                'housings.consultant_id',

            )
            ->where(function ($query) use ($userId) {
                $query->where('housings.user_id', $userId)
                      ->orWhere('housings.owner_id', $userId);
            })
            ->orderByDesc('housings.updated_at');
    
        // Active housings
        $activeHousingTypes = (clone $baseQuery)
            ->where('status', 1)
            ->whereNull('deleted_at')
            ->whereNull('is_sold')
            ->get();
    
        // Inactive housings
        $inactiveHousingTypes = (clone $baseQuery)
            ->where('status', 0)
            ->whereNull('deleted_at')
            ->get();
    
        // Disabled housings
        $disabledHousingTypes = (clone $baseQuery)
            ->where('status', 3)
            ->whereNull('deleted_at')
            ->get();
    
        // Pending housings
        $pendingHousingTypes = (clone $baseQuery)
            ->where('status', 2)
            ->whereNull('deleted_at')
            ->get();
    
        // Sold housings
        $soldHousingTypes = (clone $baseQuery)
            ->where('is_sold', 1)
            ->whereNull('deleted_at')
            ->get();

        $isShareTypes = (clone $baseQuery)
            ->whereNotNull('owner_id') // owner_id olanları sınırlayalım
            ->whereNull('deleted_at') // silinmiş olanları filtreleyelim
            ->orWhereRaw('owner_id <> user_id') // owner_id ve user_id eşit olmayanları da ekleyelim
            ->get();

       

        return view('institutional.housings.index', compact('activeHousingTypes',"user", 'disabledHousingTypes', 'pendingHousingTypes', 'inactiveHousingTypes', 'soldHousingTypes','isShareTypes'));
    }
    

    public function edit( $housingId ) {
        $housing = Housing::where( 'id', $housingId )->first();
        $areaSlugs = [ ucfirst( $housing->step1_slug ), $housing->step2_slug == 'satilik' ? 'Satılık' : 'Kiralık', $housing->housing_type->title ];
        $cities = City::get();
        $counties = District::where( 'ilce_sehirkey', $housing->city_id )->get();
        $neighborhoods = Neighborhood::where( 'mahalle_ilcekey', $housing->county_id )->get();
        $formData = json_decode( $housing->housing_type_data );
        return view( 'institutional.housings.edit', compact( 'housing', 'areaSlugs', 'cities', 'formData', 'counties', 'neighborhoods' ) );
    }

    public function editImages( $housingId ) {
        $housing = Housing::where( 'id', $housingId )->first();
        $areaSlugs = [ ucfirst( $housing->step1_slug ), $housing->step2_slug == 'satilik' ? 'Satılık' : 'Kiralık', $housing->housing_type->title ];
        $cities = City::get();
        $counties = District::where( 'ilce_sehirkey', $housing->city_id )->get();
        $neighborhoods = Neighborhood::where( 'mahalle_ilcekey', $housing->county_id )->get();
        $formData = json_decode( $housing->housing_type_data );
        return view( 'institutional.housings.images', compact( 'housing', 'areaSlugs', 'cities', 'formData', 'counties', 'neighborhoods' ) );
    }

    public function newHousingImage( Request $request ) {
        $housing = Housing::where( 'id', $request->input( 'housingId' ) )->first();
        if ( $request->hasFile( 'file' ) ) {
            $uploadedFile = $request->file( 'file' );
            $imageName = Str::slug( $housing->title ) . '-' . time() . '.' . $uploadedFile->getClientOriginalExtension();

            $uploadedFile->move( public_path( '/housing_images' ), $imageName );
        }

        $housingData = json_decode( $housing->housing_type_data );
        $images = $housingData->images;

        array_push( $images, $imageName );

        $housingData->images = $images;
        $housing->update( [
            'housing_type_data' => json_encode( $housingData ),
        ] );

        return json_encode( [
            'status' => true,
            'imageName' => $imageName,
        ] );
    }

    public function deleteHousingImage( Request $request ) {
        $housing = Housing::where( 'id', $request->input( 'housingId' ) )->first();
        $housingData = json_decode( $housing->housing_type_data );
        $images = $housingData->images;
        $newImages = [];

        foreach ( $images as $key => $image ) {
            if ( $key != $request->order ) {
                array_push( $newImages, $image );
            }
        }

        $housingData->images = $newImages;
        $housing->update( [
            'housing_type_data' => json_encode( $housingData ),
        ] );

        return [
            'status' => true,
        ];

    }

    public function getTypeOnFormJson( $formJson, $key ) {
        foreach ( $formJson as $i => $formData ) {
            if ( str_contains( $key, str_replace( '[]', '', $formData->name ) ) ) {
                return $formData;
            }
        }

        return 'qwe';
    }

    public function addProjectImage( Request $request, $housingId ) {
        $housing = Housing::where( 'id', $housingId )->first();
        $formJson = json_decode( $housing->housing_type_data );
        $newOrder = count( $formJson->images );

        $uploadedFiles = $request->file();
        $imageNames = [];
        $tempOrder = 0;
        foreach ( $uploadedFiles as $fileKey => $file ) {
            $imageName = Str::slug( $housing->title ) . '-' . time().$fileKey . '.' . $file->getClientOriginalExtension();
            $file->move( public_path( 'housing_images' ), $imageName );

            array_push( $formJson->images, $imageName );
            array_push( $imageNames, $imageName );
            $tempOrder++;
        }

        Housing::where( 'id', $housingId )->update( [
            'housing_type_data' => json_encode( $formJson ),
            'status' => 2,
        ] );

        return $imageNames;
    }

    public function deleteProjectImage( Request $request, $housingId ) {
        $housing = Housing::where( 'id', $housingId )->first();
        $tempData = json_decode( $housing->housing_type_data );

        $newImages = [];
        foreach ( $tempData->images as $image ) {
            if ( $image != $request->input( 'image' ) ) {
                array_push( $newImages, $image );
            }
        }

        $tempData->images = $newImages;
        Housing::where( 'id', $housingId )->update( [
            'housing_type_data' => json_encode( $tempData )
        ] );
    }

    public function updateOrders( Request $request, $housingId ) {
        $housing = Housing::where( 'id', $housingId )->first();
        $tempData = json_decode( $housing->housing_type_data );

        $data = $tempData;
        $data->images = [];

        foreach ( $request->input( 'images' ) as $image ) {
            array_push( $data->images, $image );
        }

        Housing::where( 'id', $housingId )->update( [
            'housing_type_data' => json_encode( $data )
        ] );
    }

    public function changeCoverImage( Request $request, $housingId ) {
        $housing = Housing::where( 'id', $housingId )->first();
        $tempData = json_decode( $housing->housing_type_data );

        if ( $request->hasFile( 'image' ) ) {
            $file = $request->file( 'image' );
            $imageName = Str::slug( $housing->title ) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move( public_path( 'housing_images' ), $imageName );
        } else {
            $imageName = '';
        }

        $data = $tempData;
        $data->image = $imageName;

        Housing::where( 'id', $housingId )->update( [
            'housing_type_data' => json_encode( $data ),
            'status' => 2,
        ] );
    }

    public function update( $id, Request $request ) {
        $housing = Housing::where( 'id', $id )->first();
        $request->validate( [
            'name' => 'required|string',
            'description' => 'required|string',
            'city_id' => 'required|integer',
            'county_id' => 'required|integer',
            'neighbourhood_id' => 'required|integer',
            'location' => 'required|string',
        ] );
        $postData = $request->all();

        $unsetKeys = [
            '_token',
            'housing_type',
            'address',
            'name',
            'status',
            'location',
            'description',
            'brand_id',
            'city_id',
            'county_id',
            'cover-image',
            'project-images',
            'neighbourhood_id'
        ];

        foreach ( $unsetKeys as $key ) {
            unset( $postData[ $key ] );
        }

        $formData = json_decode( $housing->housing_type_data );
        $housingType = HousingType::where( 'id', $housing->housing_type_id )->first();
        $formJson = json_decode( $housingType->form_json );
        foreach ( $postData as $key => $val ) {
            if ( $this->getTypeOnFormJson( $formJson, $key )->type == 'checkbox-group' ) {
                $formData->{$key} = array_values( array_merge( ...$val ) );
            } else {
                if ( str_contains( $this->getTypeOnFormJson( $formJson, $key )->className, 'price-only' ) ) {
                $formData-> {$key} = str_replace( '.', '', $val );
                } else {
                    $formData-> {$key} = $val;
                }
            }
        }
        $housing->update(
            [
                'title' => $request->input( 'name' ),
                'description' => $request->input( 'description' ),
                'city_id' => $request->input( 'city_id' ),
                'county_id' => $request->input( 'county_id' ),
                'neighborhood_id' => $request->input( 'neighbourhood_id' ),
                'latitude' => explode( ',', $request->input( 'location' ) )[ 0 ],
                'longitude' => explode( ',', $request->input( 'location' ) )[ 1 ],
                'housing_type_data' => json_encode( $formData ),
                'status' => 2,
            ]
        );

        return redirect()->route( 'institutional.housing.list', [ 'status' => 'update_housing' ] );
    }

    public function logs( $housingId ) {
        $logs = Log::where( 'item_type', 2 )->where( 'item_id', $housingId )->orderByDesc( 'created_at' )->get();
        return view( 'institutional.housings.logs', compact( 'logs' ) );
    }

    public function destroy( $housingId ) {
        $housing = Housing::where( 'id', $housingId )->where( 'user_id', auth()->user()->id )->first();

        if ( $housing ) {
            $housing->delete();
        }

        return redirect()->route( 'institutional.housing.list' );
    }

    public function saveTempProject(){
        return "asd";
    }
}
