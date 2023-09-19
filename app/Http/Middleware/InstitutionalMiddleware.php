<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class InstitutionalMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->guard("institutional")->check() && Auth::guard("institutional")->user()->role->id == "2") {
            return $next($request);
        }

        // Yetkisi yoksa 403 hatası döndür
        abort(403, 'Unauthorized');
    }
}
