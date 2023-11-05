<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CartOrder;
use App\Models\Housing;
use App\Models\HousingComment;
use App\Models\Order;
use App\Models\Project;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $countUser = User::where("status", "1")->get()->count();
        $comments = HousingComment::with("user", "housing")->get();
        $clients = User::where("type", "1")->get();
        $institutionals = User::where("type", "2")->get();
        $projects = Project::where("status", "1")->get();
        $passiveProjects = Project::where("status", "0")->get();
        $descProjects = Project::orderBy("id", "desc")->with("user", "city", "county")->limit(4)->get();
        $secondhandHousings = Housing::all();
        return view('admin.home.index', compact("comments", "countUser", "passiveProjects", "clients", "institutionals", "projects", "secondhandHousings", 'descProjects'));
    }

    public function getOrders()
    {
        $cartOrders = CartOrder::with('user')->get();

        return view('admin.orders.index', compact('cartOrders'));
    }

    function approveOrder(CartOrder $cartOrder)
    {
        $cartOrder->update(['status' => '1']);
        return redirect()->back();
    }

    function unapproveOrder(CartOrder $cartOrder)
    {
        $cartOrder->update(['status' => '0']);
        return redirect()->back();
    }

}
