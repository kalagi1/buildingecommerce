<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HousingStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HousingStatusController extends Controller
{
    public function index(){
        $housingStatuses = HousingStatus::where("status",1)->get();
        return view('admin.housing_status.index',compact('housingStatuses'));
    }

    public function edit($id){
        $housingStatus = HousingStatus::where('id',$id)->firstOrFail();
        return view('admin.housing_status.edit',compact('housingStatus'));
    }

    public function update(Request $request,$id){
        $housingStatus = HousingStatus::where('id',$id)->firstOrFail();

        $housingStatus->update([
            "name" => $request->input('name'),
            "slug" => Str::slug($request->input('name')),
            "in_dashboard" => $request->input('in_dashboard') ? 1 : 0,
            "status" => $request->input('active') ? 1 : 0,
            "dashboard_order" => $request->input('dashboard_order') ?? null,
        ]);

        return redirect()->route('admin.housing_statuses.index',["status" => "update_statuses"]);
    }
}
