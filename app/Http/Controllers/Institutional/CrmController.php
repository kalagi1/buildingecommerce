<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CrmController extends Controller
{
    public function index(){
        return view('institutional.crm.index');
    }

    public function projectAssigment(){
        return view('institutional.crm.project_assigment');
    }
}
