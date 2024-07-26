<?php

namespace App\Http\Controllers\Api\Institutional;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\CartItem;
use App\Models\CartOrder;
use App\Models\Click;
use App\Models\Collection;
use App\Models\Housing;
use App\Models\NeighborView;
use App\Models\Offer;
use App\Models\Project;
use App\Models\ProjectHousing;
use App\Models\Reservation;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller {
    public function add( Request $request ) {
        try {
            $lastClick = Click::where( 'user_id', auth()->guard( 'api' )->user()->id )
            ->where( 'created_at', '>=', now()->subDays( 24 ) )
            ->latest( 'created_at' )
            ->first();

            $type = $request->input( 'type' );
            $id = $request->input( 'id' );
            $project = $request->input( 'project' );
            $neighborProjects  = [];

            $orderCount = CartOrder::where( 'status', '!=', '2' )
            ->whereJsonContains( 'cart->item->id', $project )
            ->whereJsonContains( 'cart->item->housing', $id )
            ->whereJsonContains( 'cart->type', $type )
            ->count();

            $cartItem = [];
            $cart = [];
            $hasCounter = false;

            $cartList = CartItem::where( 'user_id', Auth::guard( 'api' )->user()->id )->latest()->first();
            if ( $cartList ) {
                $cartItem = CartItem::where( 'user_id', Auth::guard( 'api' )->user()->id )->latest()->first()->delete();
            }

            http_response_code( 500 );
            if ( $cartItem && ( ( $type == 'housing' && isset( $cart[ 'item' ][ 'id' ] ) &&  $cart[ 'item' ][ 'id' ] == $id ) || ( $type == 'project' && isset( $cart[ 'item' ][ 'housing' ] ) && $cart[ 'item' ][ 'housing' ] == $id ) ) ) {
                CartItem::where( 'user_id', Auth::guard( 'api' )->user()->id )->latest()->delete();
                $request->session()->forget( 'cart' );
            } else {
                if ( $type == 'project' ) {

                    $discount_amount = Offer::where( 'type', 'project' )->where( 'project_id', $project )
                    ->where( 'project_housings', 'LIKE', '%' . $id . '%' )->where( 'start_date', '<=', date( 'Y-m-d H:i:s' ) )->where( 'end_date', '>=', date( 'Y-m-d H:i:s' ) )->first()->discount_amount ?? 0;

                    $project = Project::find( $project );
                    $projectHousing = ProjectHousing::where( 'project_id', $project->id )
                    ->where( 'room_order', $id )
                    ->get()
                    ->keyBy( 'key' );
                    $neighborProjects = NeighborView::with( 'user', 'owner', 'project' )->where( 'project_id', $project->id )->where( 'user_id', Auth::guard( 'api' )->user()->id )->where( 'status', 1 )->get();
                    if ( $lastClick ) {
                        $collection = Collection::with( 'links' )->where( 'id', $lastClick->collection_id )->first();

                        if ( isset($collection) && isset($collection->user)) {
                            if ( ( $collection->user_id != Auth::guard( 'api' )->user()->id ) ) {
                                $hasCounter = true;
                            }
                        }
                    }

                    $price = $projectHousing[ 'Peşin Fiyat' ]->value ?? $projectHousing[ 'Fiyat' ]->value;
                    $installmentPrice = $pesinat = $taksitSayisi = $aylik = null;

                    if ( isset( $projectHousing[ 'Taksitli Toplam Fiyat' ] ) || isset( $projectHousing[ 'Taksitli Fiyat' ] ) ) {
                        $installmentPrice = $newPrice = ( $projectHousing[ 'Taksitli Toplam Fiyat' ] ?? $projectHousing[ 'Taksitli Fiyat' ] )->value;
                        $pesinat = $projectHousing[ 'Peşinat' ]->value;
                        $taksitSayisi = $projectHousing[ 'Taksit Sayısı' ]->value;

                        if ( isset( $projectHousing[ "pay-dec-count{$request->input('id')}" ] ) ) {
                            $count = $projectHousing[ "pay-dec-count{$request->input('id')}" ]->value;

                            for ( $k = 0; $k < $count; $k++ ) {
                                $payDescPriceKey = "pay_desc_price{$request->input('id')}{$k}";

                                if ( isset( $projectHousing[ $payDescPriceKey ] ) ) {
                                    $newPrice -= $projectHousing[ $payDescPriceKey ]->value;
                                }
                            }
                        }

                        $number_of_share = 0;
                        if ( isset( $projectHousing[ 'Kaç Hisse Var ?' ] ) ) {
                            $number_of_share = $projectHousing[ 'Kaç Hisse Var ?' ]->value;
                        }

                        // Değişkenleri uygun tipe dönüştür
                        $newPrice = floatval( $newPrice );
                        $pesinat = floatval( $pesinat );
                        $taksitSayisi = intval( $taksitSayisi );
                        $number_of_share = intval( $number_of_share );

                        // Taksit sayısı ve paylaşım sayısının sıfır olmadığından emin olma
                        if ( $taksitSayisi > 0 ) {
                            if ( $number_of_share > 0 ) {
                                $aylik = ( $newPrice - $pesinat ) / $taksitSayisi / $number_of_share;
                            } else {
                                $aylik = ( $newPrice - $pesinat ) / $taksitSayisi;
                            }
                        } else {
                            $aylik = 0;
                            // Taksit sayısı sıfır ise, aylık ödeme tutarı da sıfır olmalı
                        }
                    }

                    $image = $projectHousing[ 'Kapak Resmi' ]->value;
                    $payDecs = [];

                    if ( isset( $projectHousing[ "pay-dec-count{$request->input('id')}" ] ) ) {
                        $count = $projectHousing[ "pay-dec-count{$request->input('id')}" ]->value;

                        for ( $k = 0; $k < $count; $k++ ) {
                            $payDescPriceKey = "pay_desc_price{$request->input('id')}{$k}";

                            if ( isset( $projectHousing[ $payDescPriceKey ] ) ) {
                                $payDecs[] = [
                                    "pay_dec_price{$k}" => $projectHousing[ $payDescPriceKey ]->value,
                                    "pay_dec_date{$k}" => $projectHousing[ "pay_desc_date{$request->input('id')}{$k}" ]->value,
                                ];
                            }
                        }
                    }

                    $cartItem = [
                        'id' => $project->id,
                        'housing' => $id,
                        'neighborProjects' => $neighborProjects,
                        'city' => $project->city->title,
                        'address' => $project->address,
                        'title' => $project->project_title,
                        'price' => $price,
                        'isShare' => $request->input( 'isShare' ),
                        'numbershare' => $request->input( 'numbershare' ),
                        'qt' => $request->input( 'qt' ),
                        'amount' => $request->input( 'isShare' ) && $request->input( 'isShare' ) != '[]' ? ( $price / $request->input( 'numbershare' ) ) : $price,
                        'defaultPrice' => $request->input( 'isShare' ) && $request->input( 'isShare' ) != '[]' ? ( $price / $request->input( 'numbershare' ) ) : $price,
                        'image' => asset( 'project_housing_images/' . $image ),
                        'discount_amount' => $hasCounter ? $discount_amount : 0,
                        'share_open' => $projectHousing[ 'Paylaşıma Açık' ]->value ?? false,
                        'share_percent' => 0.5,
                        'discount_rate' => $projectHousing[ 'İndirim Oranı %' ]->value ?? 0,
                        'installmentPrice' => $request->input( 'isShare' ) && $request->input( 'isShare' ) != '[]' ? ( $installmentPrice / $request->input( 'numbershare' ) ) : $installmentPrice,
                        'payment-plan' => 'pesin',
                        'pesinat' => $request->input( 'isShare' ) && $request->input( 'isShare' ) != '[]' ? ( $pesinat / $request->input( 'numbershare' ) ) : $pesinat,
                        'taksitSayisi' => $taksitSayisi,
                        'aylik' => $aylik,
                        'pay_decs' => $payDecs,
                    ];
                } else if ( $type == 'housing' ) {
                    if ( $lastClick ) {
                        $collection = Collection::with( 'links' )->where( 'id', $lastClick->collection_id )->first();
                        if ( isset($collection) && isset($collection->user) ) {
                            if ( ( $collection->user_id != Auth::guard( 'api' )->user()->id ) ) {
                                $hasCounter = true;
                            }
                        }
                    }
                    $discount_amount = Offer::where( 'type', 'housing' )->where( 'housing_id', $id )->where( 'start_date', '<=', date( 'Y-m-d H:i:s' ) )->where( 'end_date', '>=', date( 'Y-m-d H:i:s' ) )->first()->discount_amount ?? 0;
                    $housing = Housing::find( $id );
                    $housingData = json_decode( $housing->housing_type_data );
                    $cartItem = [
                        'id' => $housing->id,
                        'city' => $housing->city[ 'title' ],
                        'address' => $housing->address,
                        'title' => $housing->title,
                        'slug' => $housing->slug,
                        'amount' => $housingData->price[ 0 ],
                        'price' => $housingData->price[ 0 ],
                        'defaultPrice' => $housingData->price[ 0 ],
                        'image' => asset( 'housing_images/' . $housingData->images[ 0 ] ),
                        'discount_amount' => $hasCounter ? $discount_amount : 0,
                        'share_open' => $housingData-> {
                            'share-open'}
                            [ 0 ] ?? null,
                            'installmentPrice' => null,
                            'share_percent' => 0.5,
                            'discount_rate' => $housingData-> {
                                'discount_rate'}
                                [ 0 ] ?? 0,
                            ];
                        }

                        if ( !$cartItem ) {
                            return response( [ 'message' => 'fail' ] );
                        }
                        $cart = [
                            'item' => $cartItem,
                            'type' => $type,
                            'hasCounter' => $hasCounter
                        ];

                        $cartJson = json_encode( $cart );
                        CartItem::create( [
                            'cart'     => $cartJson,
                            'user_id'  => Auth::guard( 'api' )->id()
                        ] );

                        $userPhoneNumber = $type == 'housing' ?  $housing->user->mobile_phone : $project->user->mobile_phone;

                        if ( $type == 'housing' ) {
                            $message = 'Sayın mağaza yetkilisi, #' . ( intval( $housing->id ) + 2000000 )  . ' numaralı emlak ilanınız bir üyemiz tarafından sepete eklendi. İyi günler dileriz.';
                        } else {
                            $message = 'Sayın mağaza yetkilisi, #' . ( intval( $project->id ) + 1000000 + intval( $id ) )  . ' numaralı proje ilanınız bir üyemiz tarafından sepete eklendi. İyi günler dileriz.';
                        }

                        $smsService = new SmsService();
                        $source_addr = 'Emlkspette';

                        // $smsService->sendSms( $source_addr, $message, $userPhoneNumber );

                        return response( [ 'message' => 'success' ] );
                    }
                } catch ( \Exception $e ) {
                    // Handle exceptions if any
                    return response( [ 'message' => 'error', 'error' => $e->getMessage() ], 500 );
                }
            }

            public function index( Request $request ) {
                $bankAccounts = BankAccount::all();
                $cart = false;
                $user_id = Auth::id();
                $cartItem = CartItem::where( 'user_id', $user_id )->latest()->first();
                if ( $cartItem ) {
                    $cart = json_decode( $cartItem->cart, true );
                }
                $housing = null;
                $project = null;
                $housingOffer = null;
                $projectOffer = null;

                $saleType = null;
                if ( isset( $cart ) && !empty( $cart ) ) {
                    if ( $cart[ 'type' ] == 'housing' ) {
                        $housing = Housing::with( 'user' )->where( 'id', $cart[ 'item' ][ 'id' ] )->first();
                        $saleType = $housing->step2_slug;
                        $housingOffer = Offer::where( 'type', 'housing' )
                        ->where( 'housing_id', $cart[ 'item' ][ 'id' ] )
                        ->where( 'start_date', '<=', now() )
                        ->where( 'end_date', '>=', now() )
                        ->first();
                    } else {
                        $project = Project::with( 'user' )->where( 'id', $cart[ 'item' ][ 'id' ] )->first();
                        $saleType = $project->step2_slug;
                        $projectOffer = Offer::where( 'type', 'project' )
                        ->where( 'project_id', $cart[ 'item' ][ 'id' ] )
                        ->where( function ( $query ) use ( $cart ) {
                            $query
                            ->orWhereJsonContains(
                                'project_housings',
                                $cart[ 'item' ][ 'housing' ],
                            )
                            ->orWhereJsonContains(
                                'project_housings',
                                ( string ) $cart[ 'item' ][ 'housing' ],
                            );

                        }
                    )
                    ->where( 'start_date', '<=', now() )
                    ->where( 'end_date', '>=', now() )
                    ->first();
                }
            }

            $pageInfo = [
                'meta_title' => 'Sepetim',
                'meta_keywords' => 'Sepetim',
                'meta_description' => 'Emlak Sepette Sepetim, en yeni ve en uygun konutları keşfedin. 
                Geniş seçenekler, kolay ödeme seçenekleri ve profesyonel hizmetlerle konut sahibi olun!',
                'meta_author' => 'Emlak Sepette',
            ];

            $pageInfo = json_encode( $pageInfo );
            $pageInfo = json_decode( $pageInfo );

            return response()->json( [
                'pageInfo' => $pageInfo,
                'cart' => $cart,
                'bankAccounts' => $bankAccounts,
                'saleType' => $saleType,
                'project' => $project,
                'housing' => $housing,
                'projectOffer' => $projectOffer,
                'housingOffer' => $housingOffer,
                'store' => $housing || $project ? ( $housing ? $housing->user : ( $project ? $project->user : null ) ) : null
            ] );
        }

        public function getMyReservations() {
            $user = Auth::user();
            $housingReservations = Reservation::with( 'user', 'housing', 'owner' )

            ->where( 'status', '!=', 3 )
            ->get();

            $housingReservations = Reservation::select( 'reservations.*' )
            ->with( 'user', 'housing', 'owner' )
            ->where( 'status', '=', 1 )
            ->where( 'user_id', $user->id )
            ->leftJoin( 'cancel_requests', 'cancel_requests.reservation_id', '=', 'reservations.id' )
            ->whereNull( 'cancel_requests.id' )
            ->orderBy( 'created_at', 'desc' )
            ->get();

            $confirmReservations = Reservation::select( 'reservations.*' )
            ->with( 'user', 'housing', 'owner' )
            ->where( 'status', '!=', 3 )
            ->where( 'status', '!=', 1 )
            ->where( 'user_id', $user->id )
            ->where( 'check_in_date', '>=', date( 'Y-m-d' ) )
            ->where( 'status', '!=', 3 )
            ->leftJoin( 'cancel_requests', 'cancel_requests.reservation_id', '=', 'reservations.id' )
            ->whereNull( 'cancel_requests.id' )
            ->orderBy( 'created_at', 'desc' )
            ->get();

            $expiredReservations = Reservation::select( 'reservations.*' )
            ->with( 'user', 'housing', 'owner' )
            ->where( 'check_in_date', '<=', date( 'Y-m-d' ) )
            ->where( 'status', '!=', 3 )
            ->where( 'user_id', $user->id )
            ->orderBy( 'created_at', 'desc' )
            ->get();

            $cancelReservations = Reservation::select( 'reservations.*' )
            ->with( 'user', 'housing', 'owner' )
            ->where( 'status', '=', 3 )
            ->where( 'user_id', $user->id )
            ->orderBy( 'created_at', 'desc' )
            ->get();

            $cancelRequestReservations = Reservation::select( 'reservations.*' )
            ->with( 'user', 'housing', 'owner' )->leftJoin( 'cancel_requests', 'cancel_requests.reservation_id', '=', 'reservations.id' )
            ->where( 'user_id', $user->id )
            ->where( 'status', '!=', 3 )->whereNotNull( 'cancel_requests.id' )
            ->orderBy( 'created_at', 'desc' )
            ->get();

            $refundedReservations = Reservation::whereHas( 'refund' )
            ->with( 'user', 'housing', 'owner', 'refund' )
            ->where( 'owner_id', $user->id )
            ->orderBy( 'created_at', 'desc' )
            ->get();

            return response()->json( [
                'refundedReservations' => $refundedReservations,
                'housingReservations' => $housingReservations,
                'cancelReservations' => $cancelReservations,
                'expiredReservations' => $expiredReservations,
                'confirmReservations' => $confirmReservations,
                'cancelRequestReservations' => $cancelRequestReservations,
            ] );
        }
    }
