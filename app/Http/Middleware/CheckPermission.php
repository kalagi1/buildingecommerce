<?php

namespace App\Http\Middleware;

use Closure;

class CheckPermission
{
    public function handle($request, Closure $next, $permission)
    {
        if (!auth()->check()) {
            // Kullanıcı giriş yapmamışsa yönlendirilebilir veya hata mesajı döndürülebilir
            return redirect('/giris-yap');
        }

        // Kullanıcının belirtilen izne sahip olup olmadığını kontrol edin
        if (!auth()->user()->hasPermission($permission)) {
            return redirect('/')
            ->with('error', 'Bu sayfa için görüntüleme yetkiniz bulunamadı.');
            
        }

        return $next($request);
    }
}
