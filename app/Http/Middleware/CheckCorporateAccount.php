<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCorporateAccount
{

    /**
     * Erişim sağlanabilen routelar.
     */
    private $whitelist =
    [
        'institutional.verify-account',
        'institutional.phone.verification',
        'institutional.phone.generateVerificationCode',
        'institutional.phone.verifyPhoneNumber',
        'institutional.get.tax-document',
        'institutional.get.record-document',
        'institutional.get.identity-document',
        'institutional.get.company-document',
        'institutional.profile.edit',
        'institutional.profile.update',
        'client.logout',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->parent_id != NULL && \App\Models\User::find(auth()->user()->parent_id)->corporate_account_status == 0) {
            die('Bağlı olduğunuz ana kurum hesabı onaylanmamış.');
        } elseif (auth()->user()->parent_id == NULL && auth()->user()->corporate_account_status == 0 && auth()->user()->type == 2 && !in_array(request()->route()->getName(), $this->whitelist)) {
            return redirect()->route('institutional.corporate-account-verification');
        } elseif (auth()->user()->parent_id == NULL && auth()->user()->corporate_account_status == 1 &&  auth()->user()->phone_verification_status == 0 && !in_array(request()->route()->getName(), $this->whitelist)) {

            return redirect()->route('institutional.phone.verification');
        } elseif (auth()->user()->corporate_account_status == 1 && auth()->user()->phone_verification_status == 1  && request()->route()->getName() == 'institutional.corporate-account-verification' && request()->route()->getName() == 'institutional.phone.verification') {

            return redirect()->route('institutional.index');
        }
        return $next($request);
    }
}
