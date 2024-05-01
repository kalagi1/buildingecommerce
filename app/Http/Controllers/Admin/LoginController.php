<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;
use Hash;
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
        //DB::table('users')->insert(['name' => 'test', 'email' => 'test@test.com', 'password' => Hash::make('test'), 'type' => 'admin','status'=>1]);
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Check if the user's type is 3 (or the desired type)
            if ($user->type == 3 || $user->parent_id == 4) {
                // Giriş başarılı
                return redirect()->intended('/qR9zLp2xS6y/secured/admin'); // Admin paneline yönlendir
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
        session()->forget('cart');

        return redirect('/qR9zLp2xS6y/secured/login');
    }
}
