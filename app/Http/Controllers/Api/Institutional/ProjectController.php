<?php

namespace App\Http\Controllers\Api\Institutional;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\Block;
use App\Models\CartOrder;
use App\Models\City;
use App\Models\District;
use App\Models\DocumentNotification;
use App\Models\Housing;
use App\Models\HousingStatus;
use App\Models\HousingStatusConnection;
use App\Models\HousingType;
use App\Models\HousingTypeParent;
use App\Models\HousingTypeParentConnection;
use App\Models\Installment;
use App\Models\Institution;
use App\Models\Invoice;
use App\Models\Neighborhood;
use App\Models\Offer;
use App\Models\PaymentSetting;
use App\Models\Project;
use App\Models\ProjectHouseSetting;
use App\Models\ProjectHousing;
use App\Models\ProjectHousingType;
use App\Models\ProjectImage;
use App\Models\ProjectSituation;
use App\Models\Rate;
use App\Models\ShareLink;
use App\Models\TempOrder;
use App\Models\Town;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Throwable;
use App\Services\SmsService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\URL;

class ProjectController extends Controller
{

    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }


    protected function getProjectCounts($userProjectIds, $status)
    {
        return CartOrder::selectRaw('COUNT(*) as count, JSON_UNQUOTE(json_extract(cart, "$.item.id")) as project_id, MAX(status) as status')
            ->whereIn(DB::raw('JSON_UNQUOTE(json_extract(cart, "$.item.id"))'), $userProjectIds)
            ->groupBy('project_id')
            ->where('status', $status)
            ->get();
    }


    protected function mapProjectCounts($projects, $counts, $propertyName)
    {
        return $projects->map(function ($project) use ($counts, $propertyName) {
            $project->$propertyName = $counts->where('project_id', $project->id)->first()->count ?? 0;

            if ($propertyName == 'cartOrders') {
                $totalAmount = CartOrder::where(DB::raw('JSON_UNQUOTE(json_extract(cart, "$.item.id"))'), $project->id)
                    ->where("status", "1")->sum("amount");

                $project->totalAmount = number_format($totalAmount, 3, '.', '');
            }

            return $project;
        });
    }

    public function index(Request $request)
    {
        $userId = auth()->user()->parent_id ?? auth()->user()->id;
        $fullProjectsCount = Project::where('user_id', $userId)->where('status', $request->input('status'))->count();

        $projects = Project::select(DB::raw('*, (select count(*) from project_housings WHERE name = "off_sale[]" AND value != "[]" AND project_id = projects.id) as offSale'))->where('user_id', $userId)
            ->with("housingType", "county", "city", "neighbourhood", "standOut", "standOut.dopingPricePaymentWait", 'standOut.dopingPricePaymentCancel','user')
            ->orderByDesc('created_at')
            ->where('status', $request->input('status'))
            ->take($request->input('take'))
            ->skip($request->input('start'))
            ->get();

        $userProjectIds = $projects->pluck('id');

        $projectCounts = $this->getProjectCounts($userProjectIds, '1');
        $paymentPendingCounts = $this->getProjectCounts($userProjectIds, '0');


        $projects = $this->mapProjectCounts($projects, $projectCounts, 'cartOrders');
        $projects = $this->mapProjectCounts($projects, $paymentPendingCounts, 'paymentPending');

        return json_encode([
            "data" => $projects,
            "total_projects_count" => $fullProjectsCount
        ]);
    }

    public function getHousingStatuses(Request $request)
    {
        $housingStatuses = HousingStatus::where('is_project', 1)->get();

        return json_encode([
            "data" => $housingStatuses
        ]);
    }

    public function getHousingTypes(Request $request)
    {
        if ($request->input('parent_id')) {
            $housingTypes = HousingTypeParent::where('parent_id', $request->input('parent_id'))->get();
        } else {
            $housingTypes = HousingTypeParent::whereNull('parent_id')->get();
        }

        return json_encode([
            "data" => $housingTypes
        ]);
    }

    public function getHousingTypesEnd(Request $request)
    {
        $housingTypes = HousingTypeParentConnection::with("housingType")->where('parent_id', $request->input('parent_id'))->get();

        return json_encode([
            "data" => $housingTypes
        ]);
    }

    public function getCities()
    {
        $cities = City::get();

        return json_encode([
            "data" => $cities
        ]);
    }

    public function getCounties(Request $request)
    {
        $counties = District::where('ilce_sehirkey', $request->input('city_id'))->get();

        return json_encode([
            "data" => $counties
        ]);
    }

    public function getNeighborhoods(Request $request)
    {
        $neighborhoods = Neighborhood::where('mahalle_ilcekey', $request->input('county_id'))->get();

        return json_encode([
            "data" => $neighborhoods
        ]);
    }

    public function createProject(Request $request)
    {
        $housingTypeParentConnection = HousingTypeParentConnection::where('id', $request->input('selectedTypes')[count($request->input('selectedTypes')) - 1])->first();
        $housingTypeInputs = json_decode($housingTypeParentConnection->housingType->form_json);

        $roomValidations = [];
        $roomValidationsMessages = [];

        foreach ($housingTypeInputs as $input) {
            if (!str_contains($input->className, 'project-disabled')) {
                if ($input->required) {
                    $roomValidations["blocks.*.rooms.*." . str_replace('[]', '', $input->name)] = "required";
                    $roomValidationsMessages["blocks.*.rooms.*." . str_replace('[]', '', $input->name) . '.required'] = ":position nolu bloğun :second-position nolu konutunda " . $input->label . " alanı girilmelidir.";
                }
            }
        }

        $manager = new ImageManager(
            new Driver()
        );

        // $request->validate([
        //     "selectedTypes.0" => "required",
        //     "selectedTypes.1" => "required",
        //     "selectedTypes.2" => "required",
        //     "selectedTypes.3" => "required",
        //     "projectData.project_title" => "required",
        //     "projectData.create_company" => "nullable",
        //     "projectData.coordinates" => "required",
        //     "projectData.description" => "required",
        //     "projectData.city_id" => "required|integer",
        //     "projectData.county_id" => "required",
        //     "projectData.neighbourhood_id" => "required",
        //     "projectData.cover_image" => "required",
        //     "projectData.gallery" => "required|array",
        //     "projectData.situations" => "required|array",
        //     "blocks.*.name" => "required",
        //     "blocks.*.roomCount" => "required",
        // ],[
        //     "projectData.housing_type_id.required" => "Konut tipi seçmediniz",
        //     "projectData.project_title.required" => "Proje adı alanı zorunludur",
        //     "projectData.description.required" => "Proje açıklaması alanı zorunludur",
        //     "projectData.coordinates.required" => "Harita üzerinde konum seçmek zorunludur",
        //     "projectData.city_id.required" => "Şehir seçmediniz",
        //     "projectData.county_id.required" => "İlçe seçmediniz",
        //     "projectData.neighbourhood_id.required" => "Mahalle seçmediniz",
        //     "projectData.cover_image.required" => "Proje kapak fotoğrafı seçmediniz",
        //     "projectData.gallery.required" => "Proje galeri fotoğraflarını seçmediniz",
        //     "projectData.gallery.array" => "Proje galeri fotoğrafları dizi olmalıdır",
        //     "projectData.situations.required" => "Proje vaziyet & kat planı fotoğraflarını seçmediniz",
        //     "projectData.situations.array" => "Proje vaziyet & kat planı fotoğrafları dizi olmalıdır",
        //     ...$roomValidationsMessages
        // ]);

        $housingTypeParent1 = HousingTypeParent::where('id', $request->input('selectedTypes')[1])->firstOrFail();
        $housingTypeParent2 = HousingTypeParent::where('id', $request->input('selectedTypes')[2])->firstOrFail();
        $instUser = User::where("id", Auth::user()->id)->first();
        $endDate = Carbon::now();
        $projectSlug = Str::slug($request->input('projectData')['project_title']);
        if ($request->file('projectData')['cover_image']) {

            $file = $request->file('projectData')['cover_image'];

            // Dosyanın hedef dizini
            $destinationPath = public_path('storage/project_images'); // Örnek olarak 'uploads' klasörü altına kaydedilecek

            // Dosyayı belirlenen hedefe taşı
            $fileNameCoverImage = $projectSlug . '_cover_image_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileNameCoverImage);

            $image = $manager->read(public_path('storage/project_images/' . $fileNameCoverImage));
            $imageWidth = $image->width();
            $imageHeight = $image->height();

            if ($imageWidth > 1200) {
                $newWidth = 1200;
                $newHeight = $imageHeight * 1200 / $imageWidth;
            } else {
                $newWidth = $imageWidth;
                $newHeight = $imageHeight;
            }
            $image2 = $manager->read(public_path('images/filigran2.png'));
            $imageWidth2 = $image2->width();
            $imageHeight2 = $image2->height();
            $image2->resize($newWidth / 10 * 7, (($newWidth * $imageHeight2 / $imageWidth2) / 10) * 7);
            $image2->rotate(30, '#00000000');
            $image->resize($newWidth, $newHeight);
            $encoded = $image->place($image2, 'center', 10, 10, 20);
            $encoded->save(public_path('storage/project_images/' . $fileNameCoverImage));
        }



        $totalCount = $request->input('totalRoomCount');

        if ($request->file('projectData')['document']) {
            $file = $request->file('projectData')['document'];

            $destinationPath = public_path('housing_documents');

            $fileNameDocument = $projectSlug . '_document_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileNameDocument);
        }

        $housingTypeParentConnection = HousingTypeParentConnection::where('id', $request->input('selectedTypes')[count($request->input('selectedTypes')) - 1])->first();
        $housingTypeInputs = json_decode($housingTypeParentConnection->housingType->form_json);

        $project = Project::create([
            "housing_type_id" => $housingTypeParentConnection->housing_type_id,
            "step1_slug" => $housingTypeParent1->slug,
            "step2_slug" => $housingTypeParent2->slug,
            "project_title" => $request->input('projectData')['project_title'],
            "create_company" => $request->input('projectData')['create_company']  ?? null,
            "total_project_area" => $request->input('projectData')['total_project_area']  ?? null,
            "start_date" => $request->input('projectData')['start_date']  ?? null,
            "project_end_date" => $request->input('projectData')['end_date']  ?? null,
            "island" => $request->input('projectData')['island']  ?? null,
            "parcel" => $request->input('projectData')['parcel']  ?? null,
            "slug" => Str::slug($request->input('projectData')['project_title']),
            "address" => "asd",
            "location" => str_replace('-', ',', $request->input('projectData')['coordinates']),
            "description" => $request->input('projectData')['description'],
            "room_count" => $totalCount,
            "city_id" => $request->input('projectData')['city_id'],
            "county_id" => $request->input('projectData')['county_id'],
            "neighbourhood_id" => $request->input('projectData')['neighbourhood_id'],
            "user_id" => $instUser->parent_id ? $instUser->parent_id : $instUser->id,
            "status_id" => 1,
            "image" => 'public/project_images/' . $fileNameCoverImage,
            'document' => $fileNameDocument,
            "end_date" => $endDate->format('Y-m-d'),
            "status" => 2,
            "have_blocks" => $request->input('haveBlocks') == "true"
        ]);

        foreach ($request->file('projectData')['gallery'] as $key => $image) {
            $newFileName = $projectSlug . '-gallery-' . ($key + 1) . time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('storage/project_images'); // Yeni dosya adı ve yolu


            if ($image->move($destinationPath, $newFileName)) {

                $imageMg = $manager->read(public_path('storage/project_images/' . $newFileName));
                $imageWidth = $imageMg->width();
                $imageHeight = $imageMg->height();

                if ($imageWidth > 1200) {
                    $newWidth = 1200;
                    $newHeight = $imageHeight * 1200 / $imageWidth;
                } else {

                    $newWidth = $imageWidth;
                    $newHeight = $imageHeight;
                }
                $imageMg->resize($newWidth, $newHeight);
                $encoded = $imageMg->place(public_path('images/filigran2.png'), 'center', 10, 10, 50, 45);
                $encoded->save(public_path('storage/project_images/' . $newFileName));

                $projectImage = new ProjectImage(); // Eğer model kullanıyorsanız
                $projectImage->image = 'public/project_images/' . $newFileName;
                $projectImage->project_id = $project->id;
                $projectImage->save();
            }
        }

        foreach ($request->file('projectData')['situations'] as $key => $situation) {
            $newFileName = $projectSlug . '-situation-' . ($key + 1) . time() . '.' . $situation->getClientOriginalExtension();
            $yeniDosyaAdi = public_path('situation_images'); // Yeni dosya adı ve yolu

            if ($situation->move($yeniDosyaAdi, $newFileName)) {
                $imageMg = $manager->read(public_path('situation_images/' . $newFileName));
                $imageWidth = $imageMg->width();
                $imageHeight = $imageMg->height();

                if ($imageWidth > 1200) {
                    $newWidth = 1200;
                    $newHeight = $imageHeight * 1200 / $imageWidth;
                } else {

                    $newWidth = $imageWidth;
                    $newHeight = $imageHeight;
                }
                $imageMg->resize($newWidth, $newHeight);
                $encoded = $imageMg->place(public_path('images/filigran2.png'), 'center', 10, 10, 50, 45);
                $encoded->save(public_path('situation_images/' . $newFileName));

                $projectImage = new ProjectSituation(); // Eğer model kullanıyorsanız
                $projectImage->situation = 'public/situation_images/' . $newFileName;
                $projectImage->project_id = $project->id;
                $projectImage->save();
            }
        }



        ProjectHousingType::create([
            "project_id" => $project->id,
            "housing_type_id" => $request->input('selectedTypes')[0],
        ]);

        if ($request->input('haveBlocks') && $request->input('haveBlocks') == "true") {
            foreach ($request->input('blocks') as $key => $block) {
                Block::create([
                    "project_id" => $project->id,
                    "block_name" => $block['name'],
                    "housing_count" => $block['roomCount']
                ]);
            }
        }
        $statusID = $project->housingStatus->where('housing_type_id', '<>', 1)->first()->housing_type_id ?? 1;
        $status = HousingStatus::find($statusID);

        $defaultProjectStatus = HousingStatus::where('is_project', 1)->where('is_default', 1)->first();
        $selectedProjectStatus = HousingStatus::where('id', $request->input('selectedTypes')[0])->first();

        ProjectHousingType::create([
            'housing_type_id' => $defaultProjectStatus->id,
            'project_id' => $project->id
        ]);

        ProjectHousingType::create([
            'housing_type_id' => $selectedProjectStatus->id,
            'project_id' => $project->id
        ]);

        $notificationLink =  route('project.detail', ['slug' => $project->slug . "-" . $status->slug . "-" . $project->step2_slug . "-" . $project->housingtype->slug, 'id' => $project->id]);
        $notificationText = 'Proje #' . $project->id . ' şu anda admin onayına gönderildi. Onaylandığı takdirde yayına alınacaktır.';
        DocumentNotification::create([
            'user_id' => $instUser->parent_id ? $instUser->parent_id : $instUser->id,
            'text' => $notificationText,
            'item_id' => $project->id,
            'link' => $notificationLink,
            'owner_id' => 4,
            'is_visible' => true,
        ]);

        return json_encode([
            "status" => true,
            "project" => $project
        ]);
    }

    public function createRoom(Request $request)
    {
        $manager = new ImageManager(
            new Driver()
        );

        $project = Project::where('id', $request->input('project_id'))->first();
        $housingType = HousingType::where('id', $project->housing_type_id)->first();
        $housingTypeInputs = json_decode($housingType->form_json);

        $housingTemp = $request->input('room_order');
        $room = $request->input('room');
        $paymentPlanOrder = 0;

        $projectHousings = [];

        for ($j = 0; $j < count($housingTypeInputs); $j++) {
            if ($housingTypeInputs[$j]->type != "checkbox-group" && $housingTypeInputs[$j]->type != "file") {
                if ($housingTypeInputs[$j]->name == "installments[]" || $housingTypeInputs[$j]->name == "advance[]" || $housingTypeInputs[$j]->name == "installments-price[]") {
                    if (isset($room['payment-plan']) &&  $room['payment-plan']) {
                        if (str_contains($room['payment-plan'], 'taksitli')) {
                            $projectHousings[] = [
                                "key" => $housingTypeInputs[$j]->label,
                                "name" => $housingTypeInputs[$j]->name,
                                "value" => str_replace('.', '', $room[substr($housingTypeInputs[$j]->name, 0, -2)]),
                                "project_id" => $project->id,
                                "room_order" => $housingTemp,
                            ];
                            if (substr($housingTypeInputs[$j]->name, 0, -2) == "installments-price") {
                                $paymentPlanOrder++;
                            }
                        }
                    }
                } else {
                    if (str_contains($housingTypeInputs[$j]->className, 'price-only')) {
                        if (isset($housingTypeInputs[$j]->name) && isset($room[substr($housingTypeInputs[$j]->name, 0, -2)]) && $room[substr($housingTypeInputs[$j]->name, 0, -2)] != null) {
                            $projectHousings[] = [
                                "key" => $housingTypeInputs[$j]->label,
                                "name" => $housingTypeInputs[$j]->name,
                                "value" => str_replace('.', '', $room[substr($housingTypeInputs[$j]->name, 0, -2)]),
                                "project_id" => $project->id,
                                "room_order" => $housingTemp,
                            ];
                        }
                    } else {
                        if (isset($housingTypeInputs[$j]->name) && isset($room[substr($housingTypeInputs[$j]->name, 0, -2)]) && $room[substr($housingTypeInputs[$j]->name, 0, -2)] != null) {
                            $projectHousings[] = [
                                "key" => $housingTypeInputs[$j]->label,
                                "name" => $housingTypeInputs[$j]->name,
                                "value" => $room[substr($housingTypeInputs[$j]->name, 0, -2)],
                                "project_id" => $project->id,
                                "room_order" => $housingTemp,
                            ];
                        }
                    }
                }
            } else if ($housingTypeInputs[$j]->type != "file") {
                $projectHousings[] = [
                    "key" => $housingTypeInputs[$j]->label,
                    "name" => $housingTypeInputs[$j]->name,
                    "value" => isset($room[substr($housingTypeInputs[$j]->name, 0, -2)]) ? json_encode(explode(',', $room[substr($housingTypeInputs[$j]->name, 0, -2)])) : json_encode([]),
                    "project_id" => $project->id,
                    "room_order" => $housingTemp,
                ];
            } else if ($housingTypeInputs[$j]->type == "file") {
                if (!$housingTypeInputs[$j]->multiple) {
                    $imageRoom = $request->file('room')['image'];
                    if ($imageRoom) {
                        $newFileName = $project->slug . '-project-housing-image-' . ($housingTemp) . '.' . $imageRoom->getClientOriginalExtension();
                        $yeniDosyaAdi = public_path('project_housing_images'); // Yeni dosya adı ve yolu
                        if ($imageRoom->move($yeniDosyaAdi, $newFileName)) {

                            $imageMg = $manager->read(public_path('project_housing_images/' . $newFileName));
                            $imageWidth = $imageMg->width();
                            $imageHeight = $imageMg->height();

                            if ($imageWidth > 1200) {
                                $newWidth = 1200;
                                $newHeight = $imageHeight * 1200 / $imageWidth;
                            } else {

                                $newWidth = $imageWidth;
                                $newHeight = $imageHeight;
                            }
                            $imageMg->resize($newWidth, $newHeight);
                            $encoded = $imageMg->place(public_path('images/filigran2.png'), 'center', 10, 10, 50, 45);
                            $encoded->save(public_path('project_housing_images/' . $newFileName));
                            $projectHousings[] = [
                                "key" => $housingTypeInputs[$j]->label,
                                "name" => $housingTypeInputs[$j]->name,
                                "value" => $newFileName,
                                "project_id" => $project->id,
                                "room_order" => $housingTemp,
                            ];
                        }
                    }
                }
            }
        }

        ProjectHousing::insert($projectHousings);
        ProjectHousing::create([
            "key" => "pay-dec-count" . ($housingTemp),
            "name" => "pay-dec-count" . ($housingTemp),
            "value" => isset($room["payDecs"]) && $room["payDecs"] ? count($room["payDecs"]) : 0,
            "project_id" => $project->id,
            "room_order" => $housingTemp,
        ]);

        if (isset($room["payDecs"]) && $room["payDecs"]) {
            for ($j = 0; $j < count($room["payDecs"]); $j++) {
                if (isset($room["payDecs"][$j]["price"])) {
                    ProjectHousing::create([
                        "key" => "pay_desc_price" . ($housingTemp) . $j,
                        "name" => "pay_desc_price" . ($housingTemp) . $j,
                        "value" => str_replace('.', '', $room["payDecs"][$j]["price"]),
                        "project_id" => $project->id,
                        "room_order" => $housingTemp,
                    ]);
                }

                if (isset($room["payDecs"][$j]["date"])) {
                    ProjectHousing::create([
                        "key" => "pay_desc_date" . ($housingTemp) . $j,
                        "name" => "pay_desc_date" . ($housingTemp) . $j,
                        "value" => $room["payDecs"][$j]["date"],
                        "project_id" => $project->id,
                        "room_order" => $housingTemp,
                    ]);
                }
            }
        }

        return json_encode([
            "room_order" => $request->input('room_order')
        ]);
    }

    public function show($id)
    {
        $project = Project::with("images", "situations")->where('id', $id)->first();

        return json_encode([
            "data" => $project
        ]);
    }

    public function updateProject($id, Request $request)
    {
        $project = Project::where('id', $id)->first();

        $manager = new ImageManager(
            new Driver()
        );

        $projectData = $request->input('projectData');
        $location = explode('-', $projectData['coordinates']);

        if (isset($request->file('projectData')['cover_image']) && $request->file('projectData')['cover_image']) {
            $file = $request->file('projectData')['cover_image'];

            // Dosyanın hedef dizini
            $destinationPath = public_path('storage/project_images'); // Örnek olarak 'uploads' klasörü altına kaydedilecek

            // Dosyayı belirlenen hedefe taşı
            $fileNameCoverImage = Str::slug($projectData['project_title']) . '_cover_image_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileNameCoverImage);

            $image = $manager->read(public_path('storage/project_images/' . $fileNameCoverImage));
            $imageWidth = $image->width();
            $imageHeight = $image->height();

            if ($imageWidth > 1200) {
                $newWidth = 1200;
                $newHeight = $imageHeight * 1200 / $imageWidth;
            } else {

                $newWidth = $imageWidth;
                $newHeight = $imageHeight;
            }
            $image2 = $manager->read(public_path('images/filigran2.png'));
            $imageWidth2 = $image2->width();
            $imageHeight2 = $image2->height();
            $image2->resize($newWidth / 10 * 7, (($newWidth * $imageHeight2 / $imageWidth2) / 10) * 7);
            $image2->rotate(30, '#00000000');
            $image->resize($newWidth, $newHeight);
            $encoded = $image->place($image2, 'center', 10, 10, 20);
            $encoded->save(public_path('storage/project_images/' . $fileNameCoverImage));

            $fileDb = 'public/project_images/' . $fileNameCoverImage;
        } else {
            $fileDb = $project->image;
        }

        Project::where('id', $id)->update([
            "project_title" => $projectData['project_title'],
            "slug" => Str::slug($projectData['project_title']),
            "description" => $projectData['description'],
            "create_company" => $projectData['create_company'],
            "total_project_area" => $projectData['total_project_area'],
            "start_date" => $projectData['start_date'],
            "project_end_date" => $projectData['end_date'],
            "island" => $request->input('projectData')['island']  ?? null,
            "parcel" => $request->input('projectData')['parcel']  ?? null,
            "city_id" => $projectData['city_id'],
            "county_id" => $projectData['county_id'],
            "neighbourhood_id" => $projectData['neighbourhood_id'],
            "location" => $location[0] . ',' . $location[1],
            "image" => $fileDb,
            "status" => "2",
        ]);

        $imageOrderx = 0;
        if (isset($request->deleted_images) && $request->deleted_images) {
            foreach (explode(',', $request->deleted_images) as $key => $imageOrder) {
                $projectImageToDelete = ProjectImage::where('project_id', $project->id)
                    ->offset($imageOrder - $imageOrderx)
                    ->take(1)
                    ->first();

                if ($projectImageToDelete) {
                    $projectImageToDelete->delete();
                }

                $imageOrderx++;
            }
        }

        $imageOrderx = 0;
        if (isset($request->deleted_situations) && $request->deleted_situations) {
            foreach (explode(',', $request->deleted_situations) as $key => $imageOrder) {
                $projectImageToDelete = ProjectSituation::where('project_id', $project->id)
                    ->offset($imageOrder - $imageOrderx)
                    ->take(1)
                    ->first();

                if ($projectImageToDelete) {
                    $projectImageToDelete->delete();
                }

                $imageOrderx++;
            }
        }

        if (isset($request->file('projectData')['gallery']) && $request->file('projectData')['gallery']) {
            foreach ($request->file('projectData')['gallery'] as $key => $image) {
                $newFileName = Str::slug($projectData['project_title']) . '-gallery-' . ($key + 1) . time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('storage/project_images'); // Yeni dosya adı ve yolu


                if ($image->move($destinationPath, $newFileName)) {

                    $imageMg = $manager->read(public_path('storage/project_images/' . $newFileName));
                    $imageWidth = $imageMg->width();
                    $imageHeight = $imageMg->height();


                    if ($imageWidth > 1200) {
                        $newWidth = 1200;
                        $newHeight = $imageHeight * 1200 / $imageWidth;
                    } else {
                        $newWidth = $imageWidth;
                        $newHeight = $imageHeight;
                    }
                    $imageMg->resize($newWidth, $newHeight);
                    $encoded = $imageMg->place(public_path('images/filigran2.png'), 'center', 10, 10, 50, 45);
                    $encoded->save(public_path('storage/project_images/' . $newFileName));

                    $projectImage = new ProjectImage(); // Eğer model kullanıyorsanız
                    $projectImage->image = 'public/project_images/' . $newFileName;
                    $projectImage->project_id = $project->id;
                    $projectImage->save();
                }
            }
        }

        if (isset($request->file('projectData')['situations'])) {
            foreach ($request->file('projectData')['situations'] as $key => $situation) {
                $newFileName = Str::slug($projectData['project_title']) . '-situation-' . ($key + 1) . time() . '.' . $situation->getClientOriginalExtension();
                $yeniDosyaAdi = public_path('situation_images'); // Yeni dosya adı ve yolu

                if ($situation->move($yeniDosyaAdi, $newFileName)) {
                    $imageMg = $manager->read(public_path('situation_images/' . $newFileName));
                    $imageWidth = $imageMg->width();
                    $imageHeight = $imageMg->height();

                    if ($imageWidth > 1200) {
                        $newWidth = 1200;
                        $newHeight = $imageHeight * 1200 / $imageWidth;
                    } else {

                        $newWidth = $imageWidth;
                        $newHeight = $imageHeight;
                    }
                    $imageMg->resize($newWidth, $newHeight);
                    $encoded = $imageMg->place(public_path('images/filigran2.png'), 'center', 10, 10, 50, 45);
                    $encoded->save(public_path('situation_images/' . $newFileName));

                    $projectImage = new ProjectSituation(); // Eğer model kullanıyorsanız
                    $projectImage->situation = 'public/situation_images/' . $newFileName;
                    $projectImage->project_id = $project->id;
                    $projectImage->save();
                }
            }
        }

        return json_encode([
            "status" => true
        ]);
    }

    public function deactive($id)
    {
        Project::where('id', $id)->update([
            "status" => 0
        ]);

        return json_encode([
            "status" => true
        ]);
    }

    public function active($id)
    {
        Project::where('id', $id)->update([
            "status" => 1
        ]);

        return json_encode([
            "status" => true
        ]);
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);

        ShareLink::where('item_type', 1)->where('item_id', $project->id)->delete();

        $project->delete();

        return json_encode([
            "status" => true
        ]);
    }

    public function createHousing(Request $request)
    {
        $housingTypeParentConnection = HousingTypeParentConnection::where('id', $request->input('selectedTypes')[count($request->input('selectedTypes')) - 1])->first();
        $housingTypeInputs = json_decode($housingTypeParentConnection->housingType->form_json);

        $manager = new ImageManager(
            new Driver()
        );

        $projectSlug = Str::slug($request->input('projectData')['project_title']);
        $projectData = $request->input('projectData');

        if ($request->file('projectData')['cover_image']) {

            $file = $request->file('projectData')['cover_image'];

            // Dosyanın hedef dizini
            $destinationPath = public_path('housing_images'); // Örnek olarak 'uploads' klasörü altına kaydedilecek

            // Dosyayı belirlenen hedefe taşı
            $fileNameCoverImage = $projectSlug . '_housing_cover_image_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileNameCoverImage);

            $image = $manager->read(public_path('housing_images/' . $fileNameCoverImage));
            $imageWidth = $image->width();
            $imageHeight = $image->height();

            if ($imageWidth > 1200) {
                $newWidth = 1200;
                $newHeight = $imageHeight * 1200 / $imageWidth;
            } else {

                $newWidth = $imageWidth;
                $newHeight = $imageHeight;
            }
            $image2 = $manager->read(public_path('images/filigran2.png'));
            $imageWidth2 = $image2->width();
            $imageHeight2 = $image2->height();
            $image2->resize($newWidth / 10 * 7, (($newWidth * $imageHeight2 / $imageWidth2) / 10) * 7);
            $image2->rotate(30, '#00000000');
            $image->resize($newWidth, $newHeight);
            $encoded = $image->place($image2, 'center', 10, 10, 20);
            $encoded->save(public_path('housing_images/' . $fileNameCoverImage));
        }

        $housingTypeParent = HousingTypeParent::where('id', $request->input('selectedTypes')[1])->first();

        if ($housingTypeParent->slug != "gunluk-kiralik") {
            if ($request->file('projectData')['document']) {

                $file = $request->file('projectData')['document'];

                // Dosyanın hedef dizini
                $destinationPath = public_path('housing_documents'); // Örnek olarak 'uploads' klasörü altına kaydedilecek

                // Dosyayı belirlenen hedefe taşı
                $fileNameDocument = $projectSlug . '_housing_document_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $fileNameDocument);
            }

            if(auth()->user()->type != 1){
                if ($request->file('projectData')['document']) {

                    $file = $request->file('projectData')['authority_certificate'];
    
                    // Dosyanın hedef dizini
                    $destinationPath = public_path('authority_certificates'); // Örnek olarak 'uploads' klasörü altına kaydedilecek
    
                    // Dosyayı belirlenen hedefe taşı
                    $fileNameAuthorityCertificateName = $projectSlug . '_authority_certificate_' . time() . '.' . $file->getClientOriginalExtension();
                    $file->move($destinationPath, $fileNameAuthorityCertificateName);
                }
            }else{
                $fileNameAuthorityCertificateName = "";
            }
        } else {
            $fileNameAuthorityCertificateName = "";
            $fileNameDocument = "";
        }



        $galleryImages = [];

        foreach ($request->file('projectData')['gallery'] as $order => $imagex) {
            $file = $imagex;
            // Dosyanın hedef dizini
            $destinationPath = public_path('housing_images'); // Örnek olarak 'uploads' klasörü altına kaydedilecek

            // Dosyayı belirlenen hedefe taşı
            $fileNameGalleryImage = $projectSlug . '_housing_gallery_image_' . $order . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileNameGalleryImage);
            $image = $manager->read(public_path('housing_images/' . $fileNameGalleryImage));
            $imageWidth = $image->width();
            $imageHeight = $image->height();
            if ($imageWidth > 1200) {
                $newWidth = 1200;
                $newHeight = $imageHeight * 1200 / $imageWidth;
            } else {

                $newWidth = $imageWidth;
                $newHeight = $imageHeight;
            }
            $image2 = $manager->read(public_path('images/filigran2.png'));
            $imageWidth2 = $image2->width();
            $imageHeight2 = $image2->height();
            $image2->resize($newWidth / 10 * 7, (($newWidth * $imageHeight2 / $imageWidth2) / 10) * 7);
            $image2->rotate(30, '#00000000');
            $image->resize($newWidth, $newHeight);
            $encoded = $image->place($image2, 'center', 10, 10, 20);
            $encoded->save(public_path('housing_images/' . $fileNameGalleryImage));
            array_push($galleryImages, $fileNameGalleryImage);
        }

        $housingTypeParent1 = HousingTypeParent::where('id', $request->input('selectedTypes')[0])->firstOrFail();
        $housingTypeParent2 = HousingTypeParent::where('id', $request->input('selectedTypes')[1])->firstOrFail();

        $postData = [];
        foreach ($request->input('room') as $key => $pData) {
            $postData[$key] = [$pData];
        }
        foreach ($housingTypeInputs as $input) {
            if ($input->type == "checkbox-group") {
                if (str_contains($input->className, 'price-only') || str_contains($input->className, 'number-only')) {
                    if (isset($postData[str_replace('[]', '', $input->name)]) && $postData[str_replace('[]', '', $input->name)]) {
                        $postData[str_replace('[]', '', $input->name)] = explode(',', $postData[str_replace('[]', '', $input->name)][0]);
                    }
                } else {
                    if (isset($postData[str_replace('[]', '', $input->name)]) && $postData[str_replace('[]', '', $input->name)]) {
                        $postData[str_replace('[]', '', $input->name)] = explode(',', $postData[str_replace('[]', '', $input->name)][0]);
                    }
                }
            } else {
                if (str_contains($input->className, 'price-only') || str_contains($input->className, 'number-only')) {
                    if (isset($postData[str_replace('[]', '', $input->name)]) && $postData[str_replace('[]', '', $input->name)]) {
                        $postData[str_replace('[]', '', $input->name)] = [str_replace('.', '', $postData[str_replace('[]', '', $input->name)][0])];
                    }
                } else {
                    if (isset($postData[str_replace('[]', '', $input->name)]) && $postData[str_replace('[]', '', $input->name)]) {
                        $postData[str_replace('[]', '', $input->name)] = [$postData[str_replace('[]', '', $input->name)][0]];
                    }
                }
            }
        }

        $postData['image'] = $fileNameCoverImage;
        $postData['images'] = $galleryImages;
        $ownerId = auth()->user()->type == 1 ? auth()->user()->id : null;
        $sellType = $request->session()->get('sell_type');

        if ($sellType == "kendim-satmak") {
           $ownerId = null;
           unset($postData['open_sharing1']);
        }else{
            $postData['open_sharing1'] = "Evet";
        }
        
        $isShare =  false;

        $consultant = auth()->user()->parent_id ? true : false;

        $project = Housing::create(
            [
                'housing_type_id' => $housingTypeParentConnection->housingType->id,
                'title' => $projectData['project_title'],
                'slug' => Str::slug($projectData['project_title']),
                'address' => 'asd',
                'description' => $projectData['description'],
                'city_id' => $projectData['city_id'],
                "step1_slug" => $housingTypeParent1->slug,
                "step2_slug" => $housingTypeParent2->slug,
                "island" => $request->input('projectData')['island']  ?? null,
                "parcel" => $request->input('projectData')['parcel']  ?? null,
                'county_id' => $projectData['county_id'],
                'neighborhood_id' => $projectData['neighbourhood_id'],
                'status_id' => 1,
                'document' => $fileNameDocument,
                'authority_certificate' => $fileNameAuthorityCertificateName,
                'status' => 2,
                'housing_type_data' => json_encode($postData, JSON_UNESCAPED_UNICODE),
                'user_id' => auth()->user()->parent_id ?? auth()->user()->parent_id ?? auth()->user()->id,
                'latitude' => explode('-', $request->input('projectData')['coordinates'])[0],
                'longitude' => explode('-', $request->input('projectData')['coordinates'])[1],
                'status' => 2,
                'owner_id' =>  $ownerId,
                'is_share' =>  $isShare,
                'consultant_id' => $consultant ? auth()->user()->id : null

            ]
        );

        if ($project) {
            $institutions = Institution::all();
        
            foreach ($institutions as $key => $institution) {
                $defaultDepositRate = 0.90;
                $institutionalRateClub = 0.45;
                $clientRateClub = 0.25;
                $clientDepositRate = 0.70;
            
                $isOpenSharing1Set = isset($postData['open_sharing1']);
            
                $sellTypeInstitutionalRate = $isOpenSharing1Set && $institution->name !== "Diğer" ? 0.80 : null;
                $sellTypeClientRate = !$isOpenSharing1Set && $institution->name === "Diğer" ? 0.70 : null;
            
                $sellTypeInstitutionalClub = $isOpenSharing1Set && $institution->name !== "Diğer" ? 0.40 : null;
                $sellTypeClientClub = !$isOpenSharing1Set && $institution->name === "Diğer" ? 0.25 : null;
            
                $defaultDepositRateToUse = $institution->name !== "Diğer" ? ($sellTypeInstitutionalRate ?? $defaultDepositRate) : ($sellTypeClientRate ?? $clientDepositRate);
                $salesRateClubToUse = $institution->name !== "Diğer" ? ($sellTypeInstitutionalClub ?? $institutionalRateClub) : ($sellTypeClientClub ?? $clientRateClub);
            
                // Check if Rate record already exists for this institution and project
                $existingRate = Rate::where('institution_id', $institution->id)
                                    ->where('housing_id', $project->id)
                                    ->first();
            
                if (!$existingRate) {
                    Rate::create([
                        'institution_id' => $institution->id,
                        'housing_id' => $project->id,
                        'default_deposit_rate' => $defaultDepositRateToUse,
                        'sales_rate_club' => $salesRateClubToUse,
                    ]);
                }
            }
        }
        

     
        $user = auth()->user();

        if ($project && auth()->user()->type == 1) {
        
            // Kullanıcının telefon numarasını kontrol et
            if ($user->mobile_phone) {
                $ownerId = $user->id;
                $isShare = true;

                // Eğer kullanıcıya ait bir telefon numarası varsa, SMS gönderme işlemi gerçekleştirilir
                $userPhoneNumber = $user->mobile_phone;
                $message = $project->id + 2000000 .  "No'lu Emlak İlanınız incelenmesi için EmlakSepette Yönetimine İletilmiştir. "; // Göndermek istediğiniz mesajı buraya ekleyin

                // SmsService sınıfını kullanarak SMS gönderme işlemi
                $smsService = new SmsService();
                $source_addr = 'Emlkspette'; // Kaynak adresi değiştirin, gerektiğinde.

                $smsService->sendSms($source_addr, $message, $userPhoneNumber);
            }
        }

        if (isset($postData['property_owner_phone']) && $postData['property_owner_phone'] && $postData['property_owner'] && $user) {

            // Eğer kullanıcıya ait bir telefon numarası varsa, SMS gönderme işlemi gerçekleştirilir
            $property_owner_phone = $postData['property_owner_phone'];
            $message = "Sayın " . $postData['property_owner'] . ", mülkünüz Yetkili Emlak Ofisi " . $user->name . " tarafından Emlak Sepeti Yönetimine iletilmiştir.";

            // SmsService sınıfını kullanarak SMS gönderme işlemi
            $smsService = new SmsService();
            $source_addr = 'Emlkspette'; // Kaynak adresi değiştirin, gerektiğinde.

            $smsService->sendSms($source_addr, $message, $property_owner_phone);
        }


        $defaultHousingconnection = HousingStatus::where('is_default', 1)->where('is_housing', 1)->first();
        HousingStatusConnection::create([
            'housing_status_id' => $defaultHousingconnection->id,
            'housing_id' => $project->id
        ]);


        return json_encode([
            "status" => true,
            "project" => $project
        ]);
    }

    public function saveTempProject(Request $request)
    {
        $tempOrder = TempOrder::where('user_id', auth()->user()->id)->where('item_type', 2)->first();

        if ($tempOrder) {
        } else {
            $data = [
                "projectData" => $request->input('projectData'),
                "haveBlocks" => $request->input('haveBlocks'),
                "totalRoomCount" => $request->input('totalRoomCount'),
                "selectedTypes" => $request->input('selectedTypes')
            ];

            TempOrder::create([
                "user_id" => auth()->user()->id,
                "data" => "asd",
                "item_type" => 2,
                "step_order" => 1
            ]);
        }
    }

    public function projectHousings($projectId, Request $request)
    {
        $project = Project::with("blocks")->where('id', $projectId)->first();

        if ($project->have_blocks) {
            $blocks = Block::where('project_id', $project->id)->get();
            $blockStart = 0;
            foreach ($blocks as $index => $block) {
                if ($index < $request->input('block')) {
                    $blockStart += $block->housing_count;
                }
            }
            if ($blockStart + intval($request->input('end')) > $blockStart + $blocks[$request->input('block')]->housing_count) {
                $end = $blockStart + $blocks[$request->input('block')]->housing_count;
            } else {
                $end = $blockStart + intval($request->input('end'));
            }
            $projectHousings = ProjectHousing::where('project_id', $project->id)->where('room_order', '>', $blockStart + intval($request->input('start')))->where('room_order', '<=', $end)->get();
        } else {
            $projectHousings = ProjectHousing::where('project_id', $project->id)->where('room_order', '>', $request->input('start'))->where('room_order', '<=', $request->input('end'))->get();
        }

        $projectHousingsList = [];
        $combinedValues = $projectHousings->map(function ($item) use (&$projectHousingsList) {
            $projectHousingsList[$item->room_order][$item->name] = $item->value;
        });

        $projectHousingCount = ProjectHousing::where('project_id', $project->id)->groupBy('room_order')->count();

        $sumCartOrderQt = DB::table('cart_orders')
            ->select(
                DB::raw('JSON_EXTRACT(cart, "$.item.housing") as housing_id'),
                DB::raw('JSON_EXTRACT(cart, "$.item.qt") as qt')
            )
            ->leftJoin('users', 'cart_orders.user_id', '=', 'users.id')
            ->where(DB::raw('JSON_EXTRACT(cart, "$.type")'), 'project')
            ->where(DB::raw('JSON_EXTRACT(cart, "$.item.id")'), $project->id)
            ->orderByRaw('CAST(housing_id AS SIGNED) ASC')
            ->get();


        $sumCartOrderQt = $sumCartOrderQt->groupBy('housing_id')
            ->mapWithKeys(function ($group) {
                return [
                    $group->first()->housing_id => [
                        'housing_id' => $group->first()->housing_id,
                        'qt_total' => $group->sum('qt'),
                    ]
                ];
            })
            ->all();

        $solds = DB::select('SELECT * FROM cart_orders WHERE JSON_EXTRACT(cart, "$.type") = "project" AND JSON_EXTRACT(cart, "$.item.id") = ? ', [$project->id]);

        return json_encode([
            "project" => $project,
            "rows" => $projectHousingsList,
            "projectHousingCount" => $projectHousingCount,
            "sumCartOrderQt" => $sumCartOrderQt,
            "solds" => $solds
        ]);
    }

    public function saveHousing(Request $request)
    {
        if ($request->input('is_dot')) {
            for ($i = 0; $i < count($request->input('rooms')); $i++) {
                $hasData = ProjectHousing::where('project_id', $request->input('project_id'))
                    ->where('room_order', $request->input('rooms')[$i])
                    ->where('name', $request->input('column_name') . '[]')
                    ->whereNull(DB::raw("(SELECT status FROM cart_orders WHERE JSON_UNQUOTE(JSON_EXTRACT(cart, '$.item.id')) = '" . $request->input('project_id') . "' AND JSON_UNQUOTE(JSON_EXTRACT(cart, '$.item.housing') = project_housings.room_order AND (cart_orders.status = 1 OR cart_orders.status = 0)))"))
                    ->first();

                if ($hasData) {
                    ProjectHousing::where('project_id', $request->input('project_id'))
                        ->where('room_order', $request->input('rooms')[$i])
                        ->where('name', $request->input('column_name') . '[]')
                        ->whereNull(DB::raw("(SELECT status FROM cart_orders WHERE JSON_UNQUOTE(JSON_EXTRACT(cart, '$.item.id')) = '" . $request->input('project_id') . "' AND JSON_UNQUOTE(JSON_EXTRACT(cart, '$.item.housing') = project_housings.room_order AND (cart_orders.status = 1 OR cart_orders.status = 0)))"))
                        ->update([
                            "name" => $request->input('column_name') . "[]",
                            "value" => str_replace('.', '', $request->input('value'))
                        ]);
                } else {
                    ProjectHousing::create([
                        "key" => "Asd",
                        "name" => $request->input('column_name') . '[]',
                        "value" => str_replace('.', '', $request->input('value')),
                        "project_id" => $request->input('project_id'),
                        "room_order" => $request->input('rooms')[$i]
                    ]);
                }
            }
        } else {
            for ($i = 0; $i < count($request->input('rooms')); $i++) {
                $hasData = ProjectHousing::where('project_id', $request->input('project_id'))
                    ->where('room_order', $request->input('rooms')[$i])
                    ->where('name', $request->input('column_name') . '[]')
                    ->whereNull(DB::raw("(SELECT status FROM cart_orders WHERE JSON_UNQUOTE(JSON_EXTRACT(cart, '$.item.id')) = '" . $request->input('project_id') . "' AND JSON_UNQUOTE(JSON_EXTRACT(cart, '$.item.housing') = project_housings.room_order AND (cart_orders.status = 1 OR cart_orders.status = 2)))"))
                    ->first();

                if ($hasData) {
                    ProjectHousing::where('project_id', $request->input('project_id'))
                        ->where('room_order', $request->input('rooms')[$i])
                        ->where('name', $request->input('column_name') . '[]')
                        ->whereNull(DB::raw("(SELECT status FROM cart_orders WHERE JSON_UNQUOTE(JSON_EXTRACT(cart, '$.item.id')) = '" . $request->input('project_id') . "' AND JSON_UNQUOTE(JSON_EXTRACT(cart, '$.item.housing')) = project_housings.room_order AND (cart_orders.status = 1 OR cart_orders.status = 2))"))
                        ->update([
                            "name" => $request->input('column_name') . "[]",
                            "value" => str_replace('.', '', $request->input('value'))
                        ]);
                } else {
                    ProjectHousing::create([
                        "key" => "Asd",
                        "name" => $request->input('column_name') . '[]',
                        "value" => str_replace('.', '', $request->input('value')),
                        "project_id" => $request->input('project_id'),
                        "room_order" => $request->input('rooms')[$i]
                    ]);
                }
            }
        }

        return json_encode([
            "status" => true,
        ]);
    }

    public function changeImage(Request $request)
    {
        try {
            $project = Project::with("blocks")->where('id', $request->input('project_id'))->first();
            $imageRoom = $request->file('value');
            $manager = new ImageManager(
                new Driver()
            );
            if ($imageRoom) {
                $newFileName = $project->slug . '-project-housing-image-' . ($request->input('room_order')) . time() . '.' . $imageRoom->getClientOriginalExtension();
                $yeniDosyaAdi = public_path('project_housing_images'); // Yeni dosya adı ve yolu

                if ($imageRoom->move($yeniDosyaAdi, $newFileName)) {
                    $image = $manager->read(public_path('project_housing_images/' . $newFileName));
                    $imageWidth = $image->width();
                    $imageHeight = $image->height();

                    if ($imageWidth > 1200) {
                        $newWidth = 1200;
                        $newHeight = $imageHeight * 1200 / $imageWidth;
                    } else {
                        $newWidth = $imageWidth;
                        $newHeight = $imageHeight;
                    }

                    $image = $manager->read(public_path('project_housing_images/' . $newFileName));
                    $image2 = $manager->read(public_path('images/filigran2.png'));
                    $imageWidth2 = $image2->width();
                    $imageHeight2 = $image2->height();
                    $image2->resize($newWidth / 10 * 7, (($newWidth * $imageHeight2 / $imageWidth2) / 10) * 7);
                    $image2->rotate(30, '#00000000');
                    $image->resize($newWidth, $newHeight);
                    $encoded = $image->place($image2, 'center', 10, 10, 20);
                    $encoded->save(public_path('project_housing_images/' . $newFileName));

                    ProjectHousing::where('project_id', $request->input('project_id'))->whereIn('room_order', $request->input('rooms'))->where('name', $request->input('column_name') . '[]')->update([
                        "name" => "image[]",
                        "value" => $newFileName
                    ]);
                }
            }

            return json_encode([
                "status" => true
            ]);
        } catch (Throwable $e) {
            return json_encode([
                "error" => $e->getMessage(),
                "status" => false
            ]);
        }
    }

    public function changePayDecs(Request $request)
    {
        for ($i = 0; $i < count($request->input('rooms')); $i++) {
            ProjectHousing::where('project_id', $request->input('project_id'))->where('room_order', $request->input('rooms')[$i])->where('name', 'pay-dec-count' . $i + 1)->delete();
            ProjectHousing::where('project_id', $request->input('project_id'))->where('room_order', $request->input('rooms')[$i])->where('name', 'LIKE', '%pay_desc_price' . ($i + 1) . '%')->delete();
            ProjectHousing::where('project_id', $request->input('project_id'))->where('room_order', $request->input('rooms')[$i])->where('name', 'LIKE', '%pay_desc_date' . ($i + 1) . '%')->delete();
        }

        for ($i = 0; $i < count($request->input('rooms')); $i++) {
            ProjectHousing::create([
                "key" => "pay-dec-count" . ($request->input('rooms')[$i]),
                "name" => "pay-dec-count" . ($request->input('rooms')[$i]),
                "value" => str_replace('.', '', count($request->input('value'))),
                "project_id" => $request->input('project_id'),
                "room_order" => $request->input('rooms')[$i],
            ]);
            for ($j = 0; $j < count($request->input('value')); $j++) {
                if (isset($request->input('value')[$j]["price"])) {
                    ProjectHousing::create([
                        "key" => "pay_desc_price" . ($request->input('rooms')[$i]) . $j,
                        "name" => "pay_desc_price" . ($request->input('rooms')[$i]) . $j,
                        "value" => str_replace('.', '', $request->input('value')[$j]["price"]),
                        "project_id" => $request->input('project_id'),
                        "room_order" => $request->input('rooms')[$i],
                    ]);
                }

                if (isset($request->input('value')[$j]["date"])) {
                    ProjectHousing::create([
                        "key" => "pay_desc_date" . ($request->input('rooms')[$i]) . $j,
                        "name" => "pay_desc_date" . ($request->input('rooms')[$i]) . $j,
                        "value" => $request->input('value')[$j]["date"],
                        "project_id" => $request->input('project_id'),
                        "room_order" => $request->input('rooms')[$i],
                    ]);
                }
            }
        }

        return json_encode([
            "status" => true
        ]);
    }

    public function savePaymentStatus(Request $request)
    {
        ProjectHousing::where('project_id', $request->input('project_id'))->whereIn('room_order', $request->input('rooms'))->where('name', 'off_sale[]')->update([
            "name" => "off_sale[]",
            "value" => str_replace('.', '', $request->input('value'))
        ]);

        return json_encode([
            "status" => true,
        ]);
    }

    public function saveTemplate(Request $request)
    {
        TempOrder::create([
            "user_id" => auth()->user()->id,
            "data" => json_encode($request->all()),
            "item_type" => 1,
            "step_order" => 2
        ]);
        return $request->all();
    }

    public function getLastData()
    {
        $lastData = TempOrder::where('user_id', auth()->user()->id)->where('item_type', 1)->first();

        return json_encode([
            "lastData" => json_decode($lastData->data)
        ]);
    }

    public function getInvoiceData($cartId)
    {
        $order = CartOrder::where("id", $cartId)->first();
        $cart = json_decode($order->cart);
        $project = null;

        if ($cart->type == "project") {
            $project = Project::where("id", $cart->item->id)->with("brand", "roomInfo", "housingType", "county", "city", 'user.projects.housings', 'user.brands', 'user.housings', 'images')->first();
        } else {
            $project = Housing::where("id", $cart->item->id)->with("user")->first();
        }

        $invoice = Invoice::where("order_id", $order->id)->with("order.user", "order.bank")->first();
        $data = [
            'invoice' => $invoice,
            'project' => $project,
        ];

        return json_encode([
            "data" => $data
        ]);
    }

    public function getHousingTypeData($housingTypeId)
    {
        $housingType = HousingType::where('id', $housingTypeId)->first();

        return json_encode([
            "data" => $housingType
        ]);
    }

    public function saveHousingCheckboxes(Request $request)
    {
        for ($i = 0; $i < count($request->input('rooms')); $i++) {
            $hasData = ProjectHousing::where('project_id', $request->input('project_id'))
                ->where('room_order', $request->input('rooms')[$i])
                ->where('name', $request->input('column_name') . '[]')
                ->whereNull(DB::raw("(SELECT status FROM cart_orders WHERE JSON_UNQUOTE(JSON_EXTRACT(cart, '$.item.id')) = '" . $request->input('project_id') . "' AND JSON_UNQUOTE(JSON_EXTRACT(cart, '$.item.housing')) = project_housings.room_order AND (cart_orders.status = 1 OR cart_orders.status = 2))"))
                ->first();

            if ($hasData) {
                ProjectHousing::where('project_id', $request->input('project_id'))
                    ->where('room_order', $request->input('rooms')[$i])
                    ->where('name', $request->input('column_name') . '[]')
                    ->whereNull(DB::raw("(SELECT status FROM cart_orders WHERE JSON_UNQUOTE(JSON_EXTRACT(cart, '$.item.id')) = '" . $request->input('project_id') . "' AND JSON_UNQUOTE(JSON_EXTRACT(cart, '$.item.housing')) = project_housings.room_order AND (cart_orders.status = 1 OR cart_orders.status = 2))"))
                    ->update([
                        "name" => $request->input('column_name') . "[]",
                        "value" => json_encode($request->input('value'))
                    ]);
            } else {
                ProjectHousing::create([
                    "key" => "Asd",
                    "name" => $request->input('column_name') . '[]',
                    "value" => str_replace('.', '', $request->input('value')),
                    "project_id" => $request->input('project_id'),
                    "room_order" => $request->input('rooms')[$i]
                ]);
            }
        }


        return json_encode([
            "status" => true,
        ]);
    }

    public function getSale($projectId,$roomOrder){
        $paymentSetting = PaymentSetting::where('project_id',$projectId)->where('room_order',$roomOrder)->first();

        return json_encode([
            "data" => $paymentSetting
        ]);
    }

    public function saveSale(Request $request, $projectId)
    {
        CartOrder::whereRaw(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(cart, '$.item.id')) = " . $projectId))->whereRaw(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(cart, '$.item.housing')) = " . $request->input('room_order')))->update([
            "full_name" => $request->input('name'),
            "email" => $request->input('email'),
            "phone" => $request->input('phone'),
            "is_swap" => $request->input('sale_type') == 1 ? 0 : 1,
            "is_show_user" => $request->input('show_neighbour') ? "on" : null,
        ]);

        if($request->input('sale_type') == 1){
            ProjectHousing::where('project_id', $projectId)->where('room_order', $request->input('room_order'))->where('name', 'price[]')->update([
                "value" => str_replace('.', '', $request->input('price'))
            ]);
        }else{
            ProjectHousing::where('project_id', $projectId)->where('room_order', $request->input('room_order'))->where('name', 'installments-price[]')->update([
                "value" => str_replace('.', '', $request->input('price'))
            ]);
        }
        

        ProjectHousing::where('project_id', $projectId)->where('room_order', $request->input('room_order'))->where('name', 'advance[]')->update([
            "value" => str_replace('.', '', $request->input('advance'))
        ]);

        ProjectHousing::where('project_id', $projectId)->where('room_order', $request->input('room_order'))->where('name', 'installments[]')->update([
            "value" => $request->input('installments')
        ]);
        
        $payDecCount = ProjectHousing::where('project_id',$projectId)->where('room_order',$request->input('room_order'))->where('name','pay-dec-count'.$request->input('room_order'))->first();

        if($payDecCount){
            ProjectHousing::where('project_id',$projectId)->where('room_order',$request->input('room_order'))->where('name','pay-dec-count'.$request->input('room_order'))->update([
                "value" => $request->input('pay_decs') ? count($request->input('pay_decs')) : 0
            ]);
        }else{
            ProjectHousing::create([
                "project_id" => $projectId,
                "room_order" => $request->input('room_order'),
                "name" => 'pay-dec-count'.$request->input('room_order'),
                "value" => count($request->input('pay_decs')),
                "key" => 'pay-dec-count'.$request->input('room_order')
            ]);
        }
        
        
        PaymentSetting::where('project_id',$projectId)->where('room_order',$request->input('room_order'))->delete();

        $payDecArr = [];

        for($i = 0; $i < count($request->input('pay_decs')); $i++){
            if(isset($request->input('pay_decs')[$i]['status']) && $request->input('pay_decs')[$i]['status']){
                array_push($payDecArr,$i+1);
            }
        }

        PaymentSetting::create([
            "project_id"                     => $projectId,
            "room_order"                     => $request->input('room_order'),
            "down_payment"                   => $request->input('down_payment') ?? false,
            "advance"                        => $request->input('advance_payment') ?? false,
            "down_payment_price"             => $request->input('down_payment_price') ? str_replace('.','',$request->input('down_payment_price')) : "",
            "pay_decs"                       => json_encode($payDecArr),
            "advance_date"                   => $request->input('advance_date') ?? null,
            "deposit_date"                   => $request->input('deposit_date') ?? null,
            "down_payment_price_description" => $request->input('down_payment_price_description') ?? null,
            "advance_date_description"       => $request->input('advance_date_description') ?? null
        ]);

        if($request->input('pay_decs')){
            for($i = 0; $i < count($request->input('pay_decs')); $i++){
                $checkPrice = ProjectHousing::where('project_id',$projectId)->where('room_order',$request->input('room_order'))->where('name','pay_desc_price'.$request->input('room_order').$i)->first();
                $checkDate  = ProjectHousing::where('project_id',$projectId)->where('room_order',$request->input('room_order'))->where('name','pay_desc_date'.$request->input('room_order').$i)->first();
                if($checkPrice){
                    ProjectHousing::where('project_id',$projectId)->where('room_order',$request->input('room_order'))->where('name',"pay_desc_price".$request->input('room_order').$i)->update([
                        "value" => $request->input('pay_decs')[$i]['price']
                    ]);
                }else{
                    ProjectHousing::create([
                        "project_id" => $projectId,
                        "room_order" => $request->input('room_order'),
                        "name"       => "pay_desc_price".$request->input('room_order').$i,
                        "value"      => $request->input('pay_decs')[$i]['price'],
                        "key"        => "pay_desc_price".$request->input('room_order').$i
                    ]);
                }
    
                if($checkDate){
                    ProjectHousing::where('project_id',$projectId)->where('room_order',$request->input('room_order'))->where('name',"pay_desc_date".$request->input('room_order').$i)->update([
                        "value" => $request->input('pay_decs')[$i]['date']
                    ]);
                }else{
                    ProjectHousing::create([
                        "project_id" => $projectId,
                        "room_order" => $request->input('room_order'),
                        "name"       => "pay_desc_date".$request->input('room_order').$i,
                        "value"      => $request->input('pay_decs')[$i]['date'],
                        "key"        => "pay_desc_date".$request->input('room_order').$i
                    ]);
                }
            }
        }     

        return json_encode([
            "status" => true
        ]);
    }

    public function saveInstallments(Request $request, $projectId, $roomOrder)
    {
        // Eski taksitleri sil
        Installment::where('project_id', $projectId)->where('room_order', $roomOrder)->delete();
        
        $installments = [];
        foreach ($request->input('installments') as $installment) {
            // Taksit verilerini oluştur
            $createdInstallment = Installment::create([
                "price"                          => $installment['price'] ? str_replace('.', '', $installment['price']) : "0",
                "date"                           => $installment['date'] ?? date('Y-m-d'),
                "payment_date"                   => $installment['payment_date'] ?? null,
                "paymentType"                    => $installment['paymentType'] ?? "",
                "description"                    => $installment['description'] ?? "",
                "is_payment"                     => $installment['is_payment'] ?? false,
                "project_id"                     => $projectId,
                "room_order"                     => $roomOrder         
            ]);
    
            // Oluşturulan taksit verisini diziye ekle
            $installments[] = $createdInstallment;
        }
        // JSON yanıtı döndür
        return response()->json([
            "status" => true,
            "installments" => $installments
        ]);
    }
    

    public function getInstallments($projectId, $roomOrder)
    {
        $installments = Installment::where('project_id', $projectId)->where('room_order', $roomOrder)->get();

        return json_encode([
            "data" => $installments
        ]);
    }

    public function getPreview(Request $request){
        $projectImages = [];

        $mimeTypes = [];
        for($i = 0; $i < count($request->file('project')['images']); $i++ ){
            $fileContent = file_get_contents($request->file('project')['images'][$i]->getRealPath());
            
            // Base64'e dönüştür
            $base64 = base64_encode($fileContent);

            array_push($projectImages,$base64);
            array_push($mimeTypes,$request->file('project')['images'][$i]->getMimeType());
            
        }

        $fileContent = file_get_contents($request->file('project')['image']->getRealPath());
            
        // Base64'e dönüştür
        $base64 = base64_encode($fileContent);
        $coverImage = "data:".$request->file('project')['image']->getMimeType().';base64,'.$base64;

        $project = json_decode(json_encode($request->input('project')));
        $project->user->name = auth()->user()->name;
        $project->user->email = auth()->user()->email;
        $project->user->phone = auth()->user()->phone;
        $project->user->mobile_phone = auth()->user()->mobile_phone;
        $project->user->corporate_type = auth()->user()->activity.' Ofisi';
        $status = json_decode(json_encode($request->input('status')));
        $salesCloseProjectHousingCount = 0;
        $projectHousingsList = $request->input('project_housing_list');
        $projectHousingSetting = ProjectHouseSetting::orderBy('order')->get();
        $blocks = $request->input('blocks');

        $html = view('client.preview.project', compact('project','status','salesCloseProjectHousingCount','projectHousingSetting','projectHousingsList','blocks','projectImages','mimeTypes','coverImage'))->render();
        // HTML'yi geçici bir dosyaya kaydediyoruz
        $tempHtmlPath = public_path('temp.html');
        file_put_contents($tempHtmlPath, $html);
        // Resim dosyasının yolunu belirliyoruz
        $imagePath = public_path('screenshot.png');
        $scriptPath = base_path('puppeteer/capture.js');
        $htmlPath = public_path('temp.html');
        $outputPath = public_path('screenshot.png');

        
        $output = shell_exec('node ' . escapeshellarg($scriptPath) . ' ' . escapeshellarg($htmlPath) . ' ' . escapeshellarg($outputPath));

        return 'node ' . escapeshellarg($scriptPath) . ' ' . escapeshellarg($htmlPath) . ' ' . escapeshellarg($outputPath);

        // Komutun ne olduğunu görmek için bu satırı ekleyebilirsiniz
        // return 'node ' . escapeshellarg($scriptPath) . ' ' . escapeshellarg($htmlPath) . ' ' . escapeshellarg($outputPath);

        $imageContent = file_get_contents($imagePath);

        // Resmi tarayıcıda göstermek için geri döndürüyoruz
        return response($imageContent)->header('Content-Type', 'image/png');
    }

    public function getHousingsByProjectId($projectId){
        $projectHousings = ProjectHousing::where('project_id', $projectId)->get();
        $projectHousingsList = [];
        $combinedValues = $projectHousings->map(function ($item) use (&$projectHousingsList) {
            $projectHousingsList[$item->room_order][$item->name] = $item->value;
        });

        return $projectHousingsList;
    }

    public function getSaleCloses($projectId){
        $saleCloses = ProjectHousing::select('room_order')->where('project_id',$projectId)->where('name','off_sale[]')->where('value','!=','[]')->get();

        return json_encode([
            "sale_closes" => $saleCloses
        ]);
    }

    public function renderPdf($projectId,$roomOrder){
        $cartOrderx = [];
        $cartOrder = DB::table('cart_orders')
        ->select('cart_orders.*')
        ->leftJoin('users', 'cart_orders.user_id', '=', 'users.id')
        ->where(DB::raw('JSON_EXTRACT(cart, "$.type")'), 'project')
        ->where(DB::raw('JSON_EXTRACT(cart, "$.item.id")'), $projectId)
        ->where(DB::raw('JSON_EXTRACT(cart, "$.item.housing")'), $roomOrder)
        ->first();

        $project = Project::where('id',$projectId)->first();
        $roomPrice = ProjectHousing::where('project_id',$projectId)->where('room_order',$roomOrder)->where('name','price[]')->first();
        $installmentPrice = ProjectHousing::where('project_id',$projectId)->where('room_order',$roomOrder)->where('name','installments-price[]')->first();
        $advance = ProjectHousing::where('project_id',$projectId)->where('room_order',$roomOrder)->where('name','advance[]')->first();
        $installments = Installment::where('project_id',$projectId)->where('room_order',$roomOrder)->get();
        $paidPrice = 0;

        foreach($installments as $installment){
            if($installment->is_payment){
                $paidPrice += $installment->price;
            }
        }

        if($cartOrder->is_swap){
            $paymentSetting = PaymentSetting::where('project_id',$projectId)->where('room_order',$roomOrder)->first();

            if($paymentSetting->advance){
                $paidPrice += $advance->value;
            }else{
                if($paymentSetting->down_payment){
                    $paidPrice += $paymentSetting->down_payment_price;
                }
            }

            $payDecCount = ProjectHousing::where('project_id',$projectId)->where('room_order',$roomOrder)->where('name','pay-dec-count'.$roomOrder)->first();

            if($payDecCount){
                $payDecCount = $payDecCount->value;
            }else{
                $payDecCount = 0;
            }
            $payDecs = ProjectHousing::where('project_id',$projectId)->where('room_order',$roomOrder)->where('name','LIKE','%pay_desc%')->get()->keyBy('name');
            $paidPayDecs = PaymentSetting::where('project_id',$projectId)->where('room_order',$roomOrder)->first();
            $paidPayDecs = json_decode($paidPayDecs->pay_decs);
            $paymentSettingPayDecs = json_decode($paymentSetting->pay_decs);

            foreach($paymentSettingPayDecs as $payDec){
                $payDecPrice = ProjectHousing::where('project_id',$projectId)->where('room_order',$roomOrder)->where('name','pay_desc_price'.$roomOrder.($payDec-1))->first();

                $paidPrice +=  intval(str_replace('.','',$payDecPrice->value));
            }
            $remainingPayment = $installmentPrice->value - $paidPrice;
        }else{
            $paymentSetting = PaymentSetting::where('project_id',$projectId)->where('room_order',$roomOrder)->first();
            $paidPrice += $roomPrice->value;
            $remainingPayment = 0;
            $payDecs = [];
            $payDecCount = 0;
            $paidPayDecs = [];
        }

        $pdf = Pdf::loadView('institutional.payment_plan.pdf',compact('cartOrder','project','roomOrder','roomPrice','installmentPrice','advance','installments','paidPrice','remainingPayment','payDecs','payDecCount','paidPayDecs','paymentSetting'));
        return $pdf->download($project->project_title.' '.$roomOrder.' Nolu Konut Ödeme Detayı.pdf');
    }
}
