<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAccountStatus
{

    /**
     * Erişim sağlanabilen routelar.
     */
    private $whitelist = 
    [
        'client.account-verification', 
        'client.verify-account',
        'client.get.identity-document',
        'client.logout',
        'client.profile.edit',
        'client.profile.update',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->corporate_account_status == 0 && auth()->user()->type == 1 && !in_array(request()->route()->getName(), $this->whitelist))
        {
            return redirect()->route('client.account-verification');
        }
        elseif (auth()->user()->corporate_account_status == 1 && request()->route()->getName() == 'client.account-verification')
        {
            return redirect()->route('index');
        }
        
        return $next($request);
    }
}
