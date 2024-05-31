<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{

    public function updateQt( Request $request ) {
        try {
            $cart = [];
            $cartItem = CartItem::where( 'user_id', auth()->guard('api')->user()->id )->latest()->first();
            if ( isset( $cartItem ) ) {
                $cart = json_decode( $cartItem->cart, true );
            } else {
                $cart = $request->session()->get( 'cart', [] );
            }

            if ( !$cart ) {
                return response( [ 'message' => 'fail' ] );
            }

            $change = $request->input( 'change' );

            // Retrieve 'housing' and 'id' from $cart[ 'item' ]
            $housingId = $cart[ 'item' ][ 'housing' ] ?? null;
            $itemId = $cart[ 'item' ][ 'id' ] ?? null;

            // Retrieve qt and numbershare from $cart[ 'item' ]
            $qt = $cart[ 'item' ][ 'qt' ] ?? 0;
            $numbershare = $cart[ 'item' ][ 'numbershare' ] ?? 0;

            if ( $cart[ 'item' ][ 'payment-plan' ] == 'taksitli' ) {
                $defaultPrice = $cart[ 'item' ][ 'installmentPrice' ] ?? 0;
            } else {
                $defaultPrice = $cart[ 'item' ][ 'defaultPrice' ] ?? 0;
            }

            // Retrieve sumCartOrderQt for the given 'housing' and 'id'
            $sumCartOrderQt = DB::table( 'cart_orders' )
            ->select(
                DB::raw( 'JSON_EXTRACT(cart, "$.item.housing") as housing_id' ),
                DB::raw( 'JSON_EXTRACT(cart, "$.item.qt") as qt' )
            )
            ->leftJoin( 'users', 'cart_orders.user_id', '=', 'users.id' )
            ->where( DB::raw( 'JSON_EXTRACT(cart, "$.type")' ), 'project' )
            ->where( DB::raw( 'JSON_EXTRACT(cart, "$.item.id")' ), $itemId )
            ->orderByRaw( 'CAST(housing_id AS SIGNED) ASC' )
            ->get()
            ->groupBy( 'housing_id' )
            ->mapWithKeys(

                function ( $group ) {
                    return [
                        $group->first()->housing_id => [
                            'housing_id' => $group->first()->housing_id,
                            'qt_total' => $group->sum( 'qt' ),
                        ],
                    ];
                }
            )
            ->all();

            $pesinat =  $cart[ 'item' ][ 'qt' ] > 1 ? ( $cart[ 'item' ][ 'pesinat' ] / $cart[ 'item' ][ 'qt' ] ) : $cart[ 'item' ][ 'pesinat' ];
            $aylik = $cart[ 'item' ][ 'qt' ] > 1 ?  ( $cart[ 'item' ][ 'aylik' ] / $cart[ 'item' ][ 'qt' ] ) : $cart[ 'item' ][ 'aylik' ];

            if ( $change == 'artir' ) {
                $remainingQt = $numbershare - ( $sumCartOrderQt[ $housingId ][ 'qt_total' ] ?? 0 );

                if ( $qt !== $remainingQt ) {
                    $cart[ 'item' ][ 'qt' ] += 1;
                    $cart[ 'item' ][ 'amount' ] += $defaultPrice;
                    $cart[ 'item' ][ 'pesinat' ] += $pesinat;
                    $cart[ 'item' ][ 'aylik' ] += $aylik;
                } else {
                    return response( [ 'message' => 'success', 'quantity' => $qt, 'response' => 'Maximum ' . $qt . ' adeti kadar sipariş oluşturabilirsiniz.' ] );
                }
            } elseif ( $change == 'azalt' ) {
                if ( $qt != 1 ) {
                    $cart[ 'item' ][ 'qt' ] -= 1;
                    $cart[ 'item' ][ 'amount' ] -= $defaultPrice;
                    $cart[ 'item' ][ 'pesinat' ] -= $pesinat;
                    $cart[ 'item' ][ 'aylik' ] -= $aylik;
                } else {
                    return response( [ 'message' => 'success', 'quantity' => $qt, 'response' => $qt . ' adetten daha az sipariş oluşturamazsınız.' ] );
                }
            }

            if ( isset( $cartItem ) ) {
                $cartItem->cart = json_encode( $cart );
                $cartItem->save();
            } else {
                $request->session()->put( 'cart', $cart );
            }

            return response( [ 'message' => 'success', 'quantity' => $cart[ 'item' ][ 'qt' ] ] );
        } catch ( \Exception $e ) {
            // Handle exceptions if any
            return response( [ 'message' => 'error', 'error' => $e->getMessage() ], 500 );
        }
    }
    public function update( Request $request ) {
        try {
            $cartSession = $request->session()->get( 'cart', [] );
            $cartItem = CartItem::where( 'user_id', auth()->guard('api')->user()->id)->latest()->first();

            if ( $cartItem ) {
                $cart = json_decode( $cartItem->cart, true );
                $selectedPaymentOption = $request->input( 'paymentOption' );
                $updatedPrice = $request->input( 'updatedPrice' );

                if ( isset( $updatedPrice ) ) {
                    $cartSession[ 'item' ][ 'amount' ] = $updatedPrice;
                    $cartSession[ 'item' ][ 'payment-plan' ] = $selectedPaymentOption;
                    $cart[ 'item' ][ 'amount' ] = $updatedPrice;
                    $cart[ 'item' ][ 'payment-plan' ] = $selectedPaymentOption;
                    $cartItem->cart = json_encode( $cart );
                    $cartItem->save();
                }

                $request->session()->put( 'cart', $cart );

                return response( [ 'message' => 'success' ] );
            }

            return response( [ 'message' => 'fail' ] );
        } catch ( \Exception $e ) {
            // Handle exceptions if any
            return response( [ 'message' => 'error', 'error' => $e->getMessage() ], 500 );
        }
    }
}
