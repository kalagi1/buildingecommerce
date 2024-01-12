<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\CustomMail;
use App\Models\BankAccount;
use App\Models\CartOrder;
use App\Models\DocumentNotification;
use App\Models\EmailTemplate;
use App\Models\Housing;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Project;
use App\Models\ProjectHousing;
use App\Models\ShareLink;
use App\Models\SharerPrice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class CartController extends Controller {

    public function __construct() {
        $this->middleware( 'auth' );
    }

    public function payCart( Request $request ) {
        if ( !$request->session()->get( 'cart' ) ) {
            return redirect()->back()->withErrors( [ 'pay' => 'Sepet boş.' ] );
        }

        function getHouse( $project, $key, $roomOrder ) {
            foreach ( $project->roomInfo as $room ) {
                if ( $room->room_order == $roomOrder && $room->name == $key ) {
                    return $room;
                }
            }
        }

        $cartJson = $request->session()->get( 'cart' ) ;

        $order = new CartOrder;
        $order->user_id = auth()->user()->id;
        $order->bank_id = $request->input( 'banka_id' );
        $order->amount = str_replace( ',', '.', number_format( floatval( str_replace( '.', '', $cartJson[ 'item' ][ 'price' ] - $cartJson[ 'item' ][ 'discount_amount' ] ) ) * 0.01, 0, ',', '.' ) );
        $order->cart = json_encode( $cartJson );
        $order->status = '0';
        $order->key = $request->input( 'key' );
        $order->full_name = $request->input( 'fullName' );
        $order->email = $request->input( 'email' );
        $order->phone = $request->input( 'phone' );
        $order->address = $request->input( 'address' );
        $order->tc = $request->input( 'tc' );
        $order->notes = $request->input( 'notes' );
        $order->save();

        $cartOrder = CartOrder::where( 'id', $order->id )->with( 'bank' )->first();
        $o = json_decode( $cartOrder );

        $productDetails = json_decode( $o->cart )->item;

        if ( json_decode( $o->cart )->type == 'housing' ) {
            $housingTypeImage = asset( 'housing_images/' . json_decode( Housing::find( $productDetails->id ?? 0 )->housing_type_data ?? '[]' )->image ?? null );
            $city = Housing::find( $productDetails->id ?? 0 )->city->title;
            $county = Housing::find( $productDetails->id ?? 0 )->county->title;
            $neighborhood = Housing::find( $productDetails->id ?? 0 )->neighborhood->mahalle_title ? Housing::find( $productDetails->id ?? 0 )->neighborhood->mahalle_title : null;
            $code = Housing::find( $productDetails->id ?? 0 )->id + 2000000;
            $store = Housing::find( $productDetails->id ?? 0 )->user->name;
            $room = null;

        } else {
            $project = Project::where( 'id', $productDetails->id )
            ->with( 'brand', 'roomInfo', 'housingType', 'county', 'city', 'user.projects.housings', 'user.brands', 'user.housings', 'images' )
            ->first();
            $city = $project->city->title;
            $county = $project->county->ilce_title;
            $neighborhood = $project->neighbourhood ? $project->neighbourhood->mahalle_title : null;
            $housingImage = getHouse( $project, 'image[]', $productDetails->housing )->value;
            $housingTypeImage = URL::to( '/' ) . '/project_housing_images/' . $housingImage;
            $code = $project->id + $productDetails->housing +1000000;
            $store = $project->user->name;
            $room = $productDetails->housing;

        }

        $productTable =
        '<table style="width:100%;border-collapse: collapse;">
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
                    <td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">' . $productDetails->title . ( $room ? ' Projesinde' . $room . " No'lu Daire" : null ) . '<br>' . '#' . $code . '</td>
                    <td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">' . $order->amount . ' ₺' . '</td>
                    <td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">' . $order->key . '</td>
                    <td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">' . $city . ' / ' . $county . ' / ' . $neighborhood . '</td>
                    <td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">' . $store . '</td>
                </tr>
            </table>';

        if ( session()->get( 'sharer_username' ) ) {
            if ( $cartJson[ 'type' ] == 'project' ) {
                $project = Project::where( 'id', $cartJson[ 'item' ][ 'id' ] )->first();
                $sharerPercent = ProjectHousing::where( 'name', 'share-percent[]' )->first();
                $sharerPercentAmount = $sharerPercent->value;
            } else {
                $housing = Housing::where( 'id', $cartJson[ 'item' ][ 'id' ] )->first();
                $sharerPercent = json_decode( $housing->housing_type_data );
                $sharerPercentAmount = $sharerPercent-> {
                    'share-percent'}
                    ;
                }
                $sharer = User::where( 'username', session()->get( 'sharer_username' ) )->first();
                $sharerPrice = new SharerPrice();
                $sharerPrice->item_id = $cartJson[ 'item' ][ 'id' ];
                $sharerPrice->cart_order_id = $order->id;
                $sharerPrice->item_type = $cartJson[ 'type' ] == 'project' ? 1 : 2;
                $sharerPrice->price = ( intval( str_replace( '.', '', $order->amount ) ) / 100 ) * $sharerPercentAmount;
                $sharerPrice->user_id = $sharer->id;
                $sharerPrice->status = 0;
                $sharerPrice->save();
            }

            $user = User::where( 'id', $order->user_id )->first();
            $BuyCart = EmailTemplate::where( 'slug', 'buy-cart' )->first();

            if ( !$BuyCart ) {
                return response()->json( [
                    'message' => 'Email template not found.',
                    'status' => 203,
                    'success' => true,
                ], 203 );
            }

            $BuyCartContent = $BuyCart->body;

            $buyCartVariables = [
                'username' => $user->name,
                'companyName' => 'Emlak Sepette',
                'email' => $user->email,
                'table' => $productTable,
                'token' => $user->email_verification_token,
            ];

            foreach ( $buyCartVariables as $key => $value ) {
                $BuyCartContent = str_replace( '{{' . $key . '}}', $value, $BuyCartContent );
            }

            Mail::to( $user->email )->send( new CustomMail( $BuyCart->subject, $BuyCartContent ) );

            DocumentNotification::create( [
                'user_id' => $user->id,
                'text' =>  '#' . $code . " No'lu emlak siparişiniz için teşekkür ederiz. Siparişiniz, ödeme onayı için yönetici onayına gönderilmiştir. "
                . 'Onay süreci tamamlandığında size bilgi verilecektir.',
                'item_id' => $order->id,
                'link' => $user->type == 1 ? route( 'client.profile.cart-orders' ):route( 'institutional.profile.cart-orders' ) ,
                'owner_id' => $user->id,
                'is_visible' => true,
            ] );

            $NewOrder = EmailTemplate::where( 'slug', 'new-order' )->first();

            if ( !$NewOrder ) {
                return response()->json( [
                    'message' => 'Email template not found.',
                    'status' => 203,
                    'success' => true,
                ], 203 );
            }

            $NewOrderContent = $NewOrder->body;

            $admins = User::where( 'type', '3' )->get();

            foreach ( $admins as $key => $admin ) {
                $housingTypeImage = '';
                if ( json_decode( $o->cart )->type == 'housing' ) {
                    $housingTypeImage = asset( 'housing_images/' . json_decode( Housing::find( json_decode( $o->cart )->item->id ?? 0 )->housing_type_data ?? '[]' )->image ?? null );
                } else {
                    $project = Project::where( 'id', json_decode( $o->cart )->item->id )->with( 'brand', 'roomInfo', 'housingType', 'county', 'city', 'user.projects.housings', 'user.brands', 'user.housings', 'images' )->first();
                    $housingImage = getHouse( $project, 'image[]', json_decode( $o->cart )->item->housing )->value;
                    $housingTypeImage = URL::to( '/' ) . '/project_housing_images/' . $housingImage;
                }

                $NewOrderVariables = [
                    'productImage' => '<img src=\'$housingTypeImage\' style=\'object-fit: contain;
                    width:100%;
                    height:100%\' alt=\'Görsel\'>',
                    'adminName' => $admin->name,
                    'customerName' => $user->name,
                    'paymentDate' => $cartOrder->created_at,
                    'paymentTotalAmount' => $cartOrder->amount,
                    'bankAccount' => $cartOrder->bank->receipent_full_name,
                    'companyName' => 'Emlak Sepette',
                    'email' => $user->email,
                    'table' => $productTable,
                    'token' => $user->email_verification_token,
                ];

                foreach ( $NewOrderVariables as $key => $value ) {
                    $NewOrderContent = str_replace( '{{' . $key . '}}', $value, $NewOrderContent );
                }

                Mail::to( $admin->email )->send( new CustomMail( $NewOrder->subject,  $NewOrderContent ) );

            }

            session()->forget( 'cart' );

            return redirect()->route( 'pay.success', [ 'cart_order' => $order->id ] );
        }

        public function paySuccess( Request $request, CartOrder $cart_order ) {

            return view( 'client.cart.pay-success', compact( 'cart_order' ) );
        }

        public function add( Request $request ) {
            try {
                if ( auth()->user()->type == 21 ) {
                    $type = $request->input( 'type' );
                    $id = $request->input( 'id' );
                    $project = $request->input( 'project' );

                    if ( $type == 'project' ) {
                        $sharerLinksProjects = ShareLink::select( 'room_order', 'item_id' )->where( 'user_id', auth()->user()->id )->where( 'item_type', 1 )->get()->keyBy( 'item_id' )->toArray();
                        $isHas = false;
                        foreach ( $sharerLinksProjects as $linkProject ) {
                            if ( $linkProject[ 'item_id' ] == $project && $linkProject[ 'room_order' ] == $id && $linkProject[ 'collection_id' ] == $request->input( 'selectedCollectionId' ) ) {
                                $isHas = true;
                            }
                        }
                        if ( !$isHas ) {
                            ShareLink::create( [
                                'user_id' => auth()->user()->id,
                                'item_type' => 1,
                                'collection_id' =>  $request->input( 'selectedCollectionId' ),
                                'item_id' => $project,
                                'room_order' => $id
                            ] );
                        }else{
                            return response( [ 'failed' => 'success' ] );
                        }
                            

                    } else {
                        $sharerLinks = array_values( array_keys( ShareLink::where( 'user_id', auth()->user()->id )->where( 'item_type', 2 )->where('collection_id', $request->input( 'selectedCollectionId' ) )->get()->keyBy( 'item_id' )->toArray() ) );
                        if ( !in_array( $id, $sharerLinks ) ) {
                            ShareLink::create( [
                                'user_id' => auth()->user()->id,
                                'item_type' => 2,
                                'item_id' => $id,
                                'collection_id' =>  $request->input( 'selectedCollectionId' ),

                            ] );
                        }else{
                            return response( [ 'failed' => 'success' ] );

                        }

                    }

                    return response( [ 'message' => 'success' ] );
                } else {
                    $type = $request->input( 'type' );
                    $id = $request->input( 'id' );
                    $project = $request->input( 'project' );

                    $cartItem = [];

                    $cart = $request->session()->get( 'cart', [] );
                    // Get cart data from session
                    http_response_code( 500 );
                    if ( $cart && ( ( $type == 'housing' && $cart[ 'item' ][ 'id' ] == $id ) || ( $type == 'project' && $cart[ 'item' ][ 'id' ] == $id ) ) ) {
                        $request->session()->forget( 'cart' );
                    } else {
                        if ( $type == 'project' ) {
                            $discount_amount = Offer::where( 'type', 'project' )->where( 'project_id', $project )->where( 'start_date', '<=', date( 'Y-m-d H:i:s' ) )->where( 'end_date', '>=', date( 'Y-m-d H:i:s' ) )->first()->discount_amount ?? 0;
                            $project = Project::find( $project );
                            $projectHousing = ProjectHousing::where( 'project_id', $project->id )
                            ->where( 'room_order', $id )
                            ->whereIn( 'key', [ 'Fiyat', 'Kapak Resmi' ] )
                            ->get()
                            ->keyBy( 'key' );

                            $price = $projectHousing[ 'Fiyat' ]->value;
                            $image = $projectHousing[ 'Kapak Resmi' ]->value;
                            $cartItem = [
                                'id' => $project->id,
                                'housing' => $id,
                                'city' => $project->city->title,
                                'address' => $project->address,
                                'title' => $project->project_title,
                                'price' => $price,
                                'image' => asset( 'project_housing_images/' . $image ),
                                'discount_amount' => $discount_amount,
                            ];
                        } else if ( $type == 'housing' ) {
                            $discount_amount = Offer::where( 'type', 'housing' )->where( 'housing_id', $id )->where( 'start_date', '<=', date( 'Y-m-d H:i:s' ) )->where( 'end_date', '>=', date( 'Y-m-d H:i:s' ) )->first()->discount_amount ?? 0;
                            $housing = Housing::find( $id );
                            $housingData = json_decode( $housing->housing_type_data );

                            $cartItem = [
                                'id' => $housing->id,
                                'city' => $housing->city[ 'title' ],
                                'address' => $housing->address,
                                'title' => $housing->title,
                                'price' => $housingData->price[ 0 ],
                                'image' => asset( 'housing_images/' . $housingData->images[ 0 ] ),
                                'discount_amount' => $discount_amount,
                            ];

                        }

                        if ( !$cartItem ) {
                            return response( [ 'message' => 'fail' ] );
                        }

                        $cart = [
                            'item' => $cartItem,
                            'type' => $type,
                        ];

                        $request->session()->put( 'cart', $cart );
                        // Save cart data to session
                        return response( [ 'message' => 'success' ] );

                    }
                }

            } catch ( \Exception $e ) {
                // Handle exceptions if any
                return response( [ 'message' => 'error', 'error' => $e->getMessage() ], 500 );
            }
        }

        public function clear( Request $request ) {
            $request->session()->forget( 'cart' );
            // Clear the cart

            return redirect()->route( 'cart' )->with( 'success', 'Cart cleared' );
        }

        public function index( Request $request ) {
            $bankAccounts = BankAccount::all();
            $cart = $request->session()->get( 'cart', [] );
            return view( 'client.cart.index', compact( 'cart', 'bankAccounts' ) );
        }

        public function removeFromCart( Request $request ) {
            $request->session()->forget( 'cart' );
            // Clear the cart
            return redirect()->route( 'cart' )->with( 'success', 'Cart cleared' );

        }

        public function createOrder( Request $request ) {
            $userId = Auth::user()->id;
            if ( !$userId ) {
                return response( [ 'message' => 'Oturum bulunamadı' ], 404 );
            }
            $cart = session( 'cart' )[ 'item' ];
            $type = session( 'cart' )[ 'type' ];
            $orderData = [
                'user_id' => $userId,
                'status' => 1, //status tablosu eklenecek
            ];

            switch ( $type ) {
                case 'housing':
                $orderData[ 'housing_id' ] = $cart[ 'id' ];
                break;
                case 'project':
                $orderData[ 'project_id' ] = $cart[ 'id' ];
                break;
            }
            $order = Order::create( $orderData );
            return 'Sipariş Oluştu';
        }

    }
