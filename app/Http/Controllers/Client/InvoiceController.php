<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\CartOrder;
use App\Models\Housing;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\User;

class InvoiceController extends Controller
{
    public function show($order)
    {
        $order = CartOrder::where("id", $order)->first();
        $cart = json_decode($order->cart);
        $project = null;
    
        if ($cart->type == "project") {
            $project = Project::where("id", $cart->item->id)->with("brand", "roomInfo", "housingType", "county", "city", 'user.projects.housings', 'user.brands', 'user.housings', 'images')->first();
        } else {
            $project = Housing::where("id", $cart->item->id)->with("user")->first();
        }
        
        $invoice = Invoice::where("order_id", $order->id)->with("order.user","order.bank")->first();
        $data = [
            'invoice' => $invoice,
            'project' => $project,
        ];



        return view('client.invoice.index', compact("data"));
    }
    

}
