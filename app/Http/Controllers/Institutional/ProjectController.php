<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Jobs\AdvertTimeJob;
use App\Models\BankAccount;
use App\Models\Brand;
use App\Models\CartOrder;
use App\Models\City;
use App\Models\County;
use App\Models\District;
use App\Models\DocumentNotification;
use App\Models\HousingStatus;
use App\Models\HousingType;
use App\Models\HousingTypeParent;
use App\Models\HousingTypeParentConnection;
use App\Models\Log;
use App\Models\Menu;
use App\Models\Neighborhood;
use App\Models\Offer;
use App\Models\PricingStandOut;
use App\Models\Project;
use App\Models\ProjectHousing;
use App\Models\ProjectHousingType;
use App\Models\ProjectImage;
use App\Models\SinglePrice;
use App\Models\StandOutUser;
use App\Models\TempOrder;
use App\Models\User;
use App\Models\UserPlan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProjectController extends Controller
{

    public function housings($project_id)
    {
        $menu = Menu::getMenuItems();
        $project = Project::where('id', $project_id)->with("brand", "roomInfo", "housingType", "county", "city", 'user.projects.housings', 'user.brands', 'user.housings', 'images')->firstOrFail();
        $project->roomInfo = $project->roomInfo;
        $project->brand = $project->brand;
        $project->housingType = $project->housingType;
        $project->county = $project->county;
        $project->city = $project->city;
        $project->user = $project->user;
        $project->user->housings = $project->user->housings;
        $project->user->brands = $project->user->brands;
        $project->images = $project->images;
        $offer = Offer::where('project_id', $project->id)->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))->first();

        return view('institutional.projects.housings', compact('menu', "offer", 'project'));

    }
    public function index()
    {
        $bankAccounts = BankAccount::all();

        // Tüm projeleri çek ve ilişkiyi yükle
        $projects = Project::where('user_id', Auth::user()->id)
            ->with("brand", "roomInfo", "housingType", "county", "city", 'user.projects.housings', 'user.brands', 'user.housings', 'images')
            ->orderByDesc('created_at')
            ->get();

        $userProjectIds = $projects->pluck('id'); // Kullanıcının proje ID'lerini al

        $projectCounts = CartOrder::selectRaw('COUNT(*) as count, JSON_UNQUOTE(json_extract(cart, "$.item.id")) as project_id, MAX(status) as status')
            ->whereIn(DB::raw('JSON_UNQUOTE(json_extract(cart, "$.item.id"))'), $userProjectIds)
            ->groupBy('project_id')
            ->where("status", "1")
            ->get();


        // Projeleri ilgili sipariş sayısı ile eşleştirin
        $projects = $projects->map(function ($project) use ($projectCounts) {
            $project->cartOrders = $projectCounts->where('project_id', $project->id)->first()->count ?? 0;
            return $project;
        });


        return view('institutional.projects.index', compact('projects', 'bankAccounts'));
    }

    public function create()
    {
        $brands = Brand::where('user_id', Auth::user()->id)->where('status', 1)->get();
        $housing_types = HousingType::all();
        $housing_status = HousingStatus::all();
        $cities = City::get();
        return view('institutional.projects.create', compact('housing_types', 'housing_status', 'brands', 'cities'));
    }

    public function createV2()
    {
        $housingTypeParent = HousingTypeParent::whereNull('parent_id')->get();
        $prices = SinglePrice::where('item_type', 1)->get();
        $cities = City::get();
        $housing_status = HousingStatus::where('is_project', 1)->where('is_default', 0)->get();
        $housing_statusX = HousingStatus::where('is_project', 1)->where('is_default', 1)->first();
        $tempDataFull = TempOrder::where('item_type', 1)->where('user_id', auth()->guard()->user()->id)->first();
        if ($tempDataFull) {
            $hasTemp = true;
            $tempData = json_decode($tempDataFull->data);
        } else {
            $tempData = json_decode('{}');
            $hasTemp = false;
        }
        $areaSlugs = [];
        if (isset($tempDataFull) && $tempData->step1_slug) {
            $topParent = HousingTypeParent::whereNull('parent_id')->where('slug', $tempData->step1_slug)->first();
            array_push($areaSlugs, $topParent->title);
            $secondAreaList = HousingTypeParent::where('parent_id', $topParent->id)->get();
        } else {
            $secondAreaList = null;
        }

        if (isset($tempData->housing_type_id) && $tempData->housing_type_id) {
            $housingTypeTempX = HousingType::where('id', $tempData->housing_type_id)->first();
        } else {
            $housingTypeTempX = null;
        }

        if (isset($tempDataFull) && $tempData->step2_slug) {
            $topParent = HousingTypeParent::whereNull('parent_id')->where('slug', $tempData->step1_slug)->first();
            $topParentSecond = HousingTypeParent::where('parent_id', $topParent->id)->where('slug', $tempData->step2_slug)->first();
            array_push($areaSlugs, $topParentSecond->title);
            $housingTypes = HousingTypeParentConnection::where("parent_id", $topParentSecond->id)->join('housing_types', 'housing_types.id', "=", "housing_type_parent_connections.housing_type_id")->get();
        } else {
            $housingTypes = null;
        }

        if (isset($tempDataFull) && $tempData->step3_slug) {
            $housingTypeTemp = HousingTypeParentConnection::where('slug', $tempData->step3_slug)->where("parent_id", $topParentSecond->id)->join('housing_types', 'housing_types.id', "=", "housing_type_parent_connections.housing_type_id")->first();

            array_push($areaSlugs, $housingTypeTemp->title);
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

        $userPlan = UserPlan::where('user_id', auth()->user()->id)->first();
        return view('institutional.projects.createv2', compact('housingTypeParent', 'cities', 'prices', 'tempData', 'housing_status', 'tempDataFull', 'selectedStatuses', 'userPlan', 'hasTemp', 'secondAreaList', 'housingTypes', 'areaSlugs', 'housingTypeTempX'));
    }

    public function editV2($slug)
    {
        $housingTypeParent = HousingTypeParent::whereNull('parent_id')->get();
        $prices = SinglePrice::where('item_type', 1)->get();
        $cities = City::get();
        $tempUpdateHas = false;
        $housing_status = HousingStatus::all();
        $tempDataFull = TempOrder::where('item_type', 1)->where('user_id', auth()->guard()->user()->id)->first();
        $tempDataFull = Project::where('slug', $slug)->first();
        $project = Project::where('slug', $slug)->first();
        $tempDataFull2 = Project::where('slug', $slug)->first();
        $housingType = HousingType::where('id', $tempDataFull->housing_type_id)->first();
        $tempUpdate = TempOrder::where('item_type', 3)->where('user_id', auth()->user()->id)->first();
        if ($tempUpdate && json_decode($tempUpdate->data)->data_slug == $slug) {
            $tempUpdateHas = true;
            $tempDataFull = $tempUpdate;

            $tempData = json_decode($tempDataFull->data);
            $tempData->step3_slug = $housingType->slug;
        } else {
            TempOrder::where('item_type', 3)->where('user_id', auth()->user()->id)->delete();
            if ($tempDataFull) {
                $tempData = $tempDataFull;
                $tempData->roomInfoKeys = $tempDataFull->roomInfo;
                $tempData->step3_slug = $housingType->slug;
            } else {
                $tempData = json_decode("{}");
            }
            $tempDataFull->data_slug = $slug;
            $selectedStatuses = HousingStatus::select("id")->whereIn("id", $tempDataFull2->housingStatusIds)->get()->keyBy('id')->toArray();
            $tempDataFull->statuses = array_keys((array) $selectedStatuses);
            $tempDataFull->images = $tempDataFull->images;
            TempOrder::create([
                "user_id" => auth()->user()->id,
                "data" => json_encode($tempDataFull),
                "item_type" => 3,
                "step_order" => 1,
            ]);
        }

        $selectedStatuses = $tempDataFull->statuses;
        if ($tempDataFull) {
            $tempDataFull = $tempDataFull;
        } else {
            $tempDataFull = json_decode('{"step_order" : 1}');
        }

        $userPlan = UserPlan::where('user_id', auth()->user()->id)->first();
        return view('institutional.projects.editv2', compact('tempUpdateHas', 'project', 'housingTypeParent', 'cities', 'prices', 'tempData', 'housing_status', 'tempDataFull', 'selectedStatuses', 'userPlan'));
    }

    public function getBusyDatesByStatusType($statusId, Request $request)
    {
        return json_encode([
            "busy_dates" => StandOutUser::where('housing_status_id', $statusId)->where('item_order', $request->input('order'))->get(),
            "price" => PricingStandOut::where('housing_status_id', $statusId)->where('order', $request->input('order'))->first(),
        ]);
    }

    public function getHousingTypeChildren(Request $request, $slug)
    {
        if ($request->input('parent_slug')) {
            $topParent = HousingTypeParent::whereNull('parent_id')->where('slug', $request->input('parent_slug'))->first();
            $housingTypeParent = HousingTypeParent::where('slug', $slug)->where('parent_id', $topParent->id)->first();
        } else {
            $housingTypeParent = HousingTypeParent::where('slug', $slug)->first();
        }

        if ($housingTypeParent->is_end) {
            $housingTypes = HousingTypeParentConnection::where("parent_id", $housingTypeParent->id)->join('housing_types', 'housing_types.id', "=", "housing_type_parent_connections.housing_type_id")->get();
            return [
                "data" => $housingTypes,
                "is_end" => 0,
            ];
        } else {
            $housingTypeChildren = HousingTypeParent::where('parent_id', $housingTypeParent->id)->get();
            return [
                "data" => $housingTypeChildren,
                "is_end" => 1,
            ];
        }
    }

    public function createProjectEnd(Request $request)
    {
        DB::beginTransaction();
        $tempOrderFull = TempOrder::where('user_id', auth()->user()->id)->where('item_type', 1)->first();
        $tempOrder = json_decode($tempOrderFull->data);
        $housingType = HousingType::where('slug', $tempOrder->step3_slug)->firstOrFail();
        $housingTypeInputs = json_decode($housingType->form_json);

        if ($tempOrderFull->step_order == 3) {
            $oldCoverImage = public_path('project_images/' . $tempOrder->cover_image); // Mevcut dosyanın yolu
            $extension = explode('.', $tempOrder->cover_image);
            $newCoverImage = Str::slug($tempOrder->name) . (Auth::user()->id) . '.' . end($extension);
            $newCoverImageName = public_path('storage/project_images/' . $newCoverImage); // Yeni dosya adı ve yolu
            if (File::exists($oldCoverImage)) {
                File::move($oldCoverImage, $newCoverImageName);
            }
            $oldDocument = public_path('housing_documents/' . $tempOrder->document); // Mevcut dosyanın yolu
            $extension = explode('.', $tempOrder->document);
            $newDocument = Str::slug($tempOrder->name) . '_verification_' . (Auth::user()->id) . '.' . end($extension);
            $newDocumentFile = public_path('housing_documents/' . $newDocument); // Yeni dosya adı ve yolu
            if (File::exists($oldDocument)) {
                File::move($oldDocument, $newDocumentFile);
            }
            $now = Carbon::now();
            if ($tempOrder->{"pricing-type"} == "2") {
                $singlePrice = SinglePrice::where('id', $tempOrder->price_id)->first();
                $endDate = $now->addMonths($singlePrice->month);
                $month = $singlePrice->month;
            } else {
                $endDate = $now->addMonths(2);
                $month = 2;
            }

            $instUser = User::where("id", Auth::user()->id)->first();
            $project = Project::create([
                "housing_type_id" => $housingType->id,
                "step1_slug" => $tempOrder->step1_slug,
                "step2_slug" => $tempOrder->step2_slug,
                "project_title" => $tempOrder->name,
                "slug" => Str::slug($tempOrder->name),
                "address" => "asd",
                "location" => $tempOrder->location,
                "description" => $tempOrder->description,
                "room_count" => $tempOrder->house_count,
                "city_id" => $tempOrder->city_id,
                "county_id" => $tempOrder->county_id,
                "user_id" => $instUser->parent_id ? $instUser->parent_id : $instUser->id,
                "status_id" => 1,
                "image" => 'public/project_images/' . $newCoverImage,
                'document' => $newDocument,
                "end_date" => $endDate->format('Y-m-d'),
                "status" => 2,
            ]);

            $instUser = User::where("id", Auth::user()->id)->first();
            $project = Project::create([
                "housing_type_id" => $housingType->id,
                "step1_slug" => $tempOrder->step1_slug,
                "step2_slug" => $tempOrder->step2_slug,
                "project_title" => $tempOrder->name,
                "slug" => Str::slug($tempOrder->name),
                "address" => "asd",
                "location" => $tempOrder->location,
                "description" => $tempOrder->description,
                "room_count" => $tempOrder->house_count,
                "city_id" => $tempOrder->city_id,
                "county_id" => $tempOrder->county_id,
                "user_id" => $instUser->parent_id ? $instUser->parent_id : $instUser->id,
                "status_id" => 1,
                "image" => 'public/project_images/' . $newCoverImage,
                'document' => $newDocument,
                "end_date" => $endDate->format('Y-m-d'),
                "status" => 2,
            ]);

            foreach ($tempOrder->statuses as $status) {
                ProjectHousingType::create([
                    "project_id" => $project->id,
                    "housing_type_id" => $status,
                ]);
            }

            foreach ($tempOrder->images as $key => $image) {
                $eskiDosyaAdi = public_path('project_images/' . $image); // Mevcut dosyanın yolu
                $extension = explode('.', $image);
                $newFileName = Str::slug($tempOrder->name) . '-' . ($key + 1) . '.' . end($extension);
                $yeniDosyaAdi = public_path('storage/project_images/' . $newFileName); // Yeni dosya adı ve yolu

                if (File::exists($eskiDosyaAdi)) {
                    if (File::move($eskiDosyaAdi, $yeniDosyaAdi)) {
                        $projectImage = new ProjectImage(); // Eğer model kullanıyorsanız
                        $projectImage->image = 'public/project_images/' . $newFileName;
                        $projectImage->project_id = $project->id;
                        $projectImage->save();
                    }
                }
            }
            $paymentPlanOrder = 0;
            for ($i = 0; $i < $tempOrder->house_count; $i++) {
                for ($j = 0; $j < count($housingTypeInputs); $j++) {
                    if ($housingTypeInputs[$j]->type != "checkbox-group" && $housingTypeInputs[$j]->type != "file") {
                        if ($housingTypeInputs[$j]->name == "installments[]" || $housingTypeInputs[$j]->name == "advance[]" || $housingTypeInputs[$j]->name == "installments-price[]") {
                            if (in_array("taksitli", $tempOrder->roomInfoKeys->{'payment-plan' . ($i + 1)})) {

                                ProjectHousing::create([
                                    "key" => $housingTypeInputs[$j]->label,
                                    "name" => $housingTypeInputs[$j]->name,
                                    "value" => str_replace('.', '', $tempOrder->roomInfoKeys->{substr($housingTypeInputs[$j]->name, 0, -2)}[$paymentPlanOrder]),
                                    "project_id" => $project->id,
                                    "room_order" => $i + 1,
                                ]);
                                if (substr($housingTypeInputs[$j]->name, 0, -2) == "installments-price") {
                                    $paymentPlanOrder++;
                                }
                            }
                        } else {
                            if (str_contains($housingTypeInputs[$j]->className, 'price-only')) {

                                if (isset($housingTypeInputs[$j]->name) && isset($tempOrder->roomInfoKeys->{substr($housingTypeInputs[$j]->name, 0, -2)}) && isset($tempOrder->roomInfoKeys->{substr($housingTypeInputs[$j]->name, 0, -2)}[$i]) && $tempOrder->roomInfoKeys->{substr($housingTypeInputs[$j]->name, 0, -2)}[$i] != null) {
                                    ProjectHousing::create([
                                        "key" => $housingTypeInputs[$j]->label,
                                        "name" => $housingTypeInputs[$j]->name,
                                        "value" => str_replace('.', '', $tempOrder->roomInfoKeys->{substr($housingTypeInputs[$j]->name, 0, -2)}[$i]),
                                        "project_id" => $project->id,
                                        "room_order" => $i + 1,
                                    ]);
                                }
                            } else {
                                if (isset($housingTypeInputs[$j]->name) && isset($tempOrder->roomInfoKeys->{substr($housingTypeInputs[$j]->name, 0, -2)}) && isset($tempOrder->roomInfoKeys->{substr($housingTypeInputs[$j]->name, 0, -2)}[$i]) && $tempOrder->roomInfoKeys->{substr($housingTypeInputs[$j]->name, 0, -2)}[$i] != null) {

                                    ProjectHousing::create([
                                        "key" => $housingTypeInputs[$j]->label,
                                        "name" => $housingTypeInputs[$j]->name,
                                        "value" => $tempOrder->roomInfoKeys->{substr($housingTypeInputs[$j]->name, 0, -2)}[$i],
                                        "project_id" => $project->id,
                                        "room_order" => $i + 1,
                                    ]);
                                }
                            }
                        }
                    } else if ($housingTypeInputs[$j]->type != "file") {

                        ProjectHousing::create([
                            "key" => $housingTypeInputs[$j]->label,
                            "name" => $housingTypeInputs[$j]->name,
                            "value" => isset($tempOrder->roomInfoKeys->{substr($housingTypeInputs[$j]->name, 0, -2) . ($i + 1)}) ? json_encode($tempOrder->roomInfoKeys->{substr($housingTypeInputs[$j]->name, 0, -2) . ($i + 1)}) : json_encode([]),
                            "project_id" => $project->id,
                            "room_order" => $i + 1,
                        ]);

                    } else if ($housingTypeInputs[$j]->type == "file") {
                        if (!$housingTypeInputs[$j]->multiple) {
                            $eskiDosyaAdi = public_path('storage/project_images/' . $tempOrder->roomInfoKeys->image[$i]); // Mevcut dosyanın yolu
                            $extension = explode('.', $tempOrder->roomInfoKeys->image[$i]);
                            $newImageName = str_replace('.' . end($extension), '', $tempOrder->roomInfoKeys->image[$i]);
                            if (substr($newImageName, -1) == $i) {
                                $newFileName = Str::slug($tempOrder->name) . '-project_housing-image-' . ($i) . '.' . end($extension);
                                $yeniDosyaAdi = public_path('project_housing_images/' . $newFileName); // Yeni dosya adı ve yolu
                                if (File::exists($eskiDosyaAdi)) {
                                    File::move($eskiDosyaAdi, $yeniDosyaAdi);
                                }
                            } else {
                                $newFileName = Str::slug($tempOrder->name) . '-project_housing-image-' . (substr($newImageName, -1)) . '.' . end($extension);
                            }

                            ProjectHousing::create([
                                "key" => $housingTypeInputs[$j]->label,
                                "name" => $housingTypeInputs[$j]->name,
                                "value" => $newFileName,
                                "project_id" => $project->id,
                                "room_order" => $i + 1,
                            ]);
                        }
                    }
                }
            }

            if (!$request->without_doping) {
                StandOutUser::create([
                    "user_id" => $instUser->parent_id ? $instUser->parent_id : $instUser->id,
                    "project_id" => $project->id,
                    "item_order" => $tempOrder->doping_order,
                    "housing_status_id" => $tempOrder->doping_statuses,
                    "start_date" => date('Y-m-d', strtotime($tempOrder->doping_start_date)),
                    "end_date" => date('Y-m-d', strtotime($tempOrder->doping_end_date)),
                ]);
            }

            DocumentNotification::create(
                [
                    'user_id' => $instUser->parent_id ? $instUser->parent_id : $instUser->id,
                    'text' => 'Yeni bir proje eklendi. <a href="' . route('project.detail', ['slug' => $project->slug]) . '">Linke git</a>',
                    'item_id' => $project->id,
                    'owner_id' => 4,
                    'is_visible' => true,
                ]
            );

            DB::commit();

            TempOrder::where('user_id', auth()->user()->id)->where('item_type', 1)->delete();
            UserPlan::where('user_id', $instUser->parent_id ? $instUser->parent_id : $instUser->id)->decrement('project_limit');
            dispatch(new AdvertTimeJob($project))->delay(now()->addMonths($month));

            $project = Project::where('id', $project->id)->with("brand", "roomInfo", "housingType", "county", "city", 'user.projects.housings', 'user.brands', 'user.housings', 'images')->firstOrFail();
            $menu = Menu::getMenuItems();
            $project->roomInfo = $project->roomInfo;
            $project->brand = $project->brand;
            $project->housingType = $project->housingType;
            $project->county = $project->county;
            $project->city = $project->city;
            $project->user = $project->user;
            $project->user->housings = $project->user->housings;
            $project->user->brands = $project->user->brands;
            $project->images = $project->images;
            $offer = Offer::where('project_id', $project->id)->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))->first();

            Cache::rememberForever('project_' . $project->slug, function () use ($offer, $project, $menu) {
                return view('client.projects.index', compact('menu', "offer", 'project'))->render();
            });

            return json_encode([
                "status" => true,
            ]);

            DocumentNotification::create(
                [
                    'user_id' => $instUser->parent_id ? $instUser->parent_id : $instUser->id,
                    'text' => 'Yeni bir proje eklendi.',
                    'item_id' => $project->id,
                    'link' => route('admin.projects.detail', ['projectId' => $project->id]),
                    'owner_id' => 4,
                    'is_visible' => true,
                ]
            );

            DB::commit();

            TempOrder::where('user_id', auth()->user()->id)->where('item_type', 1)->delete();
            UserPlan::where('user_id', $instUser->parent_id ? $instUser->parent_id : $instUser->id)->decrement('project_limit');
            dispatch(new AdvertTimeJob($project))->delay(now()->addMonths($month));
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

    public function store(Request $request)
    {
        $request->validate([
            "housing_type" => "required",
            "name" => "required",
            "address" => "required",
            "location" => "required",
            "brand_id" => "required",
            "description" => "required",
            "house_count" => "required",
            "cover_photo" => "required",
            "document" => "required|file|max:2048",
        ]);

        if (UserPlan::where('user_id', auth()->user()->id)->sum('project_limit') <= 0) {
            return redirect()->back()->withErrors(['not_enough_limit' => 'Proje oluşturma hakkınız doldu.']);
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentName = $request->project_title . ' proje belgesi.' . $document->getClientOriginalExtension();

            // Dosyayı public/housing_documents klasörüne taşı
            $document->move(public_path('/housing_documents'), $documentName);
        }

        $housingTypeInputs = HousingType::where('id', $request->input('housing_type'))->first();
        $housingTypeInputs = json_decode($housingTypeInputs->form_json);
        $errors = [];

        for ($i = 0; $i < $request->input('house_count'); $i++) {
            for ($j = 0; $j < count($housingTypeInputs); $j++) {
                if (isset($housingTypeInputs[$j]->name) && $housingTypeInputs[$j]->type != "file" && $housingTypeInputs[$j]->type != "checkbox-group" && $request->input(substr($housingTypeInputs[$j]->name, 0, -2)) && $request->input(substr($housingTypeInputs[$j]->name, 0, -2))[$i] == null && $housingTypeInputs[$j]->required) {
                    array_push($errors, ($i + 1) . " nolu konutun " . $housingTypeInputs[$j]->label . " alanı boş bırakılamaz");
                }
            }
        }

        if ($request->hasFile('cover_photo')) {
            $uploadedFile = $request->file('cover_photo');

            $filePath = $uploadedFile->store('public/project_images');
        }

        if (count($errors) == 0) {
            $project = Project::create([
                "housing_type_id" => $request->input('housing_type'),
                "project_title" => $request->input('name'),
                "slug" => Str::slug($request->input('name')),
                "address" => $request->input('address'),
                "location" => $request->input('location'),
                "brand_id" => $request->input('brand_id'),
                "description" => $request->input('description'),
                "room_count" => $request->input('house_count'),
                "city_id" => $request->input('city_id'),
                "county_id" => $request->input('county_id'),
                "user_id" => auth()->user()->parent_id ?? auth()->user()->id,
                "status_id" => 1,
                "image" => $filePath,
                'document' => $documentName,
                "status" => 2,
            ]);

            UserPlan::where('user_id', auth()->user()->id)->decrement('project_limit');

            foreach ($request->file('project_images') as $image) {
                // Dosyayı uygun bir konuma kaydedin, örneğin "public/project_images" klasörüne
                $path = $image->store('public/project_images');

                // Dosya yolunu veritabanına ekleyin
                $projectImage = new ProjectImage(); // Eğer model kullanıyorsanız
                $projectImage->image = $path;
                $projectImage->project_id = $project->id;
                $projectImage->save();
            }

            for ($i = 0; $i < $request->input('house_count'); $i++) {
                for ($j = 0; $j < count($housingTypeInputs); $j++) {
                    if ($housingTypeInputs[$j]->type == "file") {
                        if ($request->hasFile(substr($housingTypeInputs[$j]->name, 0, -2))) {
                            $images = $request->file(substr($housingTypeInputs[$j]->name, 0, -2));

                            foreach ($images as $key => $image) {
                                if ($image->isValid()) {
                                    $imageName = Str::slug(Str::slug($request->input('name'))) . '-' . ($key + 1) . time() . '.' . $image->getClientOriginalExtension();
                                    $image->move(public_path('/project_housing_images'), $imageName);
                                    ProjectHousing::create([
                                        "key" => $housingTypeInputs[$j]->label,
                                        "name" => $housingTypeInputs[$j]->name,
                                        "value" => $imageName,
                                        "project_id" => $project->id,
                                        "room_order" => $key + 1,
                                    ]);
                                } else {

                                }
                            }
                        }

                        if ($housingTypeInputs[$j]->name == "images[]") {
                            $files = [];
                            for ($k = 0; $k < count($request->file('images' . ($i + 1))); $k++) {
                                $image = $request->file('images' . ($i + 1))[$k][0];
                                $imageName = Str::slug(Str::slug($request->input('name'))) . '-' . ($i) . '-' . $k . '-' . time() . '.' . $image->getClientOriginalExtension();
                                $image->move(public_path('/project_housing_images'), $imageName);
                                array_push($files, $imageName);
                            }

                            ProjectHousing::create([
                                "key" => $housingTypeInputs[$j]->label,
                                "name" => $housingTypeInputs[$j]->name,
                                "value" => json_encode($files),
                                "project_id" => $project->id,
                                "room_order" => $i + 1,
                            ]);
                        }
                    } else {
                        if ($housingTypeInputs[$j]->type != "checkbox-group") {
                            if (isset($housingTypeInputs[$j]->name) && $request->input(substr($housingTypeInputs[$j]->name, 0, -2))[$i] != null) {
                                ProjectHousing::create([
                                    "key" => $housingTypeInputs[$j]->label,
                                    "name" => $housingTypeInputs[$j]->name,
                                    "value" => is_object($request->input(substr($housingTypeInputs[$j]->name, 0, -2))[$i]) || is_array($request->input(substr($housingTypeInputs[$j]->name, 0, -2))[$i]) ? json_encode($request->input(substr($housingTypeInputs[$j]->name, 0, -2))[$i]) : $request->input(substr($housingTypeInputs[$j]->name, 0, -2))[$i],
                                    "project_id" => $project->id,
                                    "room_order" => $i + 1,
                                ]);
                            }
                        } else {
                            ProjectHousing::create([
                                "key" => $housingTypeInputs[$j]->label,
                                "name" => $housingTypeInputs[$j]->name,
                                "value" => is_object($request->input(substr($housingTypeInputs[$j]->name, 0, -2) . ($i + 1))) || is_array($request->input(substr($housingTypeInputs[$j]->name, 0, -2) . ($i + 1))) ? json_encode($request->input(substr($housingTypeInputs[$j]->name, 0, -2) . ($i + 1))) : '',
                                "project_id" => $project->id,
                                "room_order" => $i + 1,
                            ]);
                        }

                    }
                }
            }
        }

        DocumentNotification::create(
            [
                'user_id' => auth()->user()->id,
                'text' => 'Yeni bir proje eklendi.',
                'item_id' => $project->id,
                'link' => route('admin.projects.detail', ['projectId' => $project->id]),
                'owner_id' => 4,
                'is_visible' => true,
            ]
        );

        return redirect()->route('institutional.projects.index', ["status" => "new_project"]);
    }

    public function getCounties(Request $request)
    {
        $counties = District::where('ilce_sehirkey', $request->input('city'))->get();

        return $counties;
    }

    public function getNeighbourhood(Request $request)
    {
        $counties = Neighborhood::where('mahalle_ilcekey', $request->input('county_id'))->get();

        return $counties;
    }

    public function standOut($projectId)
    {
        $project = Project::where('id', $projectId)->first();

        return view('institutional.projects.stand_out', compact('project'));
    }

    public function pricingList(Request $request)
    {
        $pricingStandOuts = PricingStandOut::where('housing_status_id', $request->input('housing_status_id'))->where('type', $request->input('type'))->get();

        return json_encode([
            "status" => true,
            "data" => $pricingStandOuts,
        ]);
    }

    public function edit($id)
    {
        $project = Project::with("roomInfo")->where('id', $id)->first();
        $project->housingStatusesFull = $project->housingStatus->keyBy('housing_type_id')->toArray();
        $results = ProjectHousing::
            select(DB::raw('max(name) as name , max(value) as value, max(room_order) as room_order'))
            ->where('project_id', $id)
            ->groupBy('room_order', 'name')
            ->orderBy('room_order')
            ->get();

        $groupedData = [];
        foreach ($results as $key => $result) {
            $groupedData[str_replace("[]", "", $result['name'])][$result->room_order - 1] = $result->value;
        }

        $project->roomInfoKeys = $groupedData;

        $brands = Brand::where('user_id', Auth::user()->id)->where('status', 1)->get();
        $housing_types = HousingType::all();
        $housing_status = HousingStatus::all();
        $cities = City::get();
        $counties = County::where('city_id', $project->city_id)->get();
        return view('institutional.projects.edit', compact('project', 'housing_types', 'housing_status', 'brands', 'cities', 'counties'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "housing_type" => "required",
            "name" => "required",
            "address" => "required",
            "location" => "required",
            "brand_id" => "required",
            "description" => "required",
            "house_count" => "required",
        ]);

        $housingTypeInputs = HousingType::where('id', $request->input('housing_type'))->first();
        $housingTypeInputs = json_decode($housingTypeInputs->form_json);
        $errors = [];

        for ($i = 0; $i < $request->input('house_count'); $i++) {
            for ($j = 0; $j < count($housingTypeInputs); $j++) {
                if (isset($housingTypeInputs[$j]->name) && $housingTypeInputs[$j]->type != "file" && $housingTypeInputs[$j]->type != "checkbox-group" && $request->input(substr($housingTypeInputs[$j]->name, 0, -2)) && $request->input(substr($housingTypeInputs[$j]->name, 0, -2))[$i] == null && $housingTypeInputs[$j]->required) {
                    array_push($errors, ($i + 1) . " nolu konutun " . $housingTypeInputs[$j]->label . " alanı boş bırakılamaz");
                }
            }
        }

        $project = Project::where('id', $id)->first();
        if ($request->hasFile('cover_photo')) {
            $uploadedFile = $request->file('cover_photo');

            $filePath = $uploadedFile->store('public/project_images');
        } else {
            $filePath = $project->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentName = $request->project_title . ' proje belgesi.' . $document->getClientOriginalExtension();

            // Dosyayı public/housing_documents klasörüne taşı
            $document->move(public_path('/housing_documents'), $documentName);
        } else {
            $documentName = $project->document;
        }

        if (count($errors) == 0) {
            $projectNew = Project::where('id', $id)->update([
                "housing_type_id" => $request->input('housing_type'),
                "project_title" => $request->input('name'),
                "slug" => Str::slug($request->input('name')),
                "address" => $request->input('address'),
                "location" => $request->input('location'),
                "brand_id" => $request->input('brand_id'),
                "description" => $request->input('description'),
                "room_count" => $request->input('house_count'),
                "city_id" => $request->input('city_id'),
                "county_id" => $request->input('county_id') ?? $project->id,
                "status_id" => 1,
                "image" => $filePath,
                'document' => $documentName,
            ]);

            ProjectHousingType::where('project_id', $id)->delete();

            foreach ($request->input('housing_status') as $housingStatus) {
                ProjectHousingType::create([
                    "project_id" => $id,
                    "housing_type_id" => $housingStatus,
                ]);
            }

            $project = Project::where('id', $id)->first();
            if ($request->file('image')) {

                ProjectHousing::where('project_id', $id)->where('name', '!=', 'images[]')->delete();
            } else {
                ProjectHousing::where('project_id', $id)->where('name', '!=', 'images[]')->where('name', '!=', 'image[]')->delete();
            }
            for ($i = 0; $i < $request->input('house_count'); $i++) {
                for ($j = 0; $j < count($housingTypeInputs); $j++) {
                    if ($housingTypeInputs[$j]->type == "file") {
                        if ($request->hasFile(substr($housingTypeInputs[$j]->name, 0, -2))) {
                            $images = $request->file(substr($housingTypeInputs[$j]->name, 0, -2));

                            foreach ($images as $key => $image) {
                                if ($image->isValid()) {
                                    $imageName = Str::slug(Str::slug($request->input('name'))) . '-' . ($key + 1) . time() . '.' . $image->getClientOriginalExtension();
                                    $image->move(public_path('/project_housing_images'), $imageName);
                                    ProjectHousing::create([
                                        "key" => $housingTypeInputs[$j]->label,
                                        "name" => $housingTypeInputs[$j]->name,
                                        "value" => $imageName,
                                        "project_id" => $project->id,
                                        "room_order" => $key + 1,
                                    ]);
                                } else {

                                }
                            }
                        }
                    } else {
                        if ($housingTypeInputs[$j]->type != "checkbox-group") {
                            if (isset($housingTypeInputs[$j]->name) && $request->input(substr($housingTypeInputs[$j]->name, 0, -2))[$i] != null) {
                                ProjectHousing::create([
                                    "key" => $housingTypeInputs[$j]->label,
                                    "name" => $housingTypeInputs[$j]->name,
                                    "value" => is_object($request->input(substr($housingTypeInputs[$j]->name, 0, -2))[$i]) || is_array($request->input(substr($housingTypeInputs[$j]->name, 0, -2))[$i]) ? json_encode($request->input(substr($housingTypeInputs[$j]->name, 0, -2))[$i]) : $request->input(substr($housingTypeInputs[$j]->name, 0, -2))[$i],
                                    "project_id" => $project->id,
                                    "room_order" => $i + 1,
                                ]);
                            }
                        } else {
                            ProjectHousing::create([
                                "key" => $housingTypeInputs[$j]->label,
                                "name" => $housingTypeInputs[$j]->name,
                                "value" => is_object($request->input(substr($housingTypeInputs[$j]->name, 0, -2) . ($i + 1))) || is_array($request->input(substr($housingTypeInputs[$j]->name, 0, -2) . ($i + 1))) ? json_encode($request->input(substr($housingTypeInputs[$j]->name, 0, -2) . ($i + 1))) : '',
                                "project_id" => $project->id,
                                "room_order" => $i + 1,
                            ]);
                        }

                    }
                }
            }
        }

        return redirect()->route('institutional.projects.index', ["status" => "new_project"]);
    }

    public function destroy($id)
    {
        // Silinecek markayı bulun
        $project = Project::findOrFail($id);

        // Markayı veritabanından sil
        $project->delete();

        return redirect()->route('institutional.projects.index')->with('success', 'Proje başarıyla silindi.');
    }

    public function newProjectImage(Request $request, $projectId)
    {
        if ($request->hasFile('file')) {
            $uploadedFile = $request->file('file');

            $filePath = $uploadedFile->store('public/project_images');
        }

        ProjectImage::create([
            "image" => $filePath,
            "project_id" => $projectId,
        ]);

        return json_encode([
            "status" => true,
        ]);
    }

    public function deleteProjectImage($projectId, $filename)
    {
        $fileId = explode('--', $filename);

        ProjectImage::where('id', $fileId[1])->delete();
        return json_encode([
            "status" => true,
        ]);
    }

    public function removeProjectHousingFile(Request $request)
    {
        $projectHousing = ProjectHousing::where('project_id', $request->input('projectId'))->where('room_order', $request->input('housingOrder'))->where('name', 'images[]')->first();

        $projectHousingImagesTemp = [];

        $projectHousingImages = json_decode($projectHousing->value);

        foreach ($projectHousingImages as $key => $image) {
            if ($key != $request->input('order')) {
                array_push($projectHousingImagesTemp, $image);
            }
        }

        ProjectHousing::where('project_id', $request->input('projectId'))->where('room_order', $request->input('housingOrder'))->where('name', 'images[]')->update(["value" => json_encode($projectHousingImagesTemp)]);

        return json_encode([
            "status" => true,
        ]);
    }

    public function addProjectHousingFile(Request $request)
    {
        $project = Project::where('id', $request->input('projectId'))->first();
        $projectHousing = ProjectHousing::where('project_id', $request->input('projectId'))->where('room_order', $request->input('housingOrder'))->where('name', 'images[]')->first();
        if ($projectHousing->value) {

            $projectHousingImages = json_decode($projectHousing->value);
        } else {
            $projectHousingImages = [];
        }

        $image = $request->file('file');
        $imageName = $project->slug . '-' . ($request->input('housingOrder')) . '-' . time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('/project_housing_images'), $imageName);

        array_push($projectHousingImages, $imageName);

        ProjectHousing::where('project_id', $request->input('projectId'))->where('room_order', $request->input('housingOrder'))->where('name', 'images[]')->update(["value" => json_encode($projectHousingImages)]);

        $projectHousing = ProjectHousing::where('project_id', $request->input('projectId'))->where('room_order', $request->input('housingOrder'))->where('name', 'images[]')->first();
        return json_encode([
            "status" => true,
            "imageName" => $imageName,
        ]);
    }

    public function logs($projectId)
    {
        $logs = Log::where('item_type', 1)->where('item_id', $projectId)->orderByDesc('created_at')->get();
        return view('institutional.projects.logs', compact('logs'));
    }

    public function updateProjectEnd()
    {
        $tempOrder = TempOrder::where('item_type', 3)->where('user_id', auth()->guard()->user()->id)->first();
        $tempData = json_decode($tempOrder->data);

        Project::where('id', $tempData->id)->update([
            "project_title" => $tempData->project_title,
            "slug" => Str::slug($tempData->project_title),
            "description" => $tempData->description,
            "location" => $tempData->location,
            "image" => $tempData->image,
            "city_id" => $tempData->city_id,
            "county_id" => $tempData->county_id,
            "status" => "2",
        ]);

        ProjectImage::where('project_id', $tempData->id)->delete();
        foreach ($tempData->images as $key => $image) {
            $projectImage = new ProjectImage(); // Eğer model kullanıyorsanız
            $projectImage->image = $image->image;
            $projectImage->project_id = $tempData->id;
            $projectImage->save();
        }

        foreach ($tempData->roomInfoKeys as $roomInfo) {
            if (isset($roomInfo->new_value) && $roomInfo->new_value == 1) {
                if ($roomInfo->name == "price[]" || $roomInfo->name == "installments-price[]" || $roomInfo->name == "installments[]") {
                    ProjectHousing::create([
                        "key" => $roomInfo->key,
                        "name" => $roomInfo->name,
                        "value" => str_replace('.', '', $roomInfo->value),
                        "project_id" => $tempData->id,
                        "room_order" => $roomInfo->room_order,
                    ]);
                } else {
                    ProjectHousing::create([
                        "key" => $roomInfo->key,
                        "name" => $roomInfo->name,
                        "value" => $roomInfo->value,
                        "project_id" => $tempData->id,
                        "room_order" => $roomInfo->room_order,
                    ]);
                }

            } else {
                ProjectHousing::where('name', $roomInfo->name)->where('project_id', $tempData->id)->where('room_order', $roomInfo->room_order)->update([
                    "value" => $roomInfo->value,
                ]);
            }

        }

        $tempOrder->delete();

        return json_encode([
            "status" => true,
        ]);
    }
}
