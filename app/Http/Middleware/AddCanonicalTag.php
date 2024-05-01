<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class AddCanonicalTag
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // İlgili sayfanın URL'sini alın
        $canonicalUrl = $request->url();

        // İçerik olarak döndürülecek yanıtı alın
        $response = $next($request);

        // Eğer yanıt bir yönlendirme ise, doğrudan geri döndürün
        if ($response instanceof RedirectResponse) {
            return $response;
        }

        // Eğer canonical etiketi yoksa, ekleyin
        if (!str_contains($response->getContent(), '<link rel="canonical"')) {
            $response->setContent(
                str_replace(
                    '</head>',
                    '<link rel="canonical" href="' . $canonicalUrl . '" />' . PHP_EOL . '</head>',
                    $response->getContent()
                )
            );
        }

        return $response;
    }
}
