<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CartItem;
use App\Models\CartOrder;
use App\Models\Project;
use App\Models\Housing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Invoice;
use App\Mail\CustomMail;
use App\Models\CartPrice;
use App\Models\Click;
use App\Models\Collection;
use App\Models\Coupon;
use App\Models\DocumentNotification;
use App\Models\EmailTemplate;
use App\Models\NeighborView;
use App\Models\SharerPrice;
use App\Models\UseCoupon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use App\Models\NeighborPayment;
use App\Models\Rate;

class PayController extends Controller
{
    public function pay(Request $request){
        $requestData = $request->all();
        $requestData['creditcard'] = $request->input('card_number');
        $amount = $request->input('amount');
        $transaction = $this->createTransaction();

        $data = $this->preparePaymentData($requestData, 1, $amount, $transaction);
        return $data;
        return view('payment.pay-mobil', $data);
    }

    public function resultPaymentSuccess(Request $request)
    {
        $data = $request->all();


        $existingOrder = CartOrder::where('transaction', $data['ReturnOid'])->first();

        if ($existingOrder) {

            $user = $existingOrder->user;
            if ($user) {
                Auth::login($user);
                $existingOrderId = $existingOrder->id;

                $this->approveOrder($existingOrder);

                session()->forget('cart');
                //cart_items tablosundan kullanıcıya ait sepet verisini sil
                $cartItem = DB::table('cart_items')->where('user_id', Auth::id())->first();
                if ($cartItem) {
                    DB::table('cart_items')->where('id', $cartItem->id)->delete();
                }
                return redirect()->route('pay.success', ['cart_order' => $existingOrderId]);
            }
        }

        return redirect()->route('client.login');
    }


    public function resultPaymentFail(Request $request)
    {
        $data = $request->all();
        dd($data);
        $existingOrder = CartOrder::where('transaction', $data['oid'])->first();


        if ($existingOrder) {
            // Siparişi bulduysanız, bu siparişe ait kullanıcıyı alın
            $user = $existingOrder->user;

            if ($user) {
                // Kullanıcıyı oturum açın
                Auth::login($user);

                // Kullanıcıyı oturum açtıktan sonra hata mesajı ile birlikte ödeme sayfasına yönlendirin
                return redirect()->route('payment.index', ['userId' => $user->id])->with('error', 'Ödeme işlemi başarısız oldu.');
            }
        }

        // Kullanıcı veya sipariş bulunamazsa, giriş sayfasına yönlendirin veya başka bir işlem yapın
        return redirect()->route('client.login');
    }


    /**
     * Private start
     */

    private function createTransaction()
    {
        // Benzersiz bir UUID oluştur
        $transaction = Str::uuid();

        // Bu benzersiz değeri kullanarak işlem yapabilirsiniz

        return $transaction;
    }

    private function preparePaymentData($requestData, $orderId, $amount, $transaction)
    {

        $clientId = '190100000';
        $storeKey = '123456';
        $expDateMonth = $requestData['month'];
        $expDateYear = $requestData['year'];
        $okUrl = url('/resultpaymentsuccess');
        $failUrl = url('/resultpaymentfail');
        $callbackUrl = url('/resultpaymentsuccess');
        // $url = url('/resultpayment');
        $transactionType = 'Auth';
        $rnd = '5';
        $storetype = '3d_pay_hosting';
        $hashAlgorithm = 'ver3';
        $currency = '949';
        $lang = 'tr';

        $creditCardNumbers = $requestData['creditcard'];


        $data = [
            'amount' => $amount,
            'callbackurl' =>  $callbackUrl,
            'clientid' => $clientId,
            'currency' => $currency,
            'Ecom_Payment_Card_ExpDate_Year' =>  $expDateYear,
            'Ecom_Payment_Card_ExpDate_Month' => $expDateMonth,
            'failurl' =>  $failUrl,
            'hashAlgorithm' => $hashAlgorithm,
            'islemtipi' => $transactionType,
            'lang' => $lang,
            'oid' => $transaction,
            'okurl' => $okUrl,
            'pan' => $creditCardNumbers,
            'rnd' => $rnd,
            'storetype' => $storetype,
            'taksit'  => '',
        ];

        $order = [
            'amount', 'callbackurl', 'clientid', 'currency', 'Ecom_Payment_Card_ExpDate_Month', 'Ecom_Payment_Card_ExpDate_Year', 'failurl', 'hashAlgorithm',
            'islemtipi', 'lang', 'oid', 'okurl', 'pan', 'rnd', 'storetype', 'taksit'
        ];

        $sortedValues = array_map(function ($key) use ($data) {
            return $data[$key];
        }, $order);

        $hashString = implode('|', $sortedValues) . '|';
        $hashString .= str_replace('|', '\\|', str_replace('\\', '\\\\', $storeKey));
        $calculatedHashValue = hash('sha512', $hashString);
        $actualHash = base64_encode(pack('H*', $calculatedHashValue));
        $data['hash'] = $actualHash;

        return $data;
    }


    private function getUserId($requestData)
    {
        $user = Auth::user();
        return $user->id;
    }

    private function getStoreId($requestData)
    {
        $cartArray = json_decode($requestData['cart'], true);
        if ($cartArray['type'] === 'project') {
            $project = Project::where('id', $cartArray['item']['id'])->first();
            return $project->user->id;
        } else {
            $housing = Housing::where('id', $cartArray['item']['id'])->first();
            return $housing->user_id;
        }
    }

    private function calculatePayableAmount($requestData)
    {
        return $requestData['payable_amount'];
    }


    private function createCartOrder($request, $transaction)
    {
        $cartItem = CartItem::where('user_id', Auth::user()->id)->latest()->first();

        if ($cartItem) {
            $cartOrder = $this->payCart($request, $cartItem, $transaction);
        }

        return $cartOrder;
    }

    private function getOrderId($cartOrder)
    {
        return $cartOrder->id;
    }



    public function approveOrder($cartOrder)
    {
        $cartOrder->update(['status' => '1']);
        $cart = json_decode($cartOrder->cart);

        $fatura = new Invoice();
        $fatura->order_id = $cartOrder->id;
        $fatura->total_amount = $cart->item->price;
        $fatura->invoice_number = 'FTR-' . time() . $cartOrder->id;
        // Fatura numarası oluşturabilirsiniz.
        $fatura->save();

        if ($cart->type == 'housing') {
            $estate = Housing::where('id', $cart->item->id)->with('user')->first();
        } else {
            $estate = Project::where('id', $cart->item->id)->with('user')->first();
            $isNeighbor = NeighborView::where('owner_id', $cartOrder->is_reference)
                ->where('project_id', $estate->id)
                ->where('user_id', $cartOrder->user_id)
                ->where('status', 1)
                ->first();

            $neighborPaymentData = [
                'user_id' => $cartOrder->is_reference,
                'payment' => '125', // Ödeme miktarını uygun bir şekilde güncelleyin
                'neighborview_id' => $isNeighbor ? $isNeighbor->id : null,
            ];

            NeighborPayment::create($neighborPaymentData);
        }

        $user = User::where('id', $cartOrder->user_id)->first();
        $newSeller = EmailTemplate::where('slug', 'new-seller')->first();

        if ($newSeller) {
            $newSellerContent = $newSeller->body;

            $newSellerVariables = [
                'customerName' => $user->name,
                'customerEmail' => $user->email,
                'salesAmount' => $cartOrder->amount,
                'salesDate' => $cartOrder->created_at->format('d/m/Y'),
                'companyName' => 'Emlak Sepette',
                'orderNo' =>  $cartOrder->id,
                'housingNo' => $cartOrder->key,
                'email' => $user->email,
                'token' => $user->email_verification_token,
                'storeOwnerName' => $estate ? $estate->user->name : '',
                'invoiceLink' => route('institutional.invoice.show', $cartOrder->id),
            ];

            foreach ($newSellerVariables as $key => $value) {
                $newSellerContent = str_replace('{{' . $key . '}}', $value, $newSellerContent);
            }

            Mail::to($estate->user->email)->send(new CustomMail($newSeller->subject, $newSellerContent));

            DocumentNotification::create([
                'user_id' => $user->id,
                'text' => '#' . $cartOrder->id . " No'lu siparişiniz onaylandı. Fatura detayları için tıklayın.",
                'item_id' => $cartOrder->id,
                'link' => $user->type == '1' ? route('institutional.invoice.show', $cartOrder->id) : route('institutional.invoice.show', $cartOrder->id),
                'owner_id' => $user->id,
                'is_visible' => true,
            ]);
        }

        // Apply Payment Order Email to User
        $applyPaymentOrder = EmailTemplate::where('slug', 'apply-payment-order')->first();

        if ($applyPaymentOrder) {

            $applyPaymentOrderContent = $applyPaymentOrder->body;

            $applyPaymentOrderVariables = [
                'salesAmount' => $cartOrder->amount  . ' ₺',
                'orderNo' => $cartOrder->id,
                'username' => $user->name,
                'salesDate' => $cartOrder->created_at->format('d/m/Y'),
                'companyName' => 'Emlak Sepette',
                'email' => $user->email,
                'invoiceLink' =>   route('institutional.invoice.show', $cartOrder->id),
                'token' => $user->email_verification_token,
                'invoiceLink' => route('institutional.invoice.show', $cartOrder->id),
            ];

            foreach ($applyPaymentOrderVariables as $key => $value) {
                $applyPaymentOrderContent = str_replace('{{' . $key . '}}', $value, $applyPaymentOrderContent);
            }

            Mail::to($user->email)->send(new CustomMail($applyPaymentOrder->subject, $applyPaymentOrderContent));

            $admins = User::where('type', '3')->get();
            foreach ($admins as $admin) {
                DocumentNotification::create([
                    'user_id' => $admin->id,
                    'text' => '#' . $cartOrder->id . " No'lu emlak siparişi onaylandı.",
                    'item_id' => $cartOrder->id,
                    'link' => route('admin.orders'),
                    'owner_id' => 4,
                    'is_visible' => true,
                ]);
            }
        }
    }

    public function payCart($request, $cartItem, $transaction)
    {



        function getHouse($project, $key, $roomOrder)
        {
            foreach ($project->roomInfo as $room) {
                if ($room->room_order == $roomOrder && $room->name == $key) {
                    return $room;
                }
            }
        }

        $hasReference = null;
        $isReference = null;

        if ($request->input('reference_code')) {
            $hasReference = User::where('code', $request->input('reference_code'))->first();
        }
        if ($request->input('is_reference')) {
            $isReference = User::where('id', $request->input('is_reference'))->first();
        }

        $lastClick = Click::where('user_id', auth()->user()->id)
            ->where('created_at', '>=', now()->subDays(24))
            ->latest('created_at')
            ->first();

        $cartJson = json_decode($cartItem->cart, true);
        $order = new CartOrder;

        $order->user_id = auth()->user()->id;
        $order->bank_id = '2';
        $amountWithoutDiscount =  $cartJson['item']['amount'] - $cartJson['item']['discount_amount'];
        $haveDiscount = false;

        if ($request->input('have_discount')) {
            $coupon = Coupon::where(

                function ($query) {
                    $query->where(

                        function ($query) {
                            $query->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'));
                        }
                    )->orWhere('time_type', 1);
                }
            )->where('coupon_code', $request->input('discount'))->where('use_count', '>=', 1)->first();

            $cartItem = CartItem::where('user_id', Auth::user()->id)->latest()->first();

            $cart = json_decode($cartItem->cart, true);
            $deposit_rate = 0.02;
            if ($cart['type'] == 'housing') {
                $housing = Housing::where('id', $cart['item']['id'])->first();
                $saleType = $housing->step2_slug;
                $deposit_rate = 0.02;
            } else {
                $project = Project::where('id', $cart['item']['id'])->first();
                $saleType = $project->step2_slug;
                $deposit_rate = $project->deposit_rate / 100;
            }


            if ($saleType == 'kiralik') {
                if ($coupon) {
                    if ($cart['type'] == 'housing') {
                        if ($coupon->select_housings_type == 1) {
                            $haveDiscount = true;
                            if ($coupon->discount_type == 1) {
                                $amount = $amountWithoutDiscount - ($amountWithoutDiscount * ($coupon->amount / 100));
                                $amount = number_format($amount, 2, ',', '.');
                            } else {
                                $amount = $amountWithoutDiscount - $coupon->amount;
                                $amount = number_format($amount, 2, ',', '.');
                            }
                        } else if ($coupon->select_housings_type == 2) {
                            $couponHousings = array_keys($coupon->housings->keyBy('item_id')->toArray());
                            if (in_array($cart['item']['id'], $couponHousings)) {
                                $haveDiscount = true;
                                if ($coupon->discount_type == 1) {
                                    $amount = $amountWithoutDiscount - ($amountWithoutDiscount * ($coupon->amount / 100));
                                    $amount = number_format($amount, 2, ',', '.');
                                } else {
                                    $amount = $amountWithoutDiscount - $coupon->amount;
                                    $amount = number_format($amount, 2, ',', '.');
                                }
                            } else {
                                $discountRate = floatval($cartJson['item']['discount_rate'] ?? 0);
                                $amount = $amountWithoutDiscount - ($amountWithoutDiscount * ($discountRate / 100));
                                $amount = number_format($amount, 2, ',', '.');
                            }
                        } else {
                            $discountRate = floatval($cartJson['item']['discount_rate'] ?? 0);
                            $amount = $amountWithoutDiscount - ($amountWithoutDiscount * ($discountRate / 100));
                            $amount = number_format($amount, 2, ',', '.');
                        }
                    } else {
                        if ($coupon->select_projects_type == 1) {
                            if ($coupon->discount_type == 1) {
                                $haveDiscount = true;
                                $amount = $amountWithoutDiscount - ($amountWithoutDiscount * ($coupon->amount / 100));
                                $amount = number_format($amount, 2, ',', '.');
                            } else {
                                $amount = $amountWithoutDiscount - $coupon->amount;
                                $amount = number_format($amount, 2, ',', '.');
                            }
                        } else if ($coupon->select_projects_type == 2) {
                            $couponProjects = array_keys($coupon->projects->keyBy('item_id')->toArray());
                            if (in_array($cart['item']['id'], $couponProjects)) {
                                $haveDiscount = true;
                                if ($coupon->discount_type == 1) {
                                    $amount = $amountWithoutDiscount - ($amountWithoutDiscount * ($coupon->amount / 100));
                                    $amount = number_format($amount, 2, ',', '.');
                                } else {
                                    $amount = $amountWithoutDiscount - $coupon->amount;
                                    $amount = number_format($amount, 2, ',', '.');
                                }
                            } else {
                                $discountRate = floatval($cartJson['item']['discount_rate'] ?? 0);
                                $amount = $amountWithoutDiscount - ($amountWithoutDiscount * ($discountRate / 100));
                                $amount = number_format($amount, 2, ',', '.');
                            }
                        } else {
                            $discountRate = floatval($cartJson['item']['discount_rate'] ?? 0);
                            $amount = $amountWithoutDiscount - ($amountWithoutDiscount * ($discountRate / 100));
                            $amount = number_format($amount, 2, ',', '.');
                        }
                    }
                } else {
                    $discountRate = floatval($cartJson['item']['discount_rate'] ?? 0);
                    $amount = $amountWithoutDiscount - ($amountWithoutDiscount * ($discountRate / 100));
                    // dd( $amount );
                    $amount = number_format($amount, 2, ',', '.');
                }
            } else {
                if ($coupon) {
                    if ($cart['type'] == 'housing') {
                        if ($coupon->select_housings_type == 1) {
                            $haveDiscount = true;
                            if ($coupon->discount_type == 1) {
                                $amount = $amountWithoutDiscount - ($amountWithoutDiscount * ($coupon->amount / 100));
                                $amount = number_format($amount * $deposit_rate, 2, ',', '.');
                            } else {
                                $amount = $amountWithoutDiscount - $coupon->amount;
                                $amount = number_format($amount * $deposit_rate, 2, ',', '.');
                            }
                        } else if ($coupon->select_housings_type == 2) {
                            $couponHousings = array_keys($coupon->housings->keyBy('item_id')->toArray());
                            if (in_array($cart['item']['id'], $couponHousings)) {
                                $haveDiscount = true;
                                if ($coupon->discount_type == 1) {
                                    $amount = $amountWithoutDiscount - ($amountWithoutDiscount * ($coupon->amount / 100));
                                    $amount = number_format($amount * $deposit_rate, 2, ',', '.');
                                } else {
                                    $amount = $amountWithoutDiscount - $coupon->amount;
                                    $amount = number_format($amount * $deposit_rate, 2, ',', '.');
                                }
                            } else {
                                $discountRate = floatval($cartJson['item']['discount_rate'] ?? 0);
                                $amount = $amountWithoutDiscount - ($amountWithoutDiscount * ($discountRate / 100));
                                $amount = number_format($amount * $deposit_rate, 2, ',', '.');
                            }
                        } else {
                            $discountRate = floatval($cartJson['item']['discount_rate'] ?? 0);
                            $amount = $amountWithoutDiscount - ($amountWithoutDiscount * ($discountRate / 100));
                            $amount = number_format($amount * $deposit_rate, 2, ',', '.');
                        }
                    } else {
                        if ($coupon->select_projects_type == 1) {
                            if ($coupon->discount_type == 1) {
                                $haveDiscount = true;
                                $amount = $amountWithoutDiscount - ($amountWithoutDiscount * ($coupon->amount / 100));
                                $amount = number_format($amount * $deposit_rate, 2, ',', '.');
                            } else {
                                $amount = $amountWithoutDiscount - $coupon->amount;
                                $amount = number_format($amount * $deposit_rate, 2, ',', '.');
                            }
                        } else if ($coupon->select_projects_type == 2) {
                            $couponProjects = array_keys($coupon->projects->keyBy('item_id')->toArray());
                            if (in_array($cart['item']['id'], $couponProjects)) {
                                $haveDiscount = true;
                                if ($coupon->discount_type == 1) {
                                    $amount = $amountWithoutDiscount - ($amountWithoutDiscount * ($coupon->amount / 100));
                                    $amount = number_format($amount * $deposit_rate, 2, ',', '.');
                                } else {
                                    $amount = $amountWithoutDiscount - $coupon->amount;
                                    $amount = number_format($amount * $deposit_rate, 2, ',', '.');
                                }
                            } else {
                                $discountRate = floatval($cartJson['item']['discount_rate'] ?? 0);
                                $amount = $amountWithoutDiscount - ($amountWithoutDiscount * ($discountRate / 100));
                                $amount = number_format($amount * $deposit_rate, 2, ',', '.');
                            }
                        } else {
                            $discountRate = floatval($cartJson['item']['discount_rate'] ?? 0);
                            $amount = $amountWithoutDiscount - ($amountWithoutDiscount * ($discountRate / 100));
                            $amount = number_format($amount * $deposit_rate, 2, ',', '.');
                        }
                    }
                } else {
                    $discountRate = floatval($cartJson['item']['discount_rate'] ?? 0);
                    $amount = $amountWithoutDiscount - ($amountWithoutDiscount * ($discountRate / 100));
                    $amount = number_format($amount * $deposit_rate, 2, ',', '.');
                }
            }
        } else {
            $cartItem = CartItem::where('user_id', Auth::user()->id)->latest()->first();

            $cart = json_decode($cartItem->cart, true);
            $deposit_rate = 0.02;
            if ($cart['type'] == 'housing') {
                $housing = Housing::where('id', $cart['item']['id'])->first();
                $saleType = $housing->step2_slug;
                $deposit_rate = 0.02;
            } else {
                $project = Project::where('id', $cart['item']['id'])->first();
                $saleType = $project->step2_slug;
                $deposit_rate = $project->deposit_rate / 100;
            }

            if ($saleType == 'kiralik') {
                $discountRate = floatval($cartJson['item']['discount_rate'] ?? 0);
                $amount = $amountWithoutDiscount - ($amountWithoutDiscount * isset($lastClick) ?  ($discountRate / 100) : 0);
                $amount = number_format($amount, 2, ',', '.');
            } else {
                $discountRate = floatval($cartJson['item']['discount_rate'] ?? 0);
                if (isset($lastClick)) {
                    $discountX = $amountWithoutDiscount * ($discountRate / 100);
                } else {
                    $discountX = 0;
                }
                $amount = $amountWithoutDiscount - $discountX;

                $amount = number_format($amount * $deposit_rate, 2, ',', '.');
            }
        }
        $order->amount = $amount;
        $order->cart = json_encode($cartJson);
        $order->status = '0';
        $order->key = $request->input('key');
        $order->is_show_user = $request->input('is_show_user');
        $order->full_name = $request->input('fullName');
        $order->email = $request->input('email');
        $order->phone = $request->input('phone');
        $order->address = $request->input('address');
        $order->tc = $request->input('tc');
        $order->notes = $request->input('notes');
        $order->reference_id = $hasReference ? $hasReference->id : null;
        $order->is_reference = $isReference ? $isReference->id : null;
        $order->transaction = $transaction;
        if (isset($cartJson['item']['payment-plan'])) {
            $order->is_swap = $cartJson['item']['payment-plan'] == 'pesin' ? 0 : 1;
        } else {
            $order->is_swap = 0;
        }
        $order->save();

        $cartOrder = CartOrder::where('id', $order->id)->with('bank')->first();
        $o = json_decode($cartOrder);
        $productDetails = json_decode($o->cart)->item;
        if (json_decode($o->cart)->type == 'housing') {
            $housingTypeImage = asset('housing_images/' . json_decode(Housing::find($productDetails->id ?? 0)->housing_type_data ?? '[]')->image ?? null);
            $city = Housing::find($productDetails->id ?? 0)->city->title;
            $county = Housing::find($productDetails->id ?? 0)->county->title;
            $neighborhood = Housing::find($productDetails->id ?? 0)->neighborhood->mahalle_title ? Housing::find($productDetails->id ?? 0)->neighborhood->mahalle_title : null;
            $code = Housing::find($productDetails->id ?? 0)->id + 2000000;
            $store = Housing::find($productDetails->id ?? 0)->user->name;
            $storeID = Housing::find($productDetails->id ?? 0)->user->id;
            $room = null;

            if ($haveDiscount) {
                if ($coupon->discount_type == 1) {
                    $newAmount = $amountWithoutDiscount - ($amountWithoutDiscount * ($coupon->amount / 100));
                } else {
                    $newAmount = $amountWithoutDiscount - $coupon->amount;
                }

                $housing = Housing::where('id', $cart['item']['id'])->first();
                $user = User::where('id', $housing->user_id)->first();
                $rates = Rate::where("housing_id", $cart['item']['id'])->get();

                foreach ($rates as $key => $rate) {
                    if ($user->corporate_type == $rate->institution->name) {
                        $share_percent_earn =  $rate->default_deposit_rate;
                        $share_percent_balance = 1.0 - $share_percent_earn;
                    }
                }

                if ($saleType == 'kiralik') {
                    $sharedAmount_balance = $newAmount * $share_percent_balance;
                    $sharedAmount_earn = $newAmount * $share_percent_earn;
                } else {
                    $sharedAmount_balance = $newAmount * $deposit_rate * $share_percent_balance;
                    $sharedAmount_earn = $newAmount * $deposit_rate * $share_percent_earn;
                }

                UseCoupon::create([
                    'order_id' => $order->id,
                    'coupon_id' => $coupon->id,
                ]);

                $coupon->update([
                    'use_count' => $coupon->use_count - 1,
                ]);

                if ($coupon->user_id != Auth::user()->id) {
                    $sales_rate_club = null; // Başlangıçta boş veya null değer

                    foreach ($rates as $rate) {
                        if ($coupon->user->corporate_type == $rate->institution->name) {
                            // Eğer kullanıcı kurumsal türü ile oranlar eşleşirse, `sales_rate_club` değerini atayın
                            $sales_rate_club = $rate->sales_rate_club;

                            break; // Eşleşme bulunduğunda döngüyü sonlandırın
                        }
                    }

                    // Eşleşme yoksa, son oran kaydının `sales_rate_club` değerini kullanın
                    if ($sales_rate_club === null && count($rates) > 0) {
                        $sales_rate_club = $rates->last()->sales_rate_club;
                    }

                    $estateclubrate = $sharedAmount_earn * $sales_rate_club;
                    $remaining = $sharedAmount_earn - $estateclubrate;


                    SharerPrice::create([
                        'user_id' => $coupon->user_id,
                        'cart_id' => $order->id,
                        'status' => '1',
                        'balance' => $estateclubrate,
                        'earn' => $sharedAmount_balance,
                        'earn2' => $remaining,
                    ]);
                }
            } else {
                $housing = Housing::where('id', $cart['item']['id'])->first();
                $user = User::where('id', $housing->user_id)->first();
                if ($lastClick) {
                    $collection = Collection::where('id', $lastClick->collection_id)->first();
                    $newAmount = $amountWithoutDiscount - ($amountWithoutDiscount * ($discountRate / 100));
                    $rates = Rate::where("housing_id", $cart['item']['id'])->get();

                    foreach ($rates as $key => $rate) {
                        if ($user->corporate_type == $rate->institution->name) {
                            $share_percent_earn =  $rate->default_deposit_rate;
                            $share_percent_balance = 1.0 - $share_percent_earn;
                        }
                    }
                    $cartItem = CartItem::where('user_id', Auth::user()->id)->latest()->first();

                    $cart = json_decode($cartItem->cart, true);
                    if ($cart['type'] == 'housing') {
                        $housing = Housing::where('id', $cart['item']['id'])->first();
                        $saleType = $housing->step2_slug;
                    } else {
                        $project = Project::where('id', $cart['item']['id'])->first();
                        $saleType = $project->step2_slug;
                    }

                    if ($saleType == 'kiralik') {
                        $sharedAmount_balance = $newAmount * $share_percent_balance;
                        $sharedAmount_earn = $newAmount * $share_percent_earn;
                    } else {
                        $sharedAmount_balance = $newAmount * $deposit_rate * $share_percent_balance;
                        $sharedAmount_earn = $newAmount * $deposit_rate * $share_percent_earn;
                    }

                    if ($collection->user_id != Auth::user()->id) {

                        $sales_rate_club = null; // Başlangıçta boş veya null değer

                        foreach ($rates as $rate) {
                            if ($collection->user->corporate_type == $rate->institution->name) {
                                // Eğer kullanıcı kurumsal türü ile oranlar eşleşirse, `sales_rate_club` değerini atayın
                                $sales_rate_club = $rate->sales_rate_club;

                                break; // Eşleşme bulunduğunda döngüyü sonlandırın
                            }
                        }

                        // Eşleşme yoksa, son oran kaydının `sales_rate_club` değerini kullanın
                        if ($sales_rate_club === null && count($rates) > 0) {
                            $sales_rate_club = $rates->last()->sales_rate_club;
                        }

                        $estateclubrate = $sharedAmount_earn * $sales_rate_club;
                        $remaining = $sharedAmount_earn - $estateclubrate;


                        SharerPrice::create([
                            'collection_id' => $lastClick->collection_id,
                            'user_id' => $collection->user_id,
                            'cart_id' => $order->id,
                            'status' => '1',
                            'balance' => $estateclubrate,
                            'earn' => $sharedAmount_balance,
                            'earn2' => $remaining,
                        ]);
                    }
                } elseif (!$lastClick) {
                    $newAmount = $amountWithoutDiscount;
                    $rates = Rate::where("housing_id", $cart['item']['id'])->get();

                    foreach ($rates as $key => $rate) {
                        if ($user->corporate_type == $rate->institution->name) {
                            $share_percent_earn =  $rate->default_deposit_rate;
                            $share_percent_balance = 1.0 - $share_percent_earn;
                        }
                    }


                    $cartItem = CartItem::where('user_id', Auth::user()->id)->latest()->first();

                    $cart = json_decode($cartItem->cart, true);
                    if ($cart['type'] == 'housing') {
                        $housing = Housing::where('id', $cart['item']['id'])->first();
                        $saleType = $housing->step2_slug;
                    } else {
                        $project = Project::where('id', $cart['item']['id'])->first();
                        $saleType = $project->step2_slug;
                    }

                    if ($saleType == 'kiralik') {
                        $sharedAmount_balance = $newAmount * $share_percent_balance;
                        $sharedAmount_earn = $newAmount * $share_percent_earn;
                    } else {
                        $sharedAmount_balance = $newAmount * $deposit_rate * $share_percent_balance;
                        $sharedAmount_earn = $newAmount * $deposit_rate * $share_percent_earn;
                    }

                    CartPrice::create([
                        'user_id' => $order->user_id,
                        'cart_id' => $order->id,
                        'status' => '1',
                        'earn' => $sharedAmount_balance,
                        'earn2' => $sharedAmount_earn,
                    ]);
                } else {
                    $newAmount = $amountWithoutDiscount;
                    $rates = Rate::where("housing_id", $cart['item']['id'])->get();

                    foreach ($rates as $key => $rate) {
                        if ($user->corporate_type == $rate->institution->name) {
                            $share_percent_earn =  $rate->default_deposit_rate;
                            $share_percent_balance = 1.0 - $share_percent_earn;
                        }
                    }
                    $cartItem = CartItem::where('user_id', Auth::user()->id)->latest()->first();

                    $cart = json_decode($cartItem->cart, true);
                    if ($cart['type'] == 'housing') {
                        $housing = Housing::where('id', $cart['item']['id'])->first();
                        $saleType = $housing->step2_slug;
                    } else {
                        $project = Project::where('id', $cart['item']['id'])->first();
                        $saleType = $project->step2_slug;
                    }

                    if ($saleType == 'kiralik') {
                        $sharedAmount_balance = $newAmount * $share_percent_balance;
                        $sharedAmount_earn = $newAmount * $share_percent_earn;
                    } else {
                        $sharedAmount_balance = $newAmount * $deposit_rate * $share_percent_balance;
                        $sharedAmount_earn = $newAmount * $deposit_rate * $share_percent_earn;
                    }

                    CartPrice::create([
                        'user_id' => $order->user_id,
                        'cart_id' => $order->id,
                        'status' => '1',
                        'earn' => $sharedAmount_balance,
                        'earn2' => $sharedAmount_earn,
                    ]);
                }
            }
        } else {
            $project = Project::where('id', $productDetails->id)->with('brand', 'roomInfo', 'housingType', 'county', 'city', 'user.projects.housings', 'user.brands', 'user.housings', 'images')->first();
            $city = $project->city->title;
            $county = $project->county->ilce_title;
            $neighborhood = $project->neighbourhood ? $project->neighbourhood->mahalle_title : null;
            $housingImage = getHouse($project, 'image[]', $productDetails->housing)->value;
            $housingTypeImage = URL::to('/') . '/project_housing_images/' . $housingImage;
            $code = $project->id + $productDetails->housing + 1000000;
            $store = $project->user->name;
            $storeID = $project->user->id;
            $estateProjectRate = $project->club_rate / 100;

            $room = $productDetails->housing;
            $shareOpen = isset(getHouse($project, 'share-open[]', $productDetails->housing)->value) ? getHouse($project, 'share-open[]', $productDetails->housing)->value : null;

            if ($haveDiscount) {
                if ($coupon->discount_type == 1) {
                    $newAmount = $amountWithoutDiscount - ($amountWithoutDiscount * ($coupon->amount / 100));
                } else {
                    $newAmount = $amountWithoutDiscount - $coupon->amount;
                }
                if ($coupon->user->type != "1") {
                    if ($coupon->user->corporate_type == "Emlak Ofisi") {

                        $share_percent = $estateProjectRate;
                    } else {
                        $share_percent = 0.5;
                    }
                } else {
                    $share_percent = 0.25;
                }

                $cartItem = CartItem::where('user_id', Auth::user()->id)->latest()->first();

                $cart = json_decode($cartItem->cart, true);
                if ($cart['type'] == 'housing') {
                    $housing = Housing::where('id', $cart['item']['id'])->first();
                    $saleType = $housing->step2_slug;
                } else {
                    $project = Project::where('id', $cart['item']['id'])->first();
                    $saleType = $project->step2_slug;
                }

                if ($saleType == 'kiralik') {
                    $sharedAmount_balance = $newAmount * $share_percent;
                } else {
                    $sharedAmount_balance = $newAmount * $deposit_rate * $share_percent;
                }

                UseCoupon::create([
                    'order_id' => $order->id,
                    'coupon_id' => $coupon->id,
                ]);

                $coupon->update([
                    'use_count' => $coupon->use_count - 1,
                ]);

                if ($coupon->user_id != Auth::user()->id) {
                    SharerPrice::create([
                        'user_id' => $coupon->user_id,
                        'cart_id' => $order->id,
                        'status' => '1',
                        'balance' => $sharedAmount_balance,
                        'earn' => $sharedAmount_balance,
                        'earn2' => 0,
                    ]);
                }
            } else {
                if ($lastClick) {
                    $collection = Collection::where('id', $lastClick->collection_id)->first();
                    $newAmount = $amountWithoutDiscount - ($amountWithoutDiscount * ($discountRate / 100));

                    if ($collection->user->type != "1") {
                        if ($collection->user->corporate_type == "Emlak Ofisi") {

                            $share_percent = $estateProjectRate;
                        } else {
                            $share_percent = 0.5;
                        }
                    } else {
                        $share_percent = 0.25;
                    }

                    $cartItem = CartItem::where('user_id', Auth::user()->id)->latest()->first();

                    $cart = json_decode($cartItem->cart, true);
                    if ($cart['type'] == 'housing') {
                        $housing = Housing::where('id', $cart['item']['id'])->first();
                        $saleType = $housing->step2_slug;
                    } else {
                        $project = Project::where('id', $cart['item']['id'])->first();
                        $saleType = $project->step2_slug;
                    }

                    if ($saleType == 'kiralik') {
                        $sharedAmount_balance = $newAmount * $share_percent;
                    } else {
                        $sharedAmount_balance = $newAmount * $deposit_rate * $share_percent;
                    }

                    if ($collection->user_id != Auth::user()->id) {
                        SharerPrice::create([
                            'collection_id' => $lastClick->collection_id,
                            'user_id' => $collection->user_id,
                            'cart_id' => $order->id,
                            'status' => '1',
                            'balance' => $sharedAmount_balance,
                            'earn' => $newAmount - $sharedAmount_balance,
                            'earn2' => 0,

                        ]);
                    } else {
                        CartPrice::create([
                            'user_id' => $order->user_id,
                            'cart_id' => $order->id,
                            'status' => '1',
                            'earn' => $cartJson['item']['amount'] * $deposit_rate,
                            'earn2' => 0,
                        ]);
                    }
                } else if (!$lastClick) {
                    $newAmount = $amountWithoutDiscount;

                    CartPrice::create([
                        'user_id' => $order->user_id,
                        'cart_id' => $order->id,
                        'status' => '1',
                        'earn' => $newAmount * $deposit_rate,
                        'earn2' => 0,

                    ]);
                } else {
                    $newAmount = $amountWithoutDiscount;

                    CartPrice::create([
                        'user_id' => $order->user_id,
                        'cart_id' => $order->id,
                        'status' => '1',
                        'earn' => $newAmount * $deposit_rate,
                        'earn2' => 0,

                    ]);
                }
            }
        }

        $order->update([
            'store_id' => $storeID,
        ]);
        return  $order;
    }
}
