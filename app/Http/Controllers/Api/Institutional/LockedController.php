<?php

namespace App\Http\Controllers\Api\Institutional;

use App\Http\Controllers\Controller;
use App\Models\Locker;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class LockedController extends Controller
{
    public function getLockeds(Request $request){
        $haveAnyLocker = Locker::where('item_id',$request->input('item_id'))->where('transaction',1)->first();
        $parentId = Auth::user()->parent_id;
        $project = Project::where('id',explode('-',$request->input('item_id'))[0])->first();

        if($project->user_id != Auth::user()->id && !$parentId){
            return json_encode([
                "status" => true,
                "show" => false
            ]);
        }else{
            if(!$parentId){
                return json_encode([
                    "status" => true,
                    "show" => true
                ]);
            }else{
                if($haveAnyLocker){
                    $isLocked = Locker::where('item_id',$request->input('item_id'))->where('transaction',$request->input('transaction'))->where('is_locked',1)->first();
        
                    if($isLocked){
                        return json_encode([
                            "status" => true,
                            "show" => false
                        ]);
                    }else{
                        $showUser = Locker::where('item_id',$request->input('item_id'))->where('transaction',$request->input('transaction'))->where('user_id',Auth::user()->id)->first();
            
                        if($showUser){
                            return json_encode([
                                "status" => true,
                                "show" => true
                            ]);
                        }else{
                            return json_encode([
                                "status" => true,
                                "show" => false
                            ]);
                        }
                        
                    }
                }else{
                    return json_encode([
                        "status" => true,
                        "show" => true
                    ]);
                }
            }
        }
        
        
        
    }

    public function getLockers($projectId,$roomOrder){
        $lockers = Locker::where('item_id',$projectId."-".$roomOrder)->where('transaction',1)->get()->keyBy('user_id')->toArray();

        return json_encode([
            "data" => array_keys($lockers)
        ]);
    }

    public function saveLockers($projectId,$roomOrder,Request $request){
        try{
            Locker::where('item_id',$projectId."-".$roomOrder)->where('transaction',1)->whereNull('is_locked')->delete();

            for($i = 0; $i < count($request->input('selected_subusers')); $i++){
                Locker::create([
                    "item_id" => $projectId."-".$roomOrder,
                    "user_id" => $request->input('selected_subusers')[$i],
                    "transaction" => 1
                ]);
            }

            return json_encode([
                "status" => true
            ]);
        }catch(Throwable $e){
            return json_encode([
                "status" => false,
                "message" => $e->getMessage()
            ]);
        }
    }
    

    public function updateLock($projectId,$roomOrder,Request $request){
        try{
            if($request->input('is_locked')){
                Locker::create([
                    "transaction" => 1,
                    "item_id" => $projectId."-".$roomOrder,
                    "is_locked" => 1
                ]);
            }else{
                Locker::where('is_locked',1)->where('item_id',$projectId."-".$roomOrder)->where("transaction",1)->delete();
            }

            return json_encode([
                "status" => true,
            ]);
        }catch(Throwable $e){
            return json_encode([
                "status" => false,
                "message" => $e->getMessage()
            ]);
        }
    }

    public function getUserLockedInformation($projectId,$roomOrder){
        $haveAnyLocker = Locker::where('item_id',$projectId."-".$roomOrder)->where('transaction',1)->where('is_locked',1)->first();
        $parentId = Auth::user()->parent_id;
        $project = Project::where('id',$projectId)->first();

        if($project->user_id == Auth::user()->id && !$parentId){
            return json_encode([
                "status" => true,
                "is_manager" => true,
                "is_locked" => $haveAnyLocker ? true : false
            ]);
        }else{
            return json_encode([
                "status" => true,
                "is_manager" => false,
                "is_locked" => $haveAnyLocker ? true : false
            ]);
        }
    }
}
