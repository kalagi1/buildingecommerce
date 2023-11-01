<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HousingType;
use App\Models\HousingTypeParent;
use App\Models\HousingTypeParentConnection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class HousingStatusParentController extends Controller
{
    public function index(){
        $housingTypeParent = HousingTypeParent::whereNull('parent_id')->get();
        $housingTypes = HousingType::get();
        return view('admin.housing_parent.index',compact('housingTypeParent','housingTypes'));
    }

    public function store(Request $request){
        $rules = [
            'dataTitle' => 'required',
        ];
    
        $customMessages = [
            'required' => 'Bu alan zorunludur.',
        ];
    
        $validator = Validator::make($request->all(), $rules, $customMessages);
    
        if ($validator->fails()) {
            // Doğrulama başarısızsa
            $errors = $validator->errors();
            return response()->json(['success' => false, 'errors' => $errors]);
        }

        if($request->input('itemIndex') != 0){
            $parent = HousingTypeParent::where('slug',$request->input('slug'))->first();
            $parentId = $parent->id;
            $isEnd = 1;
        }else{
            $parentId = null;
            $isEnd = 0;
        }

        $parent = HousingTypeParent::create([
            "title" => $request->input('dataTitle'),
            "slug" => Str::slug($request->input('dataTitle')),
            "parent_id" => $parentId,
            "is_end" => $isEnd
        ]);
    
        // Doğrulama başarılıysa
        return response()->json(['success' => true , "data" => $parent]);
    }

    public function destroy(Request $request){
        if($request->input('itemIndex') != 0){
            $parent = HousingTypeParent::where('slug',$request->input('parentSlug'))->first();
            HousingTypeParent::where('slug',$request->slug)->where('slug',$request->input('slug'))->where('parent_id',$parent->id)->delete();
        }else{
            HousingTypeParent::where('slug',$request->slug)->where('slug',$request->input('slug'))->delete();
        }

        return response()->json(['success' => true]);
    }

    public function getHousingParentConnections(Request $request){
        $topParent = HousingTypeParent::where('slug',$request->input('top_slug'))->whereNull('parent_id')->first();
        $parent = HousingTypeParent::where('parent_id',$topParent->id)->where('slug',$request->input('parent_slug'))->first();
        $connections = HousingTypeParentConnection::with("housingType")->where('parent_id',$parent->id)->get();

        return $connections;
    }

    public function addHousingParentConnection(Request $request){
        $topParent = HousingTypeParent::where('slug',$request->input('topSlug'))->whereNull('parent_id')->first();
        $parent = HousingTypeParent::where('parent_id',$topParent->id)->where('slug',$request->input('slug'))->first();

        HousingTypeParentConnection::where('parent_id',$parent->id)->delete();
        foreach($request->input('checkboxes') as $checkbox){
            HousingTypeParentConnection::create([
                "parent_id" => $parent->id,
                "housing_type_id" => $checkbox
            ]);
        }

        $connections = HousingTypeParentConnection::with("housingType")->where('parent_id',$parent->id)->get(); 

        
        return response()->json(['success' => true,"connections" => $connections]);
    }
}
