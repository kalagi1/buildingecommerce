<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
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
}
