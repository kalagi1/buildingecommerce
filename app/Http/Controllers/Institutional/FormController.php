<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{
    public function swapApplications(){
        $apps = Form::where("store_id", Auth::user()->id)->get();
        return view('institutional.swaps.index', compact('apps'));

    }
}
