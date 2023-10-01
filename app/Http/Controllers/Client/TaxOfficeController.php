<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\TaxOffice;
use Illuminate\Http\Request;

class TaxOfficeController extends Controller
{
    public function getTaxOffice($city)
    {
        $taxOffices = TaxOffice::where('il', $city)->get();
        return response()->json($taxOffices);
    }
}
