<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CrmController extends Controller
{
    public function index(){
        return view('institutional.crm.index');
    }

    public function projectAssigment(){
        return view('institutional.crm.project_assigment');
    }

    public function salesConsultantList(){
        $sales_consultant = User::where('project_authority','on')->get(); 
        $projects = Project::where('status','1')->get();
        // print_r(count($projects));die;
        return view('institutional.sales_consultant.index',compact('sales_consultant','projects'));
    }//End

    public function assignProjectUser(Request $request){
        // print_r($request->all());die;
        $projectIds = $request->projectIds;

        foreach ($projectIds as $projectId) {
            DB::table('project_assigment')->insert([
                'user_id'    => $request->user_id,
                'project_id' => $projectId,
                'created_at' => now()
            ]);
        }
      
      return redirect()->back()->with('success','Proje ataması başarıyla yapıldı.');  
    }//End

    public function assignConsultantCustomer(){
        $excelden_gelen_veriler = DB::table('assigned_user')->get();
        return view('institutional.crm.assign_consultant_customer',compact('excelden_gelen_veriler'));
    }//End
}
