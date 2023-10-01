<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\City;
use App\Models\County;
use App\Models\Housing;
use App\Models\HousingStatus;
use App\Models\HousingStatusConnection;
use App\Models\HousingType;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HousingController extends Controller
{
    public function create(){
        $brands = Brand::where('user_id', auth()->user()->id)->where('status', 1)->get();
        $cities = City::get();
        $housing_types = HousingType::all();
        $housing_status = HousingStatus::all();
        return view('institutional.housings.create',compact('brands','cities','housing_types','housing_status'));
    }

    public function store(Request $request)
    {
        $postData = $request->all();
        $vData = $request->validate([
            'title' => 'required|string',
            'address' => 'required|string|max:128',
            'housing_type' => 'required|integer',
            'status' => 'required|in:1,2,3',
            'location' => 'required|string',
            "brand_id" => "required",
            "city_id" => "required",
            "county_id" => "required",
            "document" => "required|file|max:2048"
        ]);

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentName = $request->title. ' emlak belgesi.' . $document->getClientOriginalExtension();
            
            // Dosyayı public/housing_documents klasörüne taşı
            $document->move(public_path('/housing_documents'), $documentName);
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

        for ($k = 0; $k < count($request->file('images')); $k++) {
            $image = $request->file('images')[$k][0];
            $imageName = Str::slug(Str::slug($request->input('title'))) . '-' . $k . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/housing_images'), $imageName);
            array_push($files, $imageName);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image')[0];
            $imageName = Str::slug($request->input('title')) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/housing_images'), $imageName);
        }

        $postData['images'] = json_encode($files);
        $postData['image'] = $imageName;

        foreach ($unsetKeys as $key) {
            unset($postData[$key]);
        }

        $lastId = Housing::create(
            [
                'address' => $address,
                'title' => $title,
                'housing_type_id' => $housing_type,
                'status_id' => $status,
                'housing_type_data' => json_encode($postData),
                'user_id' => auth()->user()->id,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'brand_id' => $request->input('brand_id'),
                'city_id' => $request->input('city_id'),
                'county_id' => $request->input('county_id'),
                'description' => $request->input('description'),
                "status" => 2,
                'document' => $documentName,
            ]
        )->id;

        return redirect()->route('institutional.housing.list',["status" => "new_housing"]);
    }

    public function index(){
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
        ->where('user_id',auth()->user()->id)
        ->orderByDesc('created_at')
        ->get();
        
        return view('institutional.housings.index',compact('housing'));
    }

    public function edit($housingId){
        $housing = Housing::where('id',$housingId)->first();
        $statuses = $housing->housingStatus->keyBy('housing_status_id');
        $brands = Brand::where('user_id', auth()->user()->id)->where('status', 1)->get();
        $cities = City::get();
        $housing_types = HousingType::all();
        $housing_status = HousingStatus::all();
        $counties = County::where('city_id',$housing->city_id)->get();
        return view('institutional.housings.edit',compact('brands','cities','housing_types','housing_status','housing','counties','statuses'));
    }

    public function newHousingImage(Request $request){
        $housing = Housing::where('id',$request->input('housingId'))->first();
        if ($request->hasFile('file')) {
            $uploadedFile = $request->file('file');
            $imageName = Str::slug($housing->title) . '-' . time() . '.' . $uploadedFile->getClientOriginalExtension();

            $uploadedFile->move(public_path('/housing_images'), $imageName);
        }

        $housingData = json_decode($housing->housing_type_data);
        $images = $housingData->images;

        array_push($images,$imageName);

        $housingData->images = $images;
        $housing->update([
            "housing_type_data" => json_encode($housingData),
        ]);
        
        return json_encode([
            "status" => true,
            "imageName" => $imageName
        ]);
    }

    public function deleteHousingImage(Request $request){
        $housing = Housing::where('id',$request->input('housingId'))->first();
        $housingData = json_decode($housing->housing_type_data);
        $images = $housingData->images;
        $newImages = [];

        foreach($images as $key => $image){
            if($key != $request->order){
                array_push($newImages,$image);
            }
        }

        $housingData->images = $newImages;
        $housing->update([
            "housing_type_data" => json_encode($housingData)
        ]);

        return [
            "status" => true
        ];

    }

    public function update($id,Request $request){
        $housing = Housing::where('id',$id)->first();
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
            $documentName = $request->title. ' emlak belgesi.' . $document->getClientOriginalExtension();
            
            // Dosyayı public/housing_documents klasörüne taşı
            $document->move(public_path('/housing_documents'), $documentName);
        }else{
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
        }else{
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
                'user_id' => auth()->user()->id,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'brand_id' => $request->input('brand_id'),
                'city_id' => $request->input('city_id'),
                'county_id' => $request->input('county_id'),
                'description' => $request->input('description'),
                'document' => $documentName,
            ]
        );
        HousingStatusConnection::where('housing_id',$id)->delete();
        foreach($request->input('status') as $status){
            HousingStatusConnection::create([
                "housing_id" => $id,
                "housing_status_id" => $status
            ]);
        }

        return redirect()->route('institutional.housing.list',["status" => "update_housing"]);
    }

    public function logs($housingId){
        $logs = Log::where('item_type',2)->where('item_id',$housingId)->orderByDesc('created_at')->get();
        return view('institutional.housings.logs',compact('logs'));
    }
}
