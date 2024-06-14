<?php

namespace App\Http\Controllers\Api\Institutional;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CrmController extends Controller
{
    public function index(Request $request){
        $customers = Customer::with("project")->where('was_meeting',$request->input('was_meeting'))->where(function($query) {
            $query->where('user',auth()->guard()->user()->id)
                  ->orWhereNull('user');
        });

        if($request->input('selected_meet_type')){
            $customers = $customers->where('meet_type',$request->input('selected_meet_type'));
        }

        if($request->input('selected_rating')){
            $customers = $customers->where('rating',$request->input('selected_rating'));
        }

        if($request->input('selected_customer_status')){
            $customers = $customers->where('customer_status',$request->input('selected_customer_status'));
        }

        if($request->input('selected_conclusion')){
            $customers = $customers->where('conclusion',$request->input('selected_conclusion'));
        }

        $customers = $customers->get();

        $user = auth()->guard()->user();


        if(auth()->guard()->user()->parent){
            $parentProjects = Project::select(DB::raw('project_title as label , id as value'))->where('user_id',$user->parent->id)->get();
        }else{
            $parentProjects = Project::select(DB::raw('project_title as label , id as value'))->where('user_id',$user->id)->get();
        }
        

        return json_encode([
            "data" => $customers,
            "projects" => $parentProjects
        ]);
    }

    public function update(Request $request,$id){
        $request->validate([
            "key" => "required",
            "value" => "required" 
        ]);

        Customer::where('id',$id)->update([
            $request->input('key') => $request->input('value') 
        ]);

        return json_encode([
            "status" => true
        ]);
    }

    public function show($id){
        $customer = Customer::with("meets","project")->where('id',$id)->first();

        return json_encode([
            "customer" => $customer
        ]);
    }
}
