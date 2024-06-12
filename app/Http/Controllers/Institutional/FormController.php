<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller {
    public function swapApplications() {
        $apps = Form::with("user")->where( 'store_id', Auth::user()->id )->orderBy( 'created_at', 'desc' )->get();
        return view( 'institutional.swaps.index', compact( 'apps' ) );

    }
}
