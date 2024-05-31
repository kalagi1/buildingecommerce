<?php

namespace App\Http\Middleware;

use App\Models\CartItem;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TransferCartAfterLogin
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (Auth::check() && $request->session()->has('cart')) {
            $cart = $request->session()->get('cart');
            CartItem::create([
                'cart' => json_encode($cart),
                'user_id' => Auth::id()
            ]);

            $request->session()->forget('cart');
        }

        return $response;
    }
}
