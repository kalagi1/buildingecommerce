<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\CustomMail;
use App\Models\BankAccount;
use App\Models\CartOrder;
use App\Models\EmailTemplate;
use App\Models\Housing;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Project;
use App\Models\ProjectHousing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    // public function add(Request $request)
    // {
    //     $type = $request->input('type');
    //     $id = $request->input('id');
    //     $project = $request->input('project');

    //     $cartItem = [];
    //     if ($type == 'project') {
    //         $project = Project::find($project);
    //         $price = ProjectHousing::select('value')->where('project_id', $project)->where('room_order', $id)->where('key', 'Fiyat')->first()['value'];
    //         $image = ProjectHousing::select('value')->where('project_id', $project)->where('room_order', $id)->where('key', 'Kapak Resmi')->first()['value'];
    //         $cartItem = [
    //             'id' => $id,
    //             'project' => $project->id,
    //             'city' => $project->city->title,
    //             'address' => $project->address,
    //             'title' => $project->project_title,
    //             'price' => $price,
    //             'image' => asset('project_housing_images/' . $image),
    //         ];
    //     } else if ($type == 'housing') {
    //         $housing = Housing::find($id);
    //         $housingData = json_decode($housing->housing_type_data);

    //         $cartItem = [
    //             'id' => $housing->id,
    //             'city' => $housing->city['title'],
    //             'address' => $housing->address,
    //             'title' => $housing->title,
    //             'price' => $housingData->price[0],
    //             'image' => asset('housing_images/' . json_decode($housingData->images)[0]),
    //         ];

    //     }
    //     // Find the product in the database

    //     if (!$cartItem) {
    //         return response(['message' => 'fail']);
    //     }

    //     $cart = $request->session()->get('cart', []); // Get cart data from session

    //     // Eğer sepeti temizlemeyi onaylamışsa, mevcut sepeti temizleyin
    //     if ($request->input('clear_cart') === 'yes') {
    //         $request->session()->forget('cart');
    //     }

    //     // Add a new product to the cart
    //     $cart = [
    //         'item' => $cartItem,
    //         'type' => $type,
    //     ];

    //     $request->session()->put('cart', $cart); // Save cart data to session

    //     return response(['message' => 'success']);
    // }

    public function payCart(Request $request)
    {
        if (!$request->session()->get('cart')) {
            return redirect()->back()->withErrors(['pay' => 'Sepet boş.']);
        }

        $order = new CartOrder;
        $order->user_id = auth()->user()->id;
        $order->bank_id = $request->input("banka_id");

        $order->amount = str_replace(',', '.', number_format(floatval(str_replace('.', '', $request->session()->get('cart')['item']['price'] - $request->session()->get('cart')['item']['discount_amount'])) * 0.01, 0, ',', '.'));
        $order->cart = json_encode($request->session()->get('cart'));
        $order->status = '0';
        $order->key = $request->input("key");
        $order->save();

        $user = User::where("id", auth()->user()->id)->first();
        $BuyCart = EmailTemplate::where('slug', "buy-cart")->first();

        if (!$BuyCart) {
            return response()->json([
                'message' => 'Email template not found.',
                'status' => 203,
                'success' => true,
            ], 203);
        }

        $BuyCartContent = $BuyCart->body;

        $buyCartVariables = [
            'username' => $user->name,
            'companyName' => "Emlak Sepeti",
            "email" => $user->email,
            "token" => $user->email_verification_token,
        ];

        foreach ($buyCartVariables as $key => $value) {
            $BuyCartContent = str_replace("{{" . $key . "}}", $value, $BuyCartContent);
        }

        Mail::to($user->email)->send(new CustomMail($BuyCart->subject, $BuyCartContent));
        $cartOrder = CartOrder::where("id", $order->id)->with("bank")->first();

        $NewOrder = EmailTemplate::where('slug', "new-order")->first();

        if (!$NewOrder) {
            return response()->json([
                'message' => 'Email template not found.',
                'status' => 203,
                'success' => true,
            ], 203);
        }

        $NewOrderContent = $NewOrder->body;

        $admins = User::where("type", "3")->get();

        foreach ($admins as $key => $admin) {
            $NewOrderVariables = [
                "adminName" => $admin->name,
                'customerName' => $user->name,
                'paymentDate' => $cartOrder->created_at,
                'paymentTotalAmount' => $cartOrder->amount,
                'bankAccount' => $cartOrder->bank->receipent_full_name,
                'companyName' => "Emlak Sepeti",
                "email" => $user->email,
                "token" => $user->email_verification_token,
            ];

            foreach ($NewOrderVariables as $key => $value) {
                $NewOrderContent = str_replace("{{" . $key . "}}", $value, $NewOrderContent);
            }

            Mail::to($admin->email)->send(new CustomMail($NewOrder->subject, $NewOrderContent));
        }

        session()->forget('cart');

        return redirect()->route('client.pay.success', ['cart_order' => $order->id]);
    }

    public function paySuccess(Request $request, CartOrder $cart_order)
    {
        return view('client.cart.pay-success', compact('cart_order'));
    }

    public function add(Request $request)
    {
        try {

            $type = $request->input('type');
            $id = $request->input('id');
            $project = $request->input('project');

            $cartItem = [];

            $cart = $request->session()->get('cart', []); // Get cart data from session
            http_response_code(500);
            if ($cart && (($type == 'housing' && $cart['item']['id'] == $id) || ($type == 'project' && $cart['item']['housing'] == $id))) {
                $request->session()->forget('cart');
            } else {
                if ($type == 'project') {
                    $discount_amount = Offer::where('type', 'project')->where('project_id', $project)->where('start_date', '<=', date('Y-m-d H:i:s'))->where('end_date', '>=', date('Y-m-d H:i:s'))->first()->discount_amount ?? 0;
                    $project = Project::find($project);
                    $projectHousing = ProjectHousing::where('project_id', $project->id)
                        ->where('room_order', $id)
                        ->whereIn('key', ['Fiyat', 'Kapak Resmi'])
                        ->get()
                        ->keyBy('key');

                    $price = $projectHousing['Fiyat']->value;
                    $image = $projectHousing['Kapak Resmi']->value;
                    $cartItem = [
                        'id' => $project->id,
                        'housing' => $id,
                        'city' => $project->city->title,
                        'address' => $project->address,
                        'title' => $project->project_title,
                        'price' => $price,
                        'image' => asset('project_housing_images/' . $image),
                        'discount_amount' => $discount_amount,
                    ];
                } else if ($type == 'housing') {
                    $discount_amount = Offer::where('type', 'housing')->where('housing_id', $id)->where('start_date', '<=', date('Y-m-d H:i:s'))->where('end_date', '>=', date('Y-m-d H:i:s'))->first()->discount_amount ?? 0;
                    $housing = Housing::find($id);
                    $housingData = json_decode($housing->housing_type_data);

                    $cartItem = [
                        'id' => $housing->id,
                        'city' => $housing->city['title'],
                        'address' => $housing->address,
                        'title' => $housing->title,
                        'price' => $housingData->price[0],
                        'image' => asset('housing_images/' . $housingData->images[0]),
                        'discount_amount' => $discount_amount,
                    ];

                }

                if (!$cartItem) {
                    return response(['message' => 'fail']);
                }

                $cart = [
                    'item' => $cartItem,
                    'type' => $type,
                ];


                $request->session()->put('cart', $cart); // Save cart data to session
                return response(['message' => 'success']);

            }

        } catch (\Exception $e) {
            // Handle exceptions if any
            return response(['message' => 'error', 'error' => $e->getMessage()], 500);
        }
    }

    public function clear(Request $request)
    {
        $request->session()->forget('cart'); // Clear the cart

        return redirect()->route('cart')->with('success', 'Cart cleared');
    }

    public function index(Request $request)
    {
        $bankAccounts = BankAccount::all();
        $cart = $request->session()->get('cart', []);
        return view('client.cart.index', compact('cart', "bankAccounts"));
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
