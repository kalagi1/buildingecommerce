<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = User::where("id", Auth::user()->id)->with("plan.subscriptionPlan")->first();
        return view('institutional.home.index', compact("user"));
    }
}
