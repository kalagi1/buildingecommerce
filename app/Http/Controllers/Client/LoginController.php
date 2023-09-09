<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('client.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->type == 3) {
                // Giriş başarılı
                return redirect()->intended('/admin'); // Admin paneline yönlendir
            } elseif ($user->type == 2) {
                // Giriş başarılı
                return redirect()->intended('/institutional'); // Admin paneline yönlendir
            } else {
                return redirect()->intended('/client');
            }
        }

        return redirect()->back()->withInput()->withErrors(['email' => 'Giriş başarısız. Lütfen tekrar deneyin.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
