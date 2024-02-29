<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RealEstateForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function iindex(){
        $realEstates = RealEstateForm::orderBy('is_show')->where("user_id",Auth::user()->id)->orderByDesc('created_at')->get();
        return view('institutional.real_estate.index',compact('realEstates'));
    }

    public function idetail($id){
        $realEstate = RealEstateForm::where('id',$id)->where("user_id",Auth::user()->id)->first();

        return view('institutional.real_estate.detail',compact('realEstate'));
    }
}
