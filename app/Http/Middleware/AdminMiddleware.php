<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()  && Auth::user()->role->id == "3" || Auth::user()->parent_id == "4") {
            return $next($request);
        }

        return redirect('/')
        ->with('error', 'Bu sayfa için görüntüleme yetkiniz bulunamadı.');
        
    }
}
