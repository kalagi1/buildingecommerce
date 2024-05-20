<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }


    public function render($request, Throwable $exception)
    {
        if ($exception instanceof HttpException) {
            $statusCode = $exception->getStatusCode();

            switch ($statusCode) {
                case 403:
                    return $this->renderCustom403Page();
                case 404:
                    return $this->renderCustom404Page();
            }
        }

        // if ($exception instanceof HttpException && $exception->getStatusCode() == 500) {
        //     return redirect('/')->with('error', 'Bir Hata Oluştu');
        // }

        // if ($exception instanceof \ErrorException && strpos($exception->getMessage(), 'Undefined property') !== false) {
        //     return redirect('/')->with('error', 'Bir Hata Oluştu');
        // }

        return parent::render($request, $exception);
    }

    protected function renderCustom403Page()
    {
        return redirect('/')
            ->with('error', 'Bu sayfa için görüntüleme yetkiniz bulunamadı.');
    }

    protected function renderCustom404Page()
    {
        return redirect('/')
            ->with('error', 'Sayfa bulunamadı.');
    }
}
