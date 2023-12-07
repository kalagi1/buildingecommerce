<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\City;
use App\Models\County;
use App\Models\DocumentNotification;
use App\Models\Housing;
use App\Models\HousingStatus;
use App\Models\HousingStatusConnection;
use App\Models\HousingType;
use App\Models\HousingTypeParent;
use App\Models\HousingTypeParentConnection;
use App\Models\Log;
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

class HousingController extends Controller
{
    public function create()
    {
        $brands = Brand::where('user_id', auth()->user()->parent_id ?? auth()->user()->id)->where('status', 1)->get();
        $cities = City::get();
        $housing_types = HousingType::all();
        $housing_status = HousingStatus::all();
        return view('institutional.housings.create', compact('brands', 'cities', 'housing_types', 'housing_status'));
    }

    public function createV2()
    {
        

        
        $housingTypeParent = HousingTypeParent::whereNull('parent_id')->get();
        $prices = SinglePrice::where('item_type', 2)->get();
        $cities = City::get();
        $housing_status = HousingStatus::where("is_housing", 1)->where('is_default', 0)->get();
        $tempDataFull = TempOrder::where('item_type', 2)->where('user_id', auth()->guard()->user()->id)->first();
        
        if ($tempDataFull) {
            $hasTemp = true;
            $tempData = json_decode($tempDataFull->data);
        } else {
            $hasTemp = false;
            $tempData = json_decode("{}");
        }

        $areaSlugs = [];
        if(isset($tempDataFull) && isset($tempData->step1_slug) && $tempData->step1_slug){
            $topParent = HousingTypeParent::whereNull('parent_id')->where('slug',$tempData->step1_slug)->first();
            array_push($areaSlugs,$topParent->title);
            $secondAreaList = HousingTypeParent::where('parent_id',$topParent->id)->get();
        }else{
            $secondAreaList = null;
        }

        if(isset($tempDataFull) && isset($tempData->step2_slug) && $tempData->step2_slug){
            $topParent = HousingTypeParent::whereNull('parent_id')->where('slug',$tempData->step1_slug)->first();
            $topParentSecond = HousingTypeParent::where('parent_id',$topParent->id)->where('slug',$tempData->step2_slug)->first();
            array_push($areaSlugs,$topParentSecond->title);
            $housingTypes = HousingTypeParentConnection::where("parent_id",$topParentSecond->id)->join('housing_types','housing_types.id',"=","housing_type_parent_connections.housing_type_id")->get();
        }else{
            $housingTypes = null;
        }
        
        if(isset($tempDataFull) && isset($tempData->step3_slug) && $tempData->step3_slug){
            $housingTypeTemp = HousingTypeParentConnection::where('slug',$tempData->step3_slug)->where("parent_id",$topParentSecond->id)->join('housing_types','housing_types.id',"=","housing_type_parent_connections.housing_type_id")->first();
            
            array_push($areaSlugs,$housingTypeTemp->title);
        }
        if ($tempDataFull && isset($tempData->statuses)) {
            $selectedStatuses = HousingStatus::whereIn("id", $tempData->statuses)->get();
        } else {
            $selectedStatuses = [];
        }
        if ($tempDataFull) {
            $tempDataFull = $tempDataFull;
        } else {
            $tempDataFull = json_decode('{"step_order" : 1}');
        }

        $userPlan = UserPlan::where('user_id', auth()->user()->parent_id ?? auth()->user()->id)->first();
        return view('institutional.housings.create_v2', compact('housingTypeParent', 'cities', 'prices', 'tempData', 'housing_status', 'tempDataFull', 'selectedStatuses', 'userPlan','secondAreaList','housingTypes','areaSlugs','hasTemp'));
    }

    public function finishByTemp(Request $request)
    {
            DB::beginTransaction();
            $tempOrderFull = TempOrder::where('user_id',  auth()->user()->id)->where('item_type', 2)->first();
            $tempOrder = json_decode($tempOrderFull->data);
            $housingType = HousingType::where('slug', $tempOrder->step3_slug)->firstOrFail();
            $housingTypeInputs = json_decode($housingType->form_json);

            // Dosya adını değiştirme işlemi

            if ($tempOrderFull->step_order == 3) {
                $oldCoverImage = public_path('project_images/' . $tempOrder->cover_image); // Mevcut dosyanın yolu
                $extension = explode('.', $tempOrder->cover_image);
                $newCoverImage = Str::slug($tempOrder->name) . (Auth::user()->id) . '.' . end($extension);
                $newCoverImageName = public_path('housing_images/' . $newCoverImage); // Yeni dosya adı ve yolu
                File::move($oldCoverImage, $newCoverImageName);

                $oldDocument = public_path('housing_documents/' . $tempOrder->document); // Mevcut dosyanın yolu
                $extension = explode('.', $tempOrder->document);
                $newDocument = Str::slug($tempOrder->name) . '_verification_' . (Auth::user()->id) . '.' . end($extension);
                $newDocumentFile = public_path('housing_documents/' . $newDocument); // Yeni dosya adı ve yolu
                File::move($oldDocument, $newDocumentFile);

                $location = explode(',', $tempOrder->location);
                $latitude = $location[0];
                $longitude = $location[1];
                if(isset($tempOrder->roomInfoKeys->price))
                {
                    $tempOrder->roomInfoKeys->price = str_replace('.','',$tempOrder->roomInfoKeys->price);

                }
                if(isset($tempOrder->roomInfoKeys->{"daily_rent"})){
                    $tempOrder->roomInfoKeys->daily_rent = str_replace('.','',$tempOrder->roomInfoKeys->daily_rent);
                }
                $postData = $tempOrder->roomInfoKeys;
                $postData->image = $newCoverImage;
                $tempImageNames = [];
                foreach ($tempOrder->images as $key => $image) {
                    $eskiDosyaAdi = public_path('project_images/' . $image); // Mevcut dosyanın yolu
                    $extension = explode('.', $image);
                    $newFileName = Str::slug($tempOrder->name) . '-' . ($key + 1) . '.' . end($extension);
                    $yeniDosyaAdi = public_path('housing_images/' . $newFileName); // Yeni dosya adı ve yolu
                    File::move($eskiDosyaAdi, $yeniDosyaAdi);
                    array_push($tempImageNames, $newFileName);
                }
                $postData->images = $tempImageNames;
                $project = Housing::create(
                    [
                        "housing_type_id" => $housingType->id,
                        "title" => $tempOrder->name,
                        "address" => "asd",
                        "description" => $tempOrder->description,
                        "city_id" => $tempOrder->city_id,
                        "step1_slug" => $tempOrder->step1_slug,
                        "step2_slug" => $tempOrder->step2_slug,
                        "county_id" => $tempOrder->county_id,
                        "neighborhood_id" => $tempOrder->neighbourhood_id,
                        "status_id" => 1,
                        'document' => $newDocument,
                        "status" => 2,
                        'housing_type_data' => json_encode($postData, JSON_UNESCAPED_UNICODE),
                        'user_id' => auth()->user()->parent_id ?? auth()->user()->parent_id ?? auth()->user()->id,
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        "status" => 2,
                    ]
                );
                $defaultHousingconnection = HousingStatus::where('is_default',1)->where('is_housing',1)->first();
                HousingStatusConnection::create([
                    "housing_status_id" => $defaultHousingconnection->id,
                    "housing_id" => $project->id
                ]);

                if (isset($tempOrder->top_row) && $tempOrder->top_row) {
                    $now = Carbon::now();
                    $endDate = $now->addWeeks($tempOrder->top_row_data_day);
                    StandOutUser::create([
                        "user_id" => auth()->user()->parent_id ?? auth()->user()->parent_id ?? auth()->user()->id,
                        "item_id" => $project->id,
                        "item_type" => 2,
                        "housing_type_id" => $tempOrder->housing_type_id,
                        "start_date" => $now->format('y-m-d'),
                        "end_date" => $endDate->format('y-m-d'),
                    ]);
                }

                if (isset($tempOrder->featured) && $tempOrder->featured) {
                    $now = Carbon::now();
                    $endDate = $now->addWeeks($tempOrder->featured_data_day);
                    StandOutUser::create([
                        "user_id" => auth()->user()->parent_id ?? auth()->user()->parent_id ?? auth()->user()->id,
                        "item_id" => $project->id,
                        "item_type" => 2,
                        "housing_type_id" => 0,
                        "start_date" => $now->format('y-m-d'),
                        "end_date" => $endDate->format('y-m-d'),
                    ]);
                }

                UserPlan::where('user_id', auth()->user()->parent_id ?? auth()->user()->parent_id ?? auth()->user()->id)->decrement('housing_limit');

                DocumentNotification::create(
                    [
                        'user_id' => auth()->user()->parent_id ?? auth()->user()->id,
                        'text' => 'Yeni bir konut eklendi.',
                        'item_id' => auth()->user()->parent_id ?? auth()->user()->id,
                        'link' => route('admin.housings.detail', ['housing' => $project->id]), 
                        'owner_id' => 4,
                        'is_visible' => true,
                    ]
                );

                DB::commit();

                TempOrder::where('user_id', auth()->user()->parent_id ?? auth()->user()->id)->where('item_type', 2)->delete();

                return json_encode([
                    "status" => true,
                ]);
            } else {
                return json_encode([
                    "status" => false,
                    "message" => "Son aşamada değilsiniz",
                ]);
            }
        
    }

    

    public function index()
    {

        $housing = Housing::select(
            'housings.id',
            'housings.brand_id as brand_id',
            'housings.status as status',
            'housings.title AS housing_title',
            'housings.address',
            'housings.created_at',
            'housing_types.title as housing_type',
            'housing_types.slug',
            'housing_types.form_json'
        )
            ->with("brand")
            ->leftJoin('housing_types', 'housing_types.id', '=', 'housings.housing_type_id')
            ->where('user_id', auth()->user()->parent_id ?  auth()->user()->parent_id : auth()->user()->id)
            ->orderByDesc('created_at')
            ->get();

        return view('institutional.housings.index', compact('housing'));
    }

    public function edit($housingId)
    {
        $housing = Housing::where('id', $housingId)->first();
        $statuses = $housing->housingStatus->keyBy('housing_status_id');
        $brands = Brand::where('user_id', auth()->user()->parent_id ?? auth()->user()->id)->where('status', 1)->get();
        $cities = City::get();
        $housing_types = HousingType::all();
        $housing_status = HousingStatus::all();
        $counties = County::where('city_id', $housing->city_id)->get();
        return view('institutional.housings.edit', compact('brands', 'cities', 'housing_types', 'housing_status', 'housing', 'counties', 'statuses'));
    }

    public function newHousingImage(Request $request)
    {
        $housing = Housing::where('id', $request->input('housingId'))->first();
        if ($request->hasFile('file')) {
            $uploadedFile = $request->file('file');
            $imageName = Str::slug($housing->title) . '-' . time() . '.' . $uploadedFile->getClientOriginalExtension();

            $uploadedFile->move(public_path('/housing_images'), $imageName);
        }

        $housingData = json_decode($housing->housing_type_data);
        $images = $housingData->images;

        array_push($images, $imageName);

        $housingData->images = $images;
        $housing->update([
            "housing_type_data" => json_encode($housingData),
        ]);

        return json_encode([
            "status" => true,
            "imageName" => $imageName,
        ]);
    }

    public function deleteHousingImage(Request $request)
    {
        $housing = Housing::where('id', $request->input('housingId'))->first();
        $housingData = json_decode($housing->housing_type_data);
        $images = $housingData->images;
        $newImages = [];

        foreach ($images as $key => $image) {
            if ($key != $request->order) {
                array_push($newImages, $image);
            }
        }

        $housingData->images = $newImages;
        $housing->update([
            "housing_type_data" => json_encode($housingData),
        ]);

        return [
            "status" => true,
        ];

    }

    public function update($id, Request $request)
    {
        $housing = Housing::where('id', $id)->first();
        $housingData = json_decode($housing->housing_type_data);
        $postData = $request->all();
        $vData = $request->validate([
            'title' => 'required|string',
            'address' => 'required|string|max:128',
            'housing_type' => 'required|integer',
            'status' => 'required|array',
            'location' => 'required|string',
            "brand_id" => "required",
            "city_id" => "required",
            "county_id" => "required",
        ]);

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentName = $request->title . ' emlak belgesi.' . $document->getClientOriginalExtension();

            // Dosyayı public/housing_documents klasörüne taşı
            $document->move(public_path('/housing_documents'), $documentName);
        } else {
            $documentName = $housing->document;
        }

        $title = $vData['title'];
        $address = $vData['address'];
        $housing_type = $vData['housing_type'];
        $status = $vData['status'];
        $location = explode(',', $vData['location']);
        $latitude = $location[0];
        $longitude = $location[1];

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
            "county_id",
        ];

        $files = [];

        if ($request->hasFile('image')) {
            $image = $request->file('image')[0];
            $imageName = Str::slug($request->input('title')) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/housing_images'), $imageName);
            $postData['image'] = $imageName;
        } else {
            $postData['image'] = $housingData->image;
        }
        $postData['images'] = $housingData->images;

        foreach ($unsetKeys as $key) {
            unset($postData[$key]);
        }

        $lastId = $housing->update(
            [
                'address' => $address,
                'title' => $title,
                'housing_type_id' => $housing_type,
                'status_id' => 1,
                'housing_type_data' => json_encode($postData),
                'user_id' => auth()->user()->parent_id ?? auth()->user()->id,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'brand_id' => $request->input('brand_id'),
                'city_id' => $request->input('city_id'),
                'county_id' => $request->input('county_id'),
                'description' => $request->input('description'),
                'document' => $documentName,
            ]
        );
        HousingStatusConnection::where('housing_id', $id)->delete();
        foreach ($request->input('status') as $status) {
            HousingStatusConnection::create([
                "housing_id" => $id,
                "housing_status_id" => $status,
            ]);
        }

        return redirect()->route('institutional.housing.list', ["status" => "update_housing"]);
    }

    public function logs($housingId)
    {
        $logs = Log::where('item_type', 2)->where('item_id', $housingId)->orderByDesc('created_at')->get();
        return view('institutional.housings.logs', compact('logs'));
    }
}
