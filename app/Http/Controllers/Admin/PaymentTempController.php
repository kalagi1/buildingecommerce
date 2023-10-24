<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentTemp;
use Illuminate\Http\Request;

class PaymentTempController extends Controller
{
    public function index(){
        $tempPayments = PaymentTemp::orderBy("status")->get();

        return view('admin.payment_temps.index',compact('tempPayments'));
    }
}
