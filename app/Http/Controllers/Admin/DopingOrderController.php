<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DopingOrder;
use Illuminate\Http\Request;

class DopingOrderController extends Controller
{
    
    public function index(){
        $dopingOrders = DopingOrder::orderBy("created_at")->get();

        return view('admin.doping_orders.index',compact('dopingOrders'));
    }

    public function apply($dopingId){
        DopingOrder::where('id',$dopingId)->update([
            "status" => 1
        ]);

        return redirect()->route('admin.doping.orders',["status" => "update_status_apply"]);
    }

    public function unapply($dopingId){
        DopingOrder::where('id',$dopingId)->update([
            "status" => 2
        ]);

        return redirect()->route('admin.doping.orders',["status" => "update_status_unapply"]);
    }
}
