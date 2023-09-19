<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Models\PricingStandOut;
use App\Models\StandOutUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyController extends Controller
{
    public function buyOrder(Request $request)
    {
        $checkDate = StandOutUser::where('start_date', '>', $request->input('start_date'))
            ->where('start_date', "<=", $request->input('end_date'))
            ->where('item_order', $request->input('order'))
            ->first();

        if ($checkDate) {
            return json_encode([
                "status" => false,
                "message" => "Belirttiğiniz tarihler arasında istediğiniz sıra doludur",
            ]);
        } else {
            StandOutUser::create([
                "user_id" => Auth::user()->id,
                "project_id" => $request->input('project_id'),
                "start_date" => $request->input('start_date'),
                "end_date" => $request->input('end_date'),
                "item_order" => $request->input('order'),
            ]);

            PricingStandOut::where('type', 1)
                ->where('order', $request->input('order'))
                ->update([
                    "status" => 1,
                ]);

            return json_encode([
                "status" => true,
                "message" => "Başarıyla istediğiniz alanı ayırttınız",
            ]);
        }
    }
}
