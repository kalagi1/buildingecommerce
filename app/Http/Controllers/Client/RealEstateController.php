<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\RealEstateForm;
use Illuminate\Http\Request;

class RealEstateController extends Controller
{
    public function index(){
        return view('client.realestate-form.index');
    }

    public function post(Request $request){
        $request->validate([
            'adres' => 'nullable|string',
            'istenilen_fiyat' => 'nullable|string',
            'ilan_aciklamasi' => 'nullable|string',
            // Devam eden özellikleri ekleyin
        ]);
    
        // Validation geçildiyse veriyi kaydet
        RealEstateForm::create($request->all());
    }
}
