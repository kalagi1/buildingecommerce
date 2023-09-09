<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Check if the user's type is 3 (or the desired type)
            if ($user->type == 3) {
                // Giriş başarılı
                return redirect()->intended('/admin'); // Admin paneline yönlendir
            } else {
                // Type 3 user restriction
                Auth::logout();
                return redirect()->back()->withInput()->withErrors(['email' => 'Giriş başarısız. Yetkiniz yok.']);
            }
        }

        return redirect()->back()->withInput()->withErrors(['email' => 'Giriş başarısız. Lütfen tekrar deneyin.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/admin/login');
    }
}
