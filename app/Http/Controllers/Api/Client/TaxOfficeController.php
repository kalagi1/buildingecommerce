<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\TaxOffice;
use Illuminate\Http\Request;

class TaxOfficeController extends Controller
{

    public function getTaxOffices(){
        $taxOffices = TaxOffice::all();
        return response()->json($taxOffices);
    }

    public function getTaxOffice($city)
    {
        $taxOffices = TaxOffice::where('il', $city)->get();
        return response()->json($taxOffices);
    }
}
