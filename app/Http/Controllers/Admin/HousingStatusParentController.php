<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HousingTypeParent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class HousingStatusParentController extends Controller
{
    public function index(){
        $housingTypeParent = HousingTypeParent::whereNull('parent_id')->get();
        return view('admin.housing_parent.index',compact('housingTypeParent'));
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

        if($request->input('item_index') != 0){
            $parent = HousingTypeParent::where('slug',$request->input('slug'))->first();
            $parentId = $parent->id;
        }else{
            $parentId = null;
        }

        HousingTypeParent::create([
            "title" => $request->input('dataTitle'),
            "slug" => Str::slug($request->input('dataTitle')),
            "parent_id" => $parentId
        ]);
    
        // Doğrulama başarılıysa
        return response()->json(['success' => true]);
    }
}
