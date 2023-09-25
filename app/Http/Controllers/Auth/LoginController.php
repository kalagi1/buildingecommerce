<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
     // Google ile giriş yapma işlemi
     public function redirectToGoogle()
     {
         return Socialite::driver('google')->redirect();
     }

     public function handleGoogleCallback()
     {
         $user = Socialite::driver('google')->user();
         return $user;
         // Kullanıcıyı veritabanına kaydedebilir veya giriş yapabilirsiniz

         return redirect()->route('dashboard'); // Giriş sonrası yönlendirilecek sayfa
     }

     // Facebook ile giriş yapma işlemi
     public function redirectToFacebook()
     {
         return Socialite::driver('facebook')->redirect();
     }

     public function handleFacebookCallback()
     {
         $user = Socialite::driver('facebook')->user();
         // Kullanıcıyı veritabanına kaydedebilir veya giriş yapabilirsiniz

         return redirect()->route('dashboard'); // Giriş sonrası yönlendirilecek sayfa
     }
}
