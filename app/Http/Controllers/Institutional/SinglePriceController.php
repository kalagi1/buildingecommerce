<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\SinglePrice;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SinglePriceController extends Controller
{
    public function getSinglePrice(Request $request){
        $singlePrice = SinglePrice::where('month',$request->input('month'))->first();
        $project = Project::where('id',$request->input('selectedProjectId'))->first();
        $newDate = Carbon::parse($project->end_date)->addMonth($request->input('month'));
        return [
            "singlePrice" => $singlePrice,
            "project" => $project,
            "newDate" => $newDate
        ];
    }
}
