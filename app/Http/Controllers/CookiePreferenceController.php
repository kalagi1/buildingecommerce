<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CookiePreference;

class CookiePreferenceController extends Controller
{
    public function show($cookie){
        $cookiePrefences = CookiePreference::where("cookie_name", $cookie)->get();
        return response()->json([
            "preferences" => $cookiePrefences
        ]);
    }
}
