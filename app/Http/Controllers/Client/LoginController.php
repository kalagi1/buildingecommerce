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
        //DB::table('users')->insert(['name' => 'test', 'email' => 'test@test.com', 'password' => Hash::make('test'), 'type' => 'admin','status'=>1]);
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Check if the user's type is 3 (or the desired type)
            if ($user->type == 3) {
                // Giriş başarılı
                return redirect()->intended('/admin'); // Admin paneline yönlendir
            } else {
                return redirect()->intended('/user');
            }
        }

        return redirect()->back()->withInput()->withErrors(['email' => 'Giriş başarısız. Lütfen tekrar deneyin.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/user/login');
    }
}
