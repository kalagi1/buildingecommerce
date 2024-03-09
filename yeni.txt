<?php

namespace App\Http\Controllers\Api\Institutional;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\CartOrder;
use App\Models\City;
use App\Models\District;
use App\Models\DocumentNotification;
use App\Models\HousingStatus;
use App\Models\HousingTypeParent;
use App\Models\HousingTypeParentConnection;
use App\Models\Neighborhood;
use App\Models\Project;
use App\Models\ProjectHousing;
use App\Models\ProjectHousingType;
use App\Models\ProjectImage;
use App\Models\ProjectSituation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
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
    
    public function index(Request $request){
        $userId = auth()->user()->parent_id ?? auth()->user()->id;
        $fullProjectsCount = Project::where('user_id', $userId)->where('status',$request->input('status'))->count();
        
        $projects = Project::select(DB::raw('*, (select count(*) from project_housings WHERE name = "off_sale[]" AND value != "[]" AND project_id = projects.id) as offSale'))->where('user_id', $userId)
            ->with( "housingType", "county", "city", "neighbourhood", "standOut", "standOut.dopingPricePaymentWait", 'standOut.dopingPricePaymentCancel')
            ->orderByDesc('created_at')
            ->where('status',$request->input('status'))
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

    public function getHousingStatuses(Request $request){
        $housingStatuses = HousingStatus::where('is_project',1)->get();

        return json_encode([
            "data" => $housingStatuses
        ]);
    }

    public function getHousingTypes(Request $request){
        if($request->input('parent_id')){
            $housingTypes = HousingTypeParent::where('parent_id',$request->input('parent_id'))->get();
        }else{
            $housingTypes = HousingTypeParent::whereNull('parent_id')->get();
        }

        return json_encode([
            "data" => $housingTypes
        ]);
    }

    public function getHousingTypesEnd(Request $request){
        $housingTypes = HousingTypeParentConnection::with("housingType")->where('parent_id',$request->input('parent_id'))->get();
        
        return json_encode([
            "data" => $housingTypes
        ]);
    }

    public function getCities(){
        $cities = City::get();

        return json_encode([
            "data" => $cities
        ]);
    }

    public function getCounties(Request $request){
        $counties = District::where('ilce_sehirkey',$request->input('city_id'))->get();

        return json_encode([
            "data" => $counties
        ]);
    }

    public function getNeighborhoods(Request $request){
        $neighborhoods = Neighborhood::where('mahalle_ilcekey',$request->input('county_id'))->get();

        return json_encode([
            "data" => $neighborhoods
        ]);
    }

    public function createProject(Request $request){
        $housingTypeParent1 = HousingTypeParent::where('id',$request->input('selectedTypes')[1])->firstOrFail(); 
        $housingTypeParent2 = HousingTypeParent::where('id',$request->input('selectedTypes')[2])->firstOrFail(); 
        $instUser = User::where("id", Auth::user()->id)->first();
        $endDate = Carbon::now();
        $projectSlug = Str::slug($request->input('projectData')['project_title']);
        if($request->file('projectData')['cover_image']){

            $file = $request->file('projectData')['cover_image'];

            // Dosyanın hedef dizini
            $destinationPath = public_path('storage/project_images'); // Örnek olarak 'uploads' klasörü altına kaydedilecek
    
            // Dosyayı belirlenen hedefe taşı
            $fileNameCoverImage = $projectSlug.'_cover_image_'.time().'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath, $fileNameCoverImage);
        }
        $totalCount = 0;
        for ($i = 0; $i < count($request->input('blocks')); $i++) {
            for($k = 0; $k < count($request->input('blocks')[$i]['rooms']); $k++){
                $totalCount++;
            }
        }

        if($request->file('projectData')['document']){
            $file = $request->file('projectData')['document'];

            $destinationPath = public_path('housing_documents'); 
            
            $fileNameDocument = $projectSlug.'_document_'.time().'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath, $fileNameDocument);
        }

        $housingTypeParentConnection = HousingTypeParentConnection::where('id',$request->input('selectedTypes')[count($request->input('selectedTypes')) - 1])->first();
        $housingTypeInputs = json_decode($housingTypeParentConnection->housingType->form_json);

        $project = Project::create([
            "housing_type_id" => $housingTypeParentConnection->housing_type_id,
            "step1_slug" => $housingTypeParent1->slug,
            "step2_slug" => $housingTypeParent2->slug,
            "project_title" => $request->input('projectData')['project_title'],
            "create_company" => $request->input('projectData')['create_company'],
            "total_project_area" => $request->input('projectData')['total_project_area'],
            "start_date" => $request->input('projectData')['start_date'],
            "project_end_date" => $request->input('projectData')['end_date'],
            "slug" => Str::slug($request->input('projectData')['project_title']),
            "address" => "asd",
            "location" => str_replace('-',',',$request->input('projectData')['coordinates']),
            "description" => $request->input('projectData')['description'],
            "room_count" => $totalCount,
            "city_id" => $request->input('projectData')['city_id'],
            "county_id" => $request->input('projectData')['county_id'],
            "neighbourhood_id" => $request->input('projectData')['neighbourhood_id'],
            "user_id" => $instUser->parent_id ? $instUser->parent_id : $instUser->id,
            "status_id" => 1,
            "image" => 'public/project_images/'.$fileNameCoverImage,
            'document' => $fileNameDocument,
            "end_date" => $endDate->format('Y-m-d'),
            "status" => 2,
            "have_blocks" => $request->input('haveBlocks') == "true"
        ]);
        
        foreach ($request->file('projectData')['gallery'] as $key => $image) {
            $newFileName = $projectSlug . '-gallery-' . ($key + 1).time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('storage/project_images'); // Yeni dosya adı ve yolu
            if ($image->move($destinationPath, $newFileName)) {
                $projectImage = new ProjectImage(); // Eğer model kullanıyorsanız
                $projectImage->image = 'public/project_images/' . $newFileName;
                $projectImage->project_id = $project->id;
                $projectImage->save();
            }
        }

        foreach ($request->file('projectData')['situations'] as $key => $situation) {
            $newFileName = $projectSlug . '-situation-' . ($key + 1) .time(). '.' . $situation->getClientOriginalExtension();
            $yeniDosyaAdi = public_path('situation_images'); // Yeni dosya adı ve yolu

            if ($situation->move($yeniDosyaAdi, $newFileName)) {
                $projectImage = new ProjectSituation(); // Eğer model kullanıyorsanız
                $projectImage->situation = 'public/situation_images/' . $newFileName;
                $projectImage->project_id = $project->id;
                $projectImage->save();
            }
        }

        $housingTemp = 1;
        for ($i = 0; $i < count($request->input('blocks')); $i++) {
            for($k = 0; $k < count($request->input('blocks')[$i]['rooms']); $k++){
                $room = $request->input('blocks')[$i]['rooms'][$k];
                $paymentPlanOrder = 0;
                for ($j = 0; $j < count($housingTypeInputs); $j++) {
                    if ($housingTypeInputs[$j]->type != "checkbox-group" && $housingTypeInputs[$j]->type != "file") {
                        if ($housingTypeInputs[$j]->name == "installments[]" || $housingTypeInputs[$j]->name == "advance[]" || $housingTypeInputs[$j]->name == "installments-price[]") {
                            if(isset($room['payment-plan']) &&  $room['payment-plan']){
                                if (str_contains($room['payment-plan'],'taksitli')) {
                                    ProjectHousing::create([
                                        "key" => $housingTypeInputs[$j]->label,
                                        "name" => $housingTypeInputs[$j]->name,
                                        "value" => str_replace('.', '', $room[substr($housingTypeInputs[$j]->name, 0, -2)]),
                                        "project_id" => $project->id,
                                        "room_order" => $housingTemp,
                                    ]);
                                    if (substr($housingTypeInputs[$j]->name, 0, -2) == "installments-price") {
                                        $paymentPlanOrder++;
                                    }
                                }
                            }
                        } else {
                            if (str_contains($housingTypeInputs[$j]->className, 'price-only')) {
    
                                if (isset($housingTypeInputs[$j]->name) && isset($room[substr($housingTypeInputs[$j]->name, 0, -2)]) && $room[substr($housingTypeInputs[$j]->name, 0, -2)] != null) {
                                    ProjectHousing::create([
                                        "key" => $housingTypeInputs[$j]->label,
                                        "name" => $housingTypeInputs[$j]->name,
                                        "value" => str_replace('.', '', $room[substr($housingTypeInputs[$j]->name, 0, -2)]),
                                        "project_id" => $project->id,
                                        "room_order" => $housingTemp,
                                    ]);
                                }
                            } else {
                                if (isset($housingTypeInputs[$j]->name) && isset($room[substr($housingTypeInputs[$j]->name, 0, -2)]) && $room[substr($housingTypeInputs[$j]->name, 0, -2)] != null) {
    
                                    ProjectHousing::create([
                                        "key" => $housingTypeInputs[$j]->label,
                                        "name" => $housingTypeInputs[$j]->name,
                                        "value" => $room[substr($housingTypeInputs[$j]->name, 0, -2)],
                                        "project_id" => $project->id,
                                        "room_order" => $housingTemp,
                                    ]);
                                }
                            }
                        }
                    } else if ($housingTypeInputs[$j]->type != "file") {
    
                        ProjectHousing::create([
                            "key" => $housingTypeInputs[$j]->label,
                            "name" => $housingTypeInputs[$j]->name,
                            "value" => isset($room[substr($housingTypeInputs[$j]->name, 0, -2)]) ? json_encode(explode(',',$room[substr($housingTypeInputs[$j]->name, 0, -2)])) : json_encode([]),
                            "project_id" => $project->id,
                            "room_order" => $housingTemp,
                        ]);
    
                    } else if ($housingTypeInputs[$j]->type == "file") {
                        if (!$housingTypeInputs[$j]->multiple) {
                            $imageRoom = $request->file('blocks')[$i]['rooms'][$k]['image'];
                            if ($imageRoom) {
                                $newFileName = $projectSlug . '-project-housing-image-' . ($housingTemp) . '.' . $imageRoom->getClientOriginalExtension();
                                $yeniDosyaAdi = public_path('project_housing_images'); // Yeni dosya adı ve yolu
                                if ($imageRoom->move($yeniDosyaAdi, $newFileName)) {
                                    ProjectHousing::create([
                                        "key" => $housingTypeInputs[$j]->label,
                                        "name" => $housingTypeInputs[$j]->name,
                                        "value" => $newFileName,
                                        "project_id" => $project->id,
                                        "room_order" => $housingTemp,
                                    ]);
                                }
                            }
    
                            
                        }
                    }
                }

                $housingTemp++;
            }
            


        }

        $housingTemp = 0;
        for ($i = 0; $i < count($request->input('blocks')); $i++) {
            for($k = 0; $k < count($request->input('blocks')[$i]['rooms']); $k++){
                $room = $request->input('blocks')[$i]['rooms'][$k];
                ProjectHousing::create([
                    "key" => "pay-dec-count".($housingTemp+1),
                    "name" => "pay-dec-count".($housingTemp+1),
                    "value" => $room["payDecs"] ? count($room["payDecs"]) : 0,
                    "project_id" => $project->id,
                    "room_order" => $housingTemp + 1,
                ]);

                if($room["payDecs"]){
                    for($j = 0; $j < count($room["payDecs"]); $j++){
                        if(isset($room["payDecs"][$j]["price"])){
                            ProjectHousing::create([
                                "key" => "pay_desc_price".($housingTemp+1).$j,
                                "name" => "pay_desc_price".($housingTemp+1).$j,
                                "value" => str_replace('.', '', $room["payDecs"][$j]["price"]),
                                "project_id" => $project->id,
                                "room_order" => $housingTemp + 1,
                            ]);
                        }
    
                        if(isset($room["payDecs"][$j]["date"])){
                            ProjectHousing::create([
                                "key" => "pay_desc_date".($housingTemp+1).$j,
                                "name" => "pay_desc_date".($housingTemp+1).$j,
                                "value" => $room["payDecs"][$j]["date"],
                                "project_id" => $project->id,
                                "room_order" => $housingTemp + 1,
                            ]);
                        }
                    }
                }
                $housingTemp++;
            }
        }

        ProjectHousingType::create([
            "project_id" => $project->id,
            "housing_type_id" => $request->input('selectedTypes')[0],
        ]);

        if($request->input('haveBlocks') && $request->input('haveBlocks') == "true"){
            foreach($request->input('blocks') as $key => $block){
                Block::create([
                    "project_id" => $project->id,
                    "block_name" => $block['name'],
                    "housing_count" => $block['roomCount']
                ]);
            }
            
        }

        $notificationLink =  route('project.detail', ['slug' => $project->slug,'id' => $project->id]);
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
            "status" => true
        ]);
    }
}
