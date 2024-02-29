<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Models\PaymentTemp;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class PaymentTempController extends Controller
{
    public function createPaymentTemp(Request $request){
        try{
            DB::beginTransaction();
            $project = Project::where('id',$request->input('project_id'))->first();
            PaymentTemp::create([
                "user_id" => auth()->user()->id,
                "transaction_type" => 1,
                "bank_id" => $request->input('bank_id'),
                "data" => json_encode(["month" => $request->input('month'),"bank_id" => $request->input('bank_id') , "project_id" => $request->input('project_id')]),
                "description" => $project->project_title.' projesinin süresini '.$request->input('month').' ay uzatma',
                "status" => 0
            ]);
            $project->update(["status" => 7]);
            DB::commit();
            
            session()->flash('success', 'Başarıyla projenizin ilan süresini uzattınız.');
            return json_encode([
                "status" => true
            ]);

        }catch(Throwable $e){
            DB::rollback();
            return json_encode([
                "status" => false,
                "message" => $e->getMessage()
            ]);
        }

    }
}
