<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CartOrder;
use App\Models\Housing;
use App\Models\HousingComment;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\User;
use App\Models\UserPlan;

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

    public function getPackageOrders()
    {
        $cartOrders = UserPlan::with('user', "subscriptionPlan")->get();

        return view('admin.package-orders.index', compact('cartOrders'));
    }

    public function getOrders()
    {
        $cartOrders = CartOrder::with('user')->get();

        return view('admin.orders.index', compact('cartOrders'));
    }

    public function approveOrder(CartOrder $cartOrder)
    {
        $cartOrder->update(['status' => '1']);
        $cart = json_decode($cartOrder->cart);
        $fatura = new Invoice();
        $fatura->order_id = $cartOrder->id;
        $fatura->total_amount = $cart->item->price;
        $fatura->invoice_number = 'INV-' . time() . $cartOrder->id; // Fatura numarası oluşturabilirsiniz.
        $fatura->save();

        return redirect()->back();
    }

    public function unapproveOrder(CartOrder $cartOrder)
    {
        $cartOrder->update(['status' => '2']);
        return redirect()->back();
    }

    public function approvePackageOrder(UserPlan $userPlan)
    {
        $userPlan->update(['status' => '1']);
        return redirect()->back();
    }

    public function unapprovePackageOrder(UserPlan $userPlan)
    {
        $userPlan->update(['status' => '2']);
        return redirect()->back();
    }

}
