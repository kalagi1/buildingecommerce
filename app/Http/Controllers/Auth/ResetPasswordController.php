<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/'; // Şifre sıfırlama tamamlandığında yönlendirilecek sayfa

    // Şifre sıfırlama işlemi tamamlandığında kullanıcıyı yönlendirir
    protected function redirectTo()
    {
        return $this->redirectTo;
    }

    // Şifre sıfırlama işlemi için gerekli olan sayfa
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
