<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\City;
use App\Models\County;
use App\Models\HousingStatus;
use App\Models\HousingType;
use App\Models\PricingStandOut;
use App\Models\Project;
use App\Models\ProjectHousing;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index(){
        $projects = Project::where('user_id',auth()->guard("institutional")->user()->id)->get();
        return view('institutional.projects.index',compact('projects'));
    }

    public function create(){
        $brands = Brand::where('user_id',auth('institutional')->id())->where('status',1)->get();
        $housing_types = HousingType::all();
        $housing_status = HousingStatus::all();
        $cities = City::get();
        return view('institutional.projects.create',compact('housing_types','housing_status','brands','cities'));
    }

    public function store(Request $request){
        $request->validate([
            "housing_type" => "required",
            "name" => "required",
            "address" => "required",
            "location" => "required",
            "brand_id" => "required",
            "description" => "required",
            "house_count" => "required",
            "cover_photo" => "required",
        ]);
        
        $housingTypeInputs = HousingType::where('id',$request->input('housing_type'))->first();
        $housingTypeInputs = json_decode($housingTypeInputs->form_json);
        $errors = [];

        for($i = 0; $i < $request->input('house_count'); $i++){
            for($j = 0; $j < count($housingTypeInputs); $j++){
                if(isset($housingTypeInputs[$j]->name) && $housingTypeInputs[$j]->type != "file" && $housingTypeInputs[$j]->type != "checkbox-group" && $request->input(substr($housingTypeInputs[$j]->name, 0, -2)) && $request->input(substr($housingTypeInputs[$j]->name, 0, -2))[$i] == null && $housingTypeInputs[$j]->required){
                    array_push($errors,($i+1)." nolu konutun ".$housingTypeInputs[$j]->label." alanı boş bırakılamaz");
                }
            }
        }

        if($request->hasFile('cover_photo')){
            $uploadedFile = $request->file('cover_photo');

            $filePath = $uploadedFile->store('public/project_images');
        }

        if(count($errors) == 0){
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
                "status_id" => 1,
                "image" =>  $filePath
            ]);

            foreach ($request->file('project_images') as $image) {
                // Dosyayı uygun bir konuma kaydedin, örneğin "public/project_images" klasörüne
                $path = $image->store('public/project_images');

                // Dosya yolunu veritabanına ekleyin
                $projectImage = new ProjectImage(); // Eğer model kullanıyorsanız
                $projectImage->image = $path;
                $projectImage->project_id = $project->id;
                $projectImage->save();
            }

            for($i = 0; $i < $request->input('house_count'); $i++){
                for($j = 0; $j < count($housingTypeInputs); $j++){
                    if($housingTypeInputs[$j]->type == "file"){
                        if ($request->hasFile(substr($housingTypeInputs[$j]->name, 0, -2))) {
                            $images = $request->file(substr($housingTypeInputs[$j]->name, 0, -2));

                            foreach ($images as $key=>$image) {
                                if ($image->isValid()) {
                                    $imageName = Str::slug(Str::slug($request->input('name'))).'-'.($key+1).time().'.'.$image->getClientOriginalExtension();
                                    $image->move(public_path('/project_housing_images'), $imageName);
                                    ProjectHousing::create([
                                        "key" => $housingTypeInputs[$j]->label,
                                        "name" => $housingTypeInputs[$j]->name,
                                        "value" => $imageName ,
                                        "project_id" => $project->id,
                                        "room_order" => $key + 1
                                    ]);
                                } else {

                                }
                            }
                        }

                        if($housingTypeInputs[$j]->name == "images[]"){
                            $files = [];
                            for($k = 0 ; $k < count($request->file('images'.($i+1))); $k++){
                                $image = $request->file('images'.($i+1))[$k][0];
                                $imageName = Str::slug(Str::slug($request->input('name'))).'-'.($i).'-'.$k.'-'.time().'.'.$image->getClientOriginalExtension();
                                $image->move(public_path('/project_housing_images'), $imageName);
                                array_push($files,$imageName);
                            }

                            ProjectHousing::create([
                                "key" => $housingTypeInputs[$j]->label,
                                "name" => $housingTypeInputs[$j]->name,
                                "value" => json_encode($files) ,
                                "project_id" => $project->id,
                                "room_order" => $i + 1
                            ]);
                        }
                    }else{
                        if($housingTypeInputs[$j]->type != "checkbox-group"){
                            if(isset($housingTypeInputs[$j]->name)  && $request->input(substr($housingTypeInputs[$j]->name, 0, -2))[$i] != null){
                                ProjectHousing::create([
                                    "key" => $housingTypeInputs[$j]->label,
                                    "name" => $housingTypeInputs[$j]->name,
                                    "value" => is_object($request->input(substr($housingTypeInputs[$j]->name, 0, -2))[$i]) || is_array($request->input(substr($housingTypeInputs[$j]->name, 0, -2))[$i]) ? json_encode($request->input(substr($housingTypeInputs[$j]->name, 0, -2))[$i]) : $request->input(substr($housingTypeInputs[$j]->name, 0, -2))[$i],
                                    "project_id" => $project->id,
                                    "room_order" => $i+1
                                ]);
                            }
                        }else{
                            ProjectHousing::create([
                                "key" => $housingTypeInputs[$j]->label,
                                "name" => $housingTypeInputs[$j]->name,
                                "value" => is_object($request->input(substr($housingTypeInputs[$j]->name, 0, -2).($i + 1))) || is_array($request->input(substr($housingTypeInputs[$j]->name, 0, -2).($i + 1))) ? json_encode($request->input(substr($housingTypeInputs[$j]->name, 0, -2).($i+1))) : '',
                                "project_id" => $project->id,
                                "room_order" => $i+1
                            ]);
                        }
                        
                    }
                }
            }
        }

        return redirect()->route('institutional.projects.index',["status"=>"new_project"]);
    }

    public function getCounties(Request $request){
        $counties = County::where('city_id',$request->input('city'))->get();

        return $counties;
    }

    public function standOut($projectId){
        $project = Project::where('id',$projectId)->first();

        return view('institutional.projects.stand_out',compact('project'));
    }

    public function pricingList(Request $request){
        $pricingStandOuts = PricingStandOut::where('type',$request->input('type'))->get();

        return json_encode([
            "status" => true,
            "data" => $pricingStandOuts
        ]);
    }
}
