<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Models\CartOrder;
use App\Models\Housing;
use App\Models\Invoice;
use App\Models\Project;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function show($order)
    {
        return "a";
        $order = CartOrder::where("id", $order)->first();
        $cart = json_decode($order->cart);
        $project = null;

        if ($cart->type == "project") {
            $project = Project::where("id", $cart->item->id)->with("brand", "roomInfo", "housingType", "county", "city", 'user.projects.housings', 'user.brands', 'user.housings', 'images')->first();
        } else {
            $project = Housing::where("id", $cart->item->id)->with("user")->first();
        }

        $invoice = Invoice::where("order_id", $order->id)->with("order.user", "order.bank")->first();
        $data = [
            'invoice' => $invoice,
            'project' => $project,
        ];

        return $order->id;

        return view('institutional.invoice.index', compact("data"));
    }

    public function generatePDF(Request $request)
    {
        $content = $request->input('content');

        return $content;

        // PDF oluştur ve yanıt olarak gönder
        $pdf = PDF::loadHTML($content);
        return $pdf->stream('invoice.pdf');
    }
}
