<?php

namespace App\Http\Controllers\Api\Institutional;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubuserController extends Controller
{
    public function getSubusers(){
        $subUsers = User::where('parent_id',Auth::user()->id)->get();

        return json_encode([
            "data" => $subUsers
        ]);
    }
}
