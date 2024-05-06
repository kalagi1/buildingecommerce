<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckHasClubAccount {
    /**
    * Erişim sağlanabilen routelar.
    */
    private $whiteRoutelist =
    [
        'institutional.sharer.index',
        'institutional.sharer.earnings',
    ];

    /**
    * Handle an incoming request.
    *
    * @param  \Closure( \Illuminate\Http\Request ): ( \Symfony\Component\HttpFoundation\Response )  $next
    */

    public function handle( Request $request, Closure $next ): Response {
        if ( auth()->user()->has_club == '0' && auth()->user()->type != 3 && in_array( request()->route()->getName(), $this->whiteRoutelist ) ) {
            return redirect()->route( 'institutional.corporate-has-club-verification' );
        } elseif ( auth()->user()->has_club == '2' && auth()->user()->type != 3 && in_array( request()->route()->getName(), $this->whiteRoutelist ) ) {
            return redirect()->route( 'institutional.corporate-has-club-status' );
        } elseif ( auth()->user()->has_club == '3' && request()->route()->getName() == 'institutional.sharer.index' ) {
            return redirect()->route( 'institutional.corporate-has-club-verification' )->with( 'error', 'Emlak Kulüp başvurunuz reddedildi.Yeni bir başvuru oluşturunuz ya da yönetim ile iletişime geçiniz.' );
        } elseif ( auth()->user()->has_club == '1' && request()->route()->getName() == 'institutional.corporate-has-club-verification' ) {
            return redirect()->route( 'institutional.index' );
        }
        return $next( $request );
    }
}
