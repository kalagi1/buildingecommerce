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
use App\Models\Log;
use App\Models\SinglePrice;
use App\Models\StandOutUser;
use App\Models\TempOrder;
use App\Models\UserPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
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
            $tempData = json_decode($tempDataFull->data);
        } else {
            $tempData = json_decode("{}");
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
        return view('institutional.housings.create_v2', compact('housingTypeParent', 'cities', 'prices', 'tempData', 'housing_status', 'tempDataFull', 'selectedStatuses', 'userPlan'));
    }

    public function finishByTemp(Request $request)
    {
        try {
            DB::beginTransaction();
            $tempOrderFull = TempOrder::where('user_id', auth()->user()->parent_id ?? auth()->user()->id)->where('item_type', 2)->first();
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
                        "county_id" => $tempOrder->county_id,
                        "status_id" => 1,
                        'document' => $newDocument,
                        "status" => 2,
                        'housing_type_data' => json_encode($postData),
                        'user_id' => auth()->user()->parent_id ?? auth()->user()->parent_id ?? auth()->user()->id,
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        "status" => 2,
                    ]
                );

                if (!$request->without_doping) {
                    StandOutUser::create([
                        "user_id" => auth()->user()->parent_id ?? auth()->user()->parent_id ?? auth()->user()->id,
                        "project_id" => $project->id,
                        "item_order" => $tempOrder->doping_order,
                        "housing_status_id" => $tempOrder->doping_statuses,
                        "start_date" => date('Y-m-d', strtotime($tempOrder->doping_start_date)),
                        "end_date" => date('Y-m-d', strtotime($tempOrder->doping_end_date)),
                    ]);
                }

                UserPlan::where('user_id', auth()->user()->parent_id ?? auth()->user()->parent_id ?? auth()->user()->id)->decrement('housing_limit');

                DocumentNotification::create(
                    [
                        'user_id' => auth()->user()->parent_id ?? auth()->user()->id,
                        'text' => 'Yeni bir konut eklendi. Detayları incelemek için <a href="' . route('housing.show', ['id' => $project->id]) . '">buraya tıklayın</a>',
                        'item_id' => auth()->user()->parent_id ?? auth()->user()->id,
                        'link' => route('admin.housings.detail', ['housing' => $project->id]), // Rota adını ve parametreyi uygun şekilde ayarlayın
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
        } catch (Throwable $e) {
            DB::rollback();

            return json_encode([
                "status" => false,
                "message" => $e->getMessage(),
            ]);
        }
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
            "document" => "required|file|max:2048",
        ]);

        if (UserPlan::where('user_id', auth()->user()->parent_id ?? auth()->user()->id)->sum('housing_limit') <= 0) {
            return redirect()->back()->withErrors(['not_enough_limit' => 'Konut oluşturma hakkınız doldu.']);
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentName = $request->title . ' emlak belgesi.' . $document->getClientOriginalExtension();

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
                'user_id' => auth()->user()->parent_id ?? auth()->user()->parent_id ?? auth()->user()->id,
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

        UserPlan::where('user_id', auth()->user()->parent_id ?? auth()->user()->parent_id ?? auth()->user()->id)->decrement('housing_limit');

        DocumentNotification::create(
            [
                'user_id' => auth()->user()->parent_id ?? auth()->user()->id,
                'text' => 'Yeni bir konut eklendi. Detayları incelemek için <a href="' . route('housing.show', ['id' => $project->id]) . '">buraya tıklayın</a>',
                'item_id' => auth()->user()->parent_id ?? auth()->user()->id,
                'link' => route('admin.housings.detail', ['housing' => $lastId]), // Rota adını ve parametreyi uygun şekilde ayarlayın
                'owner_id' => 4,
                'is_visible' => true,
            ]
        );

        return redirect()->route('institutional.housing.list', ["status" => "new_housing"]);
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
            ->where('user_id', auth()->user()->parent_id ?? auth()->user()->id)
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
