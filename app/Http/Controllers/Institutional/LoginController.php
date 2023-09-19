<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Return_;

class LoginController extends Controller
{
    public function index(){
        return view('institutional.login.index');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
   

            if ($user->type == "2") {
                // Giriş başarılı
                return redirect()->intended(route('institutional.index'));
            } else {
                // Type 3 user restriction
                Auth::logout();
                return redirect()->back()->withInput()->withErrors(['email' => 'Giriş başarısız. Yetkiniz yok.']);
            }
        }

        // Authentication failed, redirect back with an error message
        return redirect()->route('institutional.login')->with('error', 'Kullanıcı bilgileri hatalı.');
    }
}
