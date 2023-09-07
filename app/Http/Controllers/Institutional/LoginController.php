<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('institutional.login.index');
    }

    public function login(Request $request)
    {
        // Validate the form data
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt to log in the user using the institutional guard
        $credentials['type'] = 2; // Ekledik
        if (Auth::guard('institutional')->attempt($credentials)) {
            // Authentication success
            // You can redirect the user or perform other actions here
            return redirect()->intended(route('institutional.dashboard')); // Change 'institutional.dashboard' to your dashboard route
        }
        
        // Authentication failed, redirect back with an error message
        return redirect()->route('institutional.login')->with('error', 'Kullanıcı bilgileri hatalı.');
    }
}
