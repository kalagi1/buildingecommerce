<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RealEstateForm;
use Illuminate\Http\Request;

class RealEstateController extends Controller
{
    public function index(){
        $realEstates = RealEstateForm::orderBy('is_show')->orderByDesc('created_at')->get();
        return view('admin.real_estate.index',compact('realEstates'));
    }

    public function detail($id){
        $realEstate = RealEstateForm::where('id',$id)->first();

        $realEstate->update([
            "is_show" => 1
        ]);
        return view('admin.real_estate.detail',compact('realEstate'));
    }
}
