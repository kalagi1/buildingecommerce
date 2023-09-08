<?php

namespace App\Http\Middleware;

use Closure;

class CheckPermission
{
    public function handle($request, Closure $next, $permission)
    {
        if (!auth()->check()) {
            // Kullanıcı giriş yapmamışsa yönlendirilebilir veya hata mesajı döndürülebilir
            return redirect('/login');
        }

        // Kullanıcının belirtilen izne sahip olup olmadığını kontrol edin
        if (!auth()->user()->hasPermission($permission)) {
            // Kullanıcının izni yoksa yönlendirilebilir veya hata mesajı döndürülebilir
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
