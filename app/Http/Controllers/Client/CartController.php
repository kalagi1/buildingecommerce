<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Housing;
use App\Models\Order;
use App\Models\Project;
use App\Models\ProjectHousing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $type = $request->input('type');
        $id = $request->input('id');
        $cartItem = [];
        if ($type == 'project') {
            $project = Project::find($id);
            $price = ProjectHousing::select('value')->where('project_id', $id)->where('key', 'Fiyat')->first()['value'];
            $image = ProjectHousing::select('value')->where('project_id', $id)->where('key', 'Kapak Resmi')->first()['value'];
            $cartItem = [
                'id' => $project->id,
                'city' => $project->city->title,
                'address' => $project->address,
                'title' => $project->project_title,
                'price' => $price,
                'image' => asset('project_housing_images/' . $image),
            ];
        } else if ($type == 'housing') {
            $housing = Housing::find($id);
            $housingData = json_decode($housing->housing_type_data);

            $cartItem = [
                'id' => $housing->id,
                'city' => $housing->city['title'],
                'address' => $housing->address,
                'title' => $housing->title,
                'price' => $housingData->price[0],
                'image' => asset('housing_images/' . json_decode($housingData->images)[0]),
            ];

        }
        // Find the product in the database

        if (!$cartItem) {
            return response(['message' => 'fail']);
        }

        $cart = $request->session()->get('cart', []); // Get cart data from session

        // Eğer sepeti temizlemeyi onaylamışsa, mevcut sepeti temizleyin
        if ($request->input('clear_cart') === 'yes') {
            $request->session()->forget('cart');
        }

        // Add a new product to the cart
        $cart = [
            'item' => $cartItem,
            'type' => $type,
        ];

        $request->session()->put('cart', $cart); // Save cart data to session

        return response(['message' => 'success']);
    }

    public function clear(Request $request)
    {
        $request->session()->forget('cart'); // Clear the cart

        return redirect()->route('cart')->with('success', 'Cart cleared');
    }

    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);

        return view('client.cart.index', compact('cart'));
    }

    public function removeFromCart(Request $request)
    {
        $request->session()->forget('cart'); // Clear the cart
        return redirect()->route('cart')->with('success', 'Cart cleared');

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
            'status' => 1, //status tablosu eklenecek
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

}
