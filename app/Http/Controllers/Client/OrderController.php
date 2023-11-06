<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\HousingStatus;
use App\Models\HousingTypeParent;
use App\Models\Order;
use App\Models\SinglePrice;
use App\Models\TempOrder;
use App\Models\UserPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function getOrders(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response(['message' => 'Oturum bulunamadı'], 404);
        }
        return $user->orders->leftJoin();
    }
    public function createOrder(Request $request)
    {
        $userId = Auth::user()->id;
        if (!$userId) {
            return response(['message' => 'Oturum bulunamadı'], 404);
        }
        $cart = session('cart')['item'];
        $type = session('cart')['type'];
        $orderData = [
            'user_id' => $userId,
            'status' => 1 //status tablosu eklenecek
        ];

        switch ($type) {
            case 'housing':
                $orderData['housing_id'] = $cart['id'];
                break;
            case 'project':
                $orderData['project_id'] = $cart['id'];
                break;
        }
        $order = Order::create($orderData);
        return 'Sipariş Oluştu';
    }
    public function cancelOrder(Request $request, $id)
    {
        $userId = Auth::user()->id;
        if (!$userId) {
            return response(['message' => 'Oturum bulunamadı'], 404);
        }
        $order = Order::find($id);
        $order->status = 0;
        $order->save();
        return 'Sipariş İptal Edildi';
    }

    public function createHousing(){
        $housingTypeParent = HousingTypeParent::whereNull('parent_id')->get();
        $prices = SinglePrice::where('item_type',2)->get();
        $cities = City::get();
        $housing_status = HousingStatus::all();
        $tempDataFull = TempOrder::where('item_type',2)->where('user_id',auth()->guard()->user()->id)->first();
        if($tempDataFull){
            $tempData = json_decode($tempDataFull->data);
        }else{
            $tempData = json_decode("{}");
        }

        if($tempDataFull && isset($tempData->statuses)){
            $selectedStatuses = HousingStatus::whereIn("id",$tempData->statuses)->get();
        }else{
            $selectedStatuses = [];
        }
        if($tempDataFull){
            $tempDataFull = $tempDataFull;
        }else{
            $tempDataFull = json_decode('{"step_order" : 1}');
        }

        $userPlan = UserPlan::where('user_id',auth()->user()->id)->where("status","1")->first();
        return view('client.client-panel.order.create_housing',compact('housingTypeParent','cities','prices','tempData','housing_status','tempDataFull','selectedStatuses','userPlan'));
    }
}
