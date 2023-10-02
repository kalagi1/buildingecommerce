<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\City;
use App\Models\County;
use App\Models\HousingStatus;
use App\Models\HousingType;
use App\Models\Log;
use App\Models\PricingStandOut;
use App\Models\Project;
use App\Models\ProjectHousing;
use App\Models\ProjectHousingType;
use App\Models\ProjectImage;
use App\Models\UserPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Rules\EnoughProject;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::where('user_id', Auth::user()->id)->get();
        return view('institutional.projects.index', compact('projects'));
    }

    public function create()
    {
        $brands = Brand::where('user_id', Auth::user()->id)->where('status', 1)->get();
        $housing_types = HousingType::all();
        $housing_status = HousingStatus::all();
        $cities = City::get();
        return view('institutional.projects.create', compact('housing_types', 'housing_status', 'brands', 'cities'));
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

        if (UserPlan::where('user_id', auth()->user()->id)->sum('project_limit') <= 0)
            return redirect()->back()->withErrors(['not_enough_limit' => 'Proje oluşturma hakkınız doldu.']);

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentName = $request->project_title. ' proje belgesi.' . $document->getClientOriginalExtension();
            
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
                "user_id" => Auth::user()->id,
                "status_id" => 1,
                "image" => $filePath,
                'document' => $documentName,
                "status" => 2
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

        return redirect()->route('institutional.projects.index', ["status" => "new_project"]);
    }

    public function getCounties(Request $request)
    {
        $counties = County::where('city_id', $request->input('city'))->get();

        return $counties;
    }

    public function standOut($projectId)
    {
        $project = Project::where('id', $projectId)->first();
        
        return view('institutional.projects.stand_out', compact('project'));
    }

    public function pricingList(Request $request)
    {
        $pricingStandOuts = PricingStandOut::where('housing_status_id',$request->input('housing_status_id'))->where('type', $request->input('type'))->get();
        
        return json_encode([
            "status" => true,
            "data" => $pricingStandOuts,
        ]);
    }

    public function edit($id){
        $project = Project::with("roomInfo")->where('id',$id)->first();
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
        $counties = County::where('city_id',$project->city_id)->get();
        return view('institutional.projects.edit',compact('project','housing_types', 'housing_status', 'brands', 'cities','counties'));
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
            $documentName = $request->project_title. ' proje belgesi.' . $document->getClientOriginalExtension();
            
            // Dosyayı public/housing_documents klasörüne taşı
            $document->move(public_path('/housing_documents'), $documentName);
        }else{
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

            ProjectHousingType::where('project_id',$id)->delete();

            foreach($request->input('housing_status') as $housingStatus){
                ProjectHousingType::create([
                    "project_id" => $id,
                    "housing_type_id" => $housingStatus
                ]);
            }

            $project = Project::where('id',$id)->first();
            if($request->file('image')){

                ProjectHousing::where('project_id',$id)->where('name','!=','images[]')->delete();
            }else{
                ProjectHousing::where('project_id',$id)->where('name','!=','images[]')->where('name','!=','image[]')->delete();
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
                    }else{
                        if($housingTypeInputs[$j]->type != "checkbox-group"){
                            if(isset($housingTypeInputs[$j]->name)  && $request->input(substr($housingTypeInputs[$j]->name, 0, -2))[$i] != null){
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

    public function newProjectImage(Request $request,$projectId){
        if ($request->hasFile('file')) {
            $uploadedFile = $request->file('file');

            $filePath = $uploadedFile->store('public/project_images');
        }

        ProjectImage::create([
            "image" => $filePath,
            "project_id" => $projectId
        ]);

        return json_encode([
            "status" => true
        ]);
    }

    public function deleteProjectImage($projectId,$filename){
        $fileId = explode('--',$filename);

        ProjectImage::where('id',$fileId[1])->delete();
        return json_encode([
            "status" => true
        ]);
    }

    public function removeProjectHousingFile(Request $request){
        $projectHousing = ProjectHousing::where('project_id',$request->input('projectId'))->where('room_order',$request->input('housingOrder'))->where('name','images[]')->first();

        $projectHousingImagesTemp  = [];

        $projectHousingImages= json_decode($projectHousing->value);

        foreach($projectHousingImages as $key => $image){
            if($key != $request->input('order')){
                array_push($projectHousingImagesTemp,$image);
            }
        }

        ProjectHousing::where('project_id',$request->input('projectId'))->where('room_order',$request->input('housingOrder'))->where('name','images[]')->update(["value" => json_encode($projectHousingImagesTemp)]);

        return json_encode([
            "status" => true
        ]);
    }

    public function addProjectHousingFile(Request $request){
        $project = Project::where('id',$request->input('projectId'))->first();
        $projectHousing = ProjectHousing::where('project_id',$request->input('projectId'))->where('room_order',$request->input('housingOrder'))->where('name','images[]')->first();
        if($projectHousing->value){

            $projectHousingImages= json_decode($projectHousing->value);
        }else{
            $projectHousingImages =[];
        }

        $image = $request->file('file');
        $imageName = $project->slug . '-' . ($request->input('housingOrder')) . '-' . time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('/project_housing_images'), $imageName);

        array_push($projectHousingImages,$imageName);

        ProjectHousing::where('project_id',$request->input('projectId'))->where('room_order',$request->input('housingOrder'))->where('name','images[]')->update(["value" => json_encode($projectHousingImages)]);

        $projectHousing = ProjectHousing::where('project_id',$request->input('projectId'))->where('room_order',$request->input('housingOrder'))->where('name','images[]')->first();
        return json_encode([
            "status" => true,
            "imageName" => $imageName
        ]);
    }

    public function logs($projectId){
        $logs = Log::where('item_type',1)->where('item_id',$projectId)->orderByDesc('created_at')->get();
        return view('institutional.projects.logs',compact('logs'));
    }
}
