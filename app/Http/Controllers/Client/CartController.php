<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\CustomMail;
use App\Models\BankAccount;
use App\Models\CartItem;
use App\Models\CartOrder;
use App\Models\CartPrice;
use App\Models\Click;
use App\Models\Collection;
use App\Models\Coupon;
use App\Models\DocumentNotification;
use App\Models\EmailTemplate;
use App\Models\Housing;
use App\Models\NeighborView;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Project;
use App\Models\ProjectHousing;
use App\Models\Rate;
use App\Models\ShareLink;
use App\Models\SharerPrice;
use App\Models\UseCoupon;
use App\Models\User;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    public function payCart(Request $request)
    {

        $cartItem = CartItem::where('user_id', Auth::user()->id)->latest()->first();

        if (!$cartItem) {

            return response()->json(['success' => 'fail']);
        }

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
        $order->bank_id = $request->input('banka_id');
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

            app()->make(FavoriteController::class)->deleteFavoriteByHousingId($productDetails->id);

            if ($haveDiscount) {
                if ($coupon->discount_type == 1) {
                    $newAmount = $amountWithoutDiscount - ($amountWithoutDiscount * ($coupon->amount / 100));
                } else {
                    $newAmount = $amountWithoutDiscount - $coupon->amount;
                }

                $housing = Housing::where('id', $cart['item']['id'])->first();
                $user = User::where('id', $housing->user_id)->first();
                $rates = Rate::where('housing_id', $cart['item']['id'])->get();

                foreach ($rates as $key => $rate) {
                    if ($user->corporate_type == $rate->institution->name || $user->type == 1 && $rate->institution->name == "Diğer") {
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
                    $sales_rate_club = null;
                    // Başlangıçta boş veya null değer

                    foreach ($rates as $rate) {
                        if ($coupon->user->corporate_type == $rate->institution->name) {
                            // Eğer kullanıcı kurumsal türü ile oranlar eşleşirse, `sales_rate_club` değerini atayın
                            $sales_rate_club = $rate->sales_rate_club;

                            break;
                            // Eşleşme bulunduğunda döngüyü sonlandırın
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
                        'status' => '0',
                        'balance' => $estateclubrate,
                        'earn' => $sharedAmount_balance,
                        'earn2' => $remaining,
                    ]);
                }
            } else {
                $housing = Housing::where('id', $cart['item']['id'])->first();
                $user = User::where('id', $housing->user_id)->first();
                if (isset($lastClick)) {
                    $collection = Collection::where('id', $lastClick->collection_id)->first();
                    $newAmount = $amountWithoutDiscount - ($amountWithoutDiscount * ($discountRate / 100));
                    $rates = Rate::where('housing_id', $cart['item']['id'])->get();

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

                    if ($collection && $collection->user_id != Auth::user()->id) {
                        $sales_rate_club = null;
                        // Başlangıçta boş veya null değer

                        foreach ($rates as $rate) {
                            if ($collection->user->corporate_type == $rate->institution->name) {
                                // Eğer kullanıcı kurumsal türü ile oranlar eşleşirse, `sales_rate_club` değerini atayın
                                $sales_rate_club = $rate->sales_rate_club;

                                break;
                                // Eşleşme bulunduğunda döngüyü sonlandırın
                            }
                        }

                        // Eşleşme yoksa, son oran kaydının `sales_rate_club` değerini kullanın
                        if ($sales_rate_club === null && count($rates) > 0) {
                            $sales_rate_club = $rates->last()->sales_rate_club;
                        }

                        // $amount değerini float'a dönüştür
                        $amount = str_replace('.', '', $amount); // Noktaları kaldır
                        $amount = str_replace(', ', '.', $amount); // Virgülü nokta ile değiştir
                        $amount = floatval($amount); // Float'a dönüştür

                        $estateclubrate = ($amount - $sharedAmount_balance) * $sales_rate_club;;
                        $remaining = $sharedAmount_earn - $estateclubrate;

                        SharerPrice::create([
                            'collection_id' => $lastClick->collection_id,
                            'user_id' => $collection->user_id,
                            'cart_id' => $order->id,
                            'status' => '0',
                            'balance' => $estateclubrate,
                            'earn' => $sharedAmount_balance,
                            'earn2' => $remaining,
                        ]);
                    } else {
                        $newAmount = $amountWithoutDiscount;
                        $rates = Rate::where('housing_id', $cart['item']['id'])->get();

                        foreach ($rates as $key => $rate) {
                            if ($user->corporate_type == $rate->institution->name || $user->type == 1 && $rate->institution->name == "Diğer") {
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
                            'status' => '0',
                            'earn' => $sharedAmount_balance,
                            'earn2' => $sharedAmount_earn,
                        ]);
                    }
                } else {

                    $newAmount = $amountWithoutDiscount;
                    $rates = Rate::where('housing_id', $cart['item']['id'])->get();

                    foreach ($rates as $key => $rate) {
                        if ($user->corporate_type == $rate->institution->name || $user->type == 1 && $rate->institution->name == "Diğer") {
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
                        'status' => '0',
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

            app()->make(FavoriteController::class)->deleteFavoriteByProjectIdAndHousing($productDetails->id, $productDetails->housing);
            $room = $productDetails->housing;
            $shareOpen = isset(getHouse($project, 'share-open[]', $productDetails->housing)->value) ? getHouse($project, 'share-open[]', $productDetails->housing)->value : null;

            if ($haveDiscount) {
                if ($coupon->discount_type == 1) {
                    $newAmount = $amountWithoutDiscount - ($amountWithoutDiscount * ($coupon->amount / 100));
                } else {
                    $newAmount = $amountWithoutDiscount - $coupon->amount;
                }
                if ($coupon->user->type != '1') {
                    if ($coupon->user->corporate_type == 'Emlak Ofisi') {

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
                        'status' => '0',
                        'balance' => $sharedAmount_balance,
                        'earn' => $sharedAmount_balance,
                        'earn2' => 0,
                    ]);
                }
            } else {
                if ($lastClick) {
                    $collection = Collection::where('id', $lastClick->collection_id)->first();
                    $newAmount = $amountWithoutDiscount - ($amountWithoutDiscount * ($discountRate / 100));
                    if ($collection && isset($collection->user) && $collection->user->type != '1') {
                        if ($collection->user->corporate_type == 'Emlak Ofisi') {
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

                    if (isset($collection) && isset($collection->user) && $collection->user->corporate_type == 'Emlak Ofisi') {
                        $sharedAmount_balance = $newAmount * $share_percent;
                    } else {
                        $sharedAmount_balance = $request->input('payableAmount') * $share_percent;
                    }

                    if (isset($collection) && isset($collection->user) && $collection->user_id != Auth::user()->id) {
                        SharerPrice::create([
                            'collection_id' => $lastClick->collection_id,
                            'user_id' => $collection->user_id,
                            'cart_id' => $order->id,
                            'status' => '0',
                            'balance' => $sharedAmount_balance,
                            'earn' => $request->input('payableAmount') - $sharedAmount_balance,
                            'earn2' => 0,

                        ]);
                    } else {
                        CartPrice::create([
                            'user_id' => $order->user_id,
                            'cart_id' => $order->id,
                            'status' => '0',
                            'earn' => $cartJson['item']['amount'] * $deposit_rate,
                            'earn2' => 0,
                        ]);
                    }
                } else if (!$lastClick) {
                    $newAmount = $amountWithoutDiscount;

                    CartPrice::create([
                        'user_id' => $order->user_id,
                        'cart_id' => $order->id,
                        'status' => '0',
                        'earn' => $newAmount * $deposit_rate,
                        'earn2' => 0,

                    ]);
                } else {
                    $newAmount = $amountWithoutDiscount;

                    CartPrice::create([
                        'user_id' => $order->user_id,
                        'cart_id' => $order->id,
                        'status' => '0',
                        'earn' => $newAmount * $deposit_rate,
                        'earn2' => 0,

                    ]);
                }
            }
        }

        $order->update([
            'store_id' => $storeID,
        ]);

        $productTable = '<table style="width:100%;border-collapse: collapse;">
                <tr>
                    <th style="border: 1px solid #dddddd;width:120px; text-align: left; padding: 8px;">Emlak Görseli</th>
                    <th style="border: 1px solid #dddddd; text-align: left; padding: 8px;">Emlak</th>
                    <th style="border: 1px solid #dddddd; width:50px;text-align: left; padding: 8px;">Fiyat</th>
                    <th style="border: 1px solid #dddddd; text-align: left; padding: 8px;">Ödeme Kodu</th>
                    <th style="border: 1px solid #dddddd; text-align: left; padding: 8px;">İl-İlçe-Mahalle</th>
                    <th style="border: 1px solid #dddddd; text-align: left; padding: 8px;">Mağaza</th>
                </tr>
                <tr>
                    <td style="border: 1px solid #dddddd; text-align: left; padding: 8px;"><img src="' . $housingTypeImage . '" style="max-width:100px;max-height:100px;" alt="Product Image"></td>
                    <td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">' . $productDetails->title . ($room ? ' Projesinde' . $room . " No'lu Daire" : null) . '<br>' . '#' . $code . '</td>
                    <td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">' . $order->amount . ' ₺' . '</td>
                    <td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">' . $order->key . '</td>
                    <td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">' . $city . ' / ' . $county . ' / ' . $neighborhood . '</td>
                    <td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">' . $store . '</td>
                </tr>
            </table>';

        $user = User::where('id', $order->user_id)->first();
        $BuyCart = EmailTemplate::where('slug', 'buy-cart')->first();

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
            'title' => $productDetails->title . ($room ? ' Projesinde ' . $room . " No'lu Daire" : ''),
            'housingOrder' => $order->key,
            'price' => $order->amount . ' ₺',
            'orderNo' => $order->id,
            'companyName' => 'Emlak Sepette',
            'email' => $user->email,
            'table' => $productTable,
            'token' => $user->email_verification_token,
        ];

        foreach ($buyCartVariables as $key => $value) {
            $BuyCartContent = str_replace('{{' . $key . '}}', $value, $BuyCartContent);
        }

        // Mail::to( $user->email )->send( new CustomMail( $BuyCart->subject, $BuyCartContent ) );

        DocumentNotification::create([
            'user_id' => $user->id,
            'text' => '#' . $code . " No'lu emlak siparişiniz için teşekkür ederiz. Siparişiniz, ödeme onayı için yönetici onayına gönderilmiştir. "
                . 'Onay süreci tamamlandığında size bilgi verilecektir.',
            'item_id' => $order->id,
            'link' => route('institutional.profile.cart-orders'),
            'owner_id' => $user->id,
            'is_visible' => true,
        ]);

        $NewOrder = EmailTemplate::where('slug', 'new-order')->first();

        if (!$NewOrder) {
            return response()->json([
                'message' => 'Email template not found.',
                'status' => 203,
                'success' => true,
            ], 203);
        }

        $NewOrderContent = $NewOrder->body;

        $admins = User::where('type', '3')->get();

        foreach ($admins as $key => $admin) {
            $housingTypeImage = '';
            if (json_decode($o->cart)->type == 'housing') {
                $housingTypeImage = asset('housing_images/' . json_decode(Housing::find(json_decode($o->cart)->item->id ?? 0)->housing_type_data ?? '[]')->image ?? null);
            } else {
                $project = Project::where('id', json_decode($o->cart)->item->id)->with('brand', 'roomInfo', 'housingType', 'county', 'city', 'user.projects.housings', 'user.brands', 'user.housings', 'images')->first();
                $housingImage = getHouse($project, 'image[]', json_decode($o->cart)->item->housing)->value;
                $housingTypeImage = URL::to('/') . '/project_housing_images/' . $housingImage;
            }

            $NewOrderVariables = [
                'productImage' => '<img src=\'$housingTypeImage\' style=\'object-fit: contain;
                width:100%;
                height:100%\' alt=\'Görsel\'>',
                'title' => $productDetails->title . ($room ? ' Projesinde ' . $room . " No'lu Daire" : ''),
                'adminName' => $admin->name,
                'housingOrder' => $order->key,
                'price' => $order->amount . ' ₺',
                'orderNo' => $order->id,
                'customerName' => $user->name,
                'paymentDate' => $order->created_at,
                'paymentTotalAmount' => $productDetails->amount,
                'bankAccount' => $cartOrder->bank->receipent_full_name,
                'companyName' => 'Emlak Sepette',
                'email' => $user->email,
                'phone' => $user->phone,
                'table' => $productTable,
                'token' => $user->email_verification_token,
            ];

            foreach ($NewOrderVariables as $key => $value) {
                $NewOrderContent = str_replace('{{' . $key . '}}', $value, $NewOrderContent);
            }

            // Mail::to( $admin->email )->send( new CustomMail( $NewOrder->subject, $NewOrderContent ) );
        }

        session()->forget('cart');
        $cartItem = DB::table('cart_items')->where('user_id', Auth::id())->first();
        if ($cartItem) {
            DB::table('cart_items')->where('id', $cartItem->id)->delete();
        }

        return response()->json(['cart_order' => $order->id]);
    }

    public function paySuccess(Request $request, CartOrder $cart_order)
    {

        return view('client.cart.pay-success', compact('cart_order'));
    }

    public function dekontFileUpload(Request $request)
    {
        $file = $request->file('file');

        $fileName = time() . '_' . $file->getClientOriginalName();

        $file->move(public_path('dekont'), $fileName);
        $cartOrder = CartOrder::where('id', $request->cart_order)->first();
        // $cartOrder->update( [ 'dekont' => 'uploads/' . $fileName ] );
        // $cartOrder->save();

        if ($cartOrder) {
            // Dosya adının veritabanına kaydedilmesi
            $cartOrder->update(['dekont' => $fileName]);
            $cartOrder->save();
            return response()->json(['success' => 'Dosya başarıyla yüklendi.']);
        } else {
            return response()->json(['error' => 'Cart Order bulunamadı.']);
        }
    }
    //End

    public function dekontIndir($order_id)
    {
        $order = CartOrder::find($order_id);

        if (!$order) {
            return abort(404);
            // Sipariş bulunamazsa 404 hatası döndür
        }

        $dekontDosyaYolu = 'https://private.emlaksepette.com/public/dekont/' . $order->dekont;

        if ($dekontDosyaYolu) {
            return redirect()->away($dekontDosyaYolu);
        } else {
            return abort(404);
            // Dekont bulunamazsa 404 hatası döndür
        }
    }

    public function addLink(Request $request)
    {
        $type = $request->input('type');
        $id = $request->input('id');
        $project = $request->input('project');

        if ($type == 'project') {
            $sharerLinksProjects = ShareLink::select('room_order', 'item_id', 'collection_id')->where('user_id', auth()->user()->id)->where('item_type', 1)->get()->keyBy('item_id')->toArray();
            $isHas = false;
            $ext = ShareLink::where('item_id', $project)->where('room_order', $id)->where('collection_id', $request->input('selectedCollectionId'))->first();
            if ($ext) {
                $isHas = true;
            }
            if (!$isHas) {
                ShareLink::create([
                    'user_id' => auth()->user()->id,
                    'item_type' => 1,
                    'collection_id' => $request->input('selectedCollectionId'),
                    'item_id' => $project,
                    'room_order' => $id,
                ]);
            } else {
                return response(['failed' => 'success']);
            }
        } else {
            $sharerLinks = array_values(array_keys(ShareLink::where('user_id', auth()->user()->id)->where('item_type', 2)->where('collection_id', $request->input('selectedCollectionId'))->get()->keyBy('item_id')->toArray()));
            if (!in_array($id, $sharerLinks)) {
                ShareLink::create([
                    'user_id' => auth()->user()->id,
                    'item_type' => 2,
                    'item_id' => $id,
                    'collection_id' => $request->input('selectedCollectionId'),

                ]);
            } else {
                return response(['failed' => 'success']);
            }
        }

        return response(['message' => 'success']);
    }

    public function updateQt(Request $request)
    {
        try {
            $cart = [];
            $cartItem = CartItem::where('user_id', Auth::user()->id)->latest()->first();
            if (isset($cartItem)) {
                $cart = json_decode($cartItem->cart, true);
            } else {
                $cart = $request->session()->get('cart', []);
            }

            if (!$cart) {
                return response(['message' => 'fail']);
            }

            $change = $request->input('change');

            // Retrieve 'housing' and 'id' from $cart[ 'item' ]
            $housingId = $cart['item']['housing'] ?? null;
            $itemId = $cart['item']['id'] ?? null;

            // Retrieve qt and numbershare from $cart[ 'item' ]
            $qt = $cart['item']['qt'] ?? 0;
            $numbershare = $cart['item']['numbershare'] ?? 0;

            if ($cart['item']['payment-plan'] == 'taksitli') {
                $defaultPrice = $cart['item']['installmentPrice'] ?? 0;
            } else {
                $defaultPrice = $cart['item']['defaultPrice'] ?? 0;
            }

            // Retrieve sumCartOrderQt for the given 'housing' and 'id'
            $sumCartOrderQt = DB::table('cart_orders')
                ->select(
                    DB::raw('JSON_EXTRACT(cart, "$.item.housing") as housing_id'),
                    DB::raw('JSON_EXTRACT(cart, "$.item.qt") as qt')
                )
                ->leftJoin('users', 'cart_orders.user_id', '=', 'users.id')
                ->where(DB::raw('JSON_EXTRACT(cart, "$.type")'), 'project')
                ->where(DB::raw('JSON_EXTRACT(cart, "$.item.id")'), $itemId)
                ->orderByRaw('CAST(housing_id AS SIGNED) ASC')
                ->get()
                ->groupBy('housing_id')
                ->mapWithKeys(

                    function ($group) {
                        return [
                            $group->first()->housing_id => [
                                'housing_id' => $group->first()->housing_id,
                                'qt_total' => $group->sum('qt'),
                            ],
                        ];
                    }
                )
                ->all();

            $pesinat =  $cart['item']['qt'] > 1 ? ($cart['item']['pesinat'] / $cart['item']['qt']) : $cart['item']['pesinat'];
            $aylik = $cart['item']['qt'] > 1 ?  ($cart['item']['aylik'] / $cart['item']['qt']) : $cart['item']['aylik'];

            if ($change == 'artir') {
                $remainingQt = $numbershare - ($sumCartOrderQt[$housingId]['qt_total'] ?? 0);

                if ($qt !== $remainingQt) {
                    $cart['item']['qt'] += 1;
                    $cart['item']['amount'] += $defaultPrice;
                    $cart['item']['pesinat'] += $pesinat;
                    $cart['item']['aylik'] += $aylik;
                } else {
                    return response(['message' => 'success', 'quantity' => $qt, 'response' => 'Maximum ' . $qt . ' adeti kadar sipariş oluşturabilirsiniz.']);
                }
            } elseif ($change == 'azalt') {
                if ($qt != 1) {
                    $cart['item']['qt'] -= 1;
                    $cart['item']['amount'] -= $defaultPrice;
                    $cart['item']['pesinat'] -= $pesinat;
                    $cart['item']['aylik'] -= $aylik;
                } else {
                    return response(['message' => 'success', 'quantity' => $qt, 'response' => $qt . ' adetten daha az sipariş oluşturamazsınız.']);
                }
            }

            if (isset($cartItem)) {
                $cartItem->cart = json_encode($cart);
                $cartItem->save();
            } else {
                $request->session()->put('cart', $cart);
            }

            return response(['message' => 'success', 'quantity' => $cart['item']['qt']]);
        } catch (\Exception $e) {
            // Handle exceptions if any
            return response(['message' => 'error', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $cartSession = $request->session()->get('cart', []);
            $cartItem = CartItem::where('user_id', Auth::user()->id)->latest()->first();

            if ($cartItem) {
                $cart = json_decode($cartItem->cart, true);
                $selectedPaymentOption = $request->input('paymentOption');
                $updatedPrice = $request->input('updatedPrice');

                if (isset($updatedPrice)) {
                    $cartSession['item']['amount'] = $updatedPrice;
                    $cartSession['item']['payment-plan'] = $selectedPaymentOption;
                    $cart['item']['amount'] = $updatedPrice;
                    $cart['item']['payment-plan'] = $selectedPaymentOption;
                    $cartItem->cart = json_encode($cart);
                    $cartItem->save();
                }

                $request->session()->put('cart', $cart);

                return response(['message' => 'success']);
            }

            return response(['message' => 'fail']);
        } catch (\Exception $e) {
            // Handle exceptions if any
            return response(['message' => 'error', 'error' => $e->getMessage()], 500);
        }
    }

    public function add(Request $request)
    {
        try {
            if (Auth::check()) {
                $user = Auth::user();
                $lastClick = Click::where('user_id', $user->id)
                    ->where('created_at', '>=', now()->subDays(24))
                    ->latest('created_at')
                    ->first();

                $cartList = CartItem::where('user_id', $user->id)->latest()->first();
                if ($cartList) {
                    CartItem::where('user_id', $user->id)->latest()->first()->delete();
                }

                $cartItem = $this->prepareCartItem($request);
                if (!$cartItem) {
                    return response(['message' => 'fail']);
                }

                $hasCounter = false;

                if ($request->input('type') == 'project') {
                    if ($lastClick) {
                        $collection = Collection::with('links')->where('id', $lastClick->collection_id)->first();

                        if (isset($collection)) {
                            if (($collection->user_id !=  $user->id)) {
                                $hasCounter = true;
                            }
                        }
                    }
                } else {
                    if ($lastClick) {
                        $collection = Collection::with('links')->where('id', $lastClick->collection_id)->first();
                        if (isset($collection)) {
                            if (($collection->user_id !=  $user->id)) {
                                $hasCounter = true;
                            }
                        }
                    }
                }

                $cart = [
                    'item' => $cartItem,
                    'type' => $request->input('type'),
                    'hasCounter' => $hasCounter
                ];

                $request->session()->put('cart', $cart);

                $cartJson = json_encode($cart);
                CartItem::create([
                    'cart'     => $cartJson,
                    'user_id'  => $user->id
                ]);

                return response(['message' => 'success']);
            } else {
                $cartItem = $this->prepareCartItem($request);
                if (!$cartItem) {
                    return response(['message' => 'fail']);
                }

                $cart = [
                    'item' => $cartItem,
                    'type' => $request->input('type'),
                    'hasCounter' => false
                ];
                session(['cart' => $cart]);

                return response(['message' => 'session']);
            }
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()]);
        }
    }

    private function prepareCartItem(Request $request)
    {
        $type = $request->input('type');
        $id = $request->input('id');
        $project = $request->input('project');
        $neighborProjects = [];
        $hasCounter = false;

        if ($type == 'project') {
            $discount_amount = Offer::where('type', 'project')->where('project_id', $project)
                ->where('project_housings', 'LIKE', '%' . $id . '%')->where('start_date', '<=', date('Y-m-d H:i:s'))->where('end_date', '>=', date('Y-m-d H:i:s'))->first()->discount_amount ?? 0;

            $project = Project::find($project);
            $projectHousing = ProjectHousing::where('project_id', $project->id)
                ->where('room_order', $id)
                ->get()
                ->keyBy('key');

            if (Auth::check()) {
                $neighborProjects = NeighborView::with('user', 'owner', 'project')->where('project_id', $project->id)->where('user_id', Auth::user()->id)->where('status', 1)->get();
            } else {
                $neighborProjects = NeighborView::with('user', 'owner', 'project')->where('project_id', $project->id)->where('status', 1)->get();
            }

            $price = $projectHousing['Peşin Fiyat']->value ?? $projectHousing['Fiyat']->value;
            $installmentPrice = $pesinat = $taksitSayisi = $aylik = null;

            if (isset($projectHousing['Taksitli Toplam Fiyat']) || isset($projectHousing['Taksitli Fiyat'])) {
                $installmentPrice = $newPrice = ($projectHousing['Taksitli Toplam Fiyat'] ?? $projectHousing['Taksitli Fiyat'])->value;
                $pesinat = $projectHousing['Peşinat']->value;
                $taksitSayisi = $projectHousing['Taksit Sayısı']->value;

                if (isset($projectHousing["pay-dec-count{$id}"])) {
                    $count = $projectHousing["pay-dec-count{$id}"]->value;

                    for ($k = 0; $k < $count; $k++) {
                        $payDescPriceKey = "pay_desc_price{$id}{$k}";

                        if (isset($projectHousing[$payDescPriceKey])) {
                            $newPrice -= $projectHousing[$payDescPriceKey]->value;
                        }
                    }
                }

                $number_of_share = 0;
                if (isset($projectHousing['Kaç Hisse Var ?'])) {
                    $number_of_share = $projectHousing['Kaç Hisse Var ?']->value;
                }

                $newPrice = floatval($newPrice);
                $pesinat = floatval($pesinat);
                $taksitSayisi = intval($taksitSayisi);
                $number_of_share = intval($number_of_share);

                if ($taksitSayisi > 0) {
                    if ($number_of_share > 0) {
                        $aylik = ($newPrice - $pesinat) / $taksitSayisi / $number_of_share;
                    } else {
                        $aylik = ($newPrice - $pesinat) / $taksitSayisi;
                    }
                } else {
                    $aylik = 0;
                }
            }

            $image = $projectHousing['Kapak Resmi']->value;
            $payDecs = [];

            if (isset($projectHousing["pay-dec-count{$id}"])) {
                $count = $projectHousing["pay-dec-count{$id}"]->value;

                for ($k = 0; $k < $count; $k++) {
                    $payDescPriceKey = "pay_desc_price{$id}{$k}";

                    if (isset($projectHousing[$payDescPriceKey])) {
                        $payDecs[] = [
                            "pay_dec_price{$k}" => $projectHousing[$payDescPriceKey]->value,
                            "pay_dec_date{$k}" => $projectHousing["pay_desc_date{$id}{$k}"]->value,
                        ];
                    }
                }
            }

            return [
                'id' => $project->id,
                'housing' => $id,
                'neighborProjects' => $neighborProjects,
                'city' => $project->city->title,
                'address' => $project->address,
                'title' => $project->project_title,
                'price' => $price,
                'isShare' => $request->input('isShare'),
                'numbershare' => $request->input('numbershare'),
                'qt' => $request->input('qt'),
                'amount' => $request->input('isShare') && $request->input('isShare') != '[]' ? ($price / $request->input('numbershare')) : $price,
                'defaultPrice' => $request->input('isShare') && $request->input('isShare') != '[]' ? ($price / $request->input('numbershare')) : $price,
                'image' => asset('project_housing_images/' . $image),
                'discount_amount' => $hasCounter ? $discount_amount : 0,
                'share_open' => $projectHousing['Paylaşıma Açık']->value ?? false,
                'share_percent' => 0.5,
                'discount_rate' => $projectHousing['İndirim Oranı %']->value ?? 0,
                'installmentPrice' => $request->input('isShare') && $request->input('isShare') != '[]' ? ($installmentPrice / $request->input('numbershare')) : $installmentPrice,
                'payment-plan' => 'pesin',
                'pesinat' => $request->input('isShare') && $request->input('isShare') != '[]' ? ($pesinat / $request->input('numbershare')) : $pesinat,
                'taksitSayisi' => $taksitSayisi,
                'aylik' => $aylik,
                'hasCounter' => $hasCounter,
                'pay_decs' => $payDecs,
            ];
        } else if ($type == 'housing') {
            $discount_amount = Offer::where('type', 'housing')->where('housing_id', $id)->where('start_date', '<=', date('Y-m-d H:i:s'))->where('end_date', '>=', date('Y-m-d H:i:s'))->first()->discount_amount ?? 0;
            $housing = Housing::find($id);
            $housingData = json_decode($housing->housing_type_data);

            return [
                'id' => $housing->id,
                'city' => $housing->city['title'],
                'address' => $housing->address,
                'title' => $housing->title,
                'slug' => $housing->slug,
                'amount' => $housingData->price[0],
                'price' => $housingData->price[0],
                'defaultPrice' => $housingData->price[0],
                'image' => asset('housing_images/' . $housingData->images[0]),
                'discount_amount' => $hasCounter ? $discount_amount : 0,
                'hasCounter' => $hasCounter,
                'share_open' => $housingData->{'share-open'}[0] ?? null,
                'installmentPrice' => null,
                'share_percent' => 0.5,
                'discount_rate' => $housingData->{'discount_rate'}[0] ?? 0,
            ];
        }

        return null;
    }

    public function clear(Request $request)
    {
        CartItem::where('user_id', Auth::user()->id)->latest()->delete();
        $request->session()->forget('cart');

        return redirect()->route('cart')->with('success', 'Cart cleared');
    }

    public function index(Request $request)
    {
        $bankAccounts = BankAccount::all();
        $cart = false;
        $user_id = Auth::id();
        $cartItem = CartItem::where('user_id', $user_id)->latest()->first();
        if ($cartItem) {
            $cart = json_decode($cartItem->cart, true);
        }

        $saleType = null;
        if (isset($cart) && !empty($cart)) {
            if ($cart['type'] == 'housing') {
                $housing = Housing::where('id', $cart['item']['id'])->first();
                $saleType = $housing->step2_slug;
            } else {
                $project = Project::where('id', $cart['item']['id'])->first();
                $saleType = $project->step2_slug;
            }
        }

        $pageInfo = [
            'meta_title' => 'Sepetim',
            'meta_keywords' => 'Sepetim',
            'meta_description' => 'Emlak Sepette Sepetim, en yeni ve en uygun konutları keşfedin. 
                Geniş seçenekler, kolay ödeme seçenekleri ve profesyonel hizmetlerle konut sahibi olun!',
            'meta_author' => 'Emlak Sepette',
        ];

        $pageInfo = json_encode($pageInfo);
        $pageInfo = json_decode($pageInfo);

        return view('client.cart.index', compact('pageInfo', 'cart', 'bankAccounts', 'saleType'));
    }

    public function removeFromCart(Request $request)
    {
        $request->session()->forget('cart');
        $cartItem = CartItem::where('user_id', Auth::user()->id)->first()->delete();
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

    public function checkCoupon(Request $request)
    {
        $coupon = Coupon::where(

            function ($query) {
                $query->where(

                    function ($query) {
                        $query->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'));
                    }
                )->orWhere('time_type', 1);
            }
        )->where('coupon_code', $request->input('coupon_code'))->where('use_count', '>=', 1)->first();
        $saleItemType = '';
        if ($coupon) {
            $cartItem = CartItem::where('user_id', Auth::user()->id)->latest()->first();

            $cart = json_decode($cartItem->cart, true);
            if ($cart['type'] == 'housing') {
                $housing = Housing::where('id', $cart['item']['id'])->first();
                if ($housing->step2_slug == 'kiralik') {
                    $saleItemType = 'kiralik';
                } else {
                    $saleItemType = 'satilik';
                }
                if ($coupon->select_housings_type == 1) {
                    return json_encode([
                        'status' => true,
                        'cart' => $cart,
                        'discount_type' => $coupon->discount_type,
                        'discount_amount' => $coupon->amount,
                    ]);
                } elseif ($coupon->select_housings_type == 2) {
                    $couponHousings = array_keys($coupon->housings->keyBy('item_id')->toArray());
                    if (in_array($cart['item']['id'], $couponHousings)) {
                        return json_encode([
                            'status' => true,
                            'cart' => $cart,
                            'discount_type' => $coupon->discount_type,
                            'discount_amount' => $coupon->amount,
                            'sale_item_type' => $saleItemType,
                        ]);
                    } else {
                        return json_encode([
                            'status' => false,
                            'message' => 'İndirim kuponu bu ürün için geçerli değil.',
                        ]);
                    }
                } else {
                    return json_encode([
                        'status' => false,
                        'message' => 'İndirim kuponu bu ürün için geçerli değil.',
                    ]);
                }
            } else {
                $project = Project::where('id', $cart['item']['id'])->first();
                if ($project->step2_slug == 'kiralik') {
                    $saleItemType = 'kiralik';
                } else {
                    $saleItemType = 'satilik';
                }
                if ($coupon->select_projects_type == 1 || $coupon->select_projects_type == 2) {
                    if ($coupon->select_projects_type == 1) {
                        return json_encode([
                            'status' => true,
                            'cart' => $cart,
                            'discount_type' => $coupon->discount_type,
                            'discount_amount' => $coupon->amount,
                            'sale_item_type' => $saleItemType,
                        ]);
                    } else {
                        $couponProjects = array_keys($coupon->projects->keyBy('item_id')->toArray());
                        if (in_array($cart['item']['id'], $couponProjects)) {
                            return json_encode([
                                'status' => true,
                                'cart' => $cart,
                                'discount_type' => $coupon->discount_type,
                                'discount_amount' => $coupon->amount,
                                'sale_item_type' => $saleItemType,
                            ]);
                        } else {
                            return json_encode([
                                'status' => false,
                                'message' => 'İndirim kuponu bu ürün için geçerli değil.',
                            ]);
                        }
                    }
                } else {
                    return json_encode([
                        'status' => false,
                        'message' => 'İndirim kuponu bu ürün için geçerli değil.',
                    ]);
                }
            }
        } else {
            return json_encode([
                'status' => false,
                'message' => 'İndirim kuponu yanlış',
            ]);
        }
    }

    public function setCartSession(Request $request)
    {
        $cart = $request->input('cart');
        session(['cart' => $cart]);
        return response()->json(['success' => true]);
    }
}
