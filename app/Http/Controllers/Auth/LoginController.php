<?php

namespace App\Http\Controllers\Auth;

use Laravel\Socialite\Facades\Socialite;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();

        // Google'dan dönen kullanıcı bilgileriyle işlem yapabilirsiniz

        return redirect('/dashboard');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Facebook ile giriş yapılırken bir hata oluştu.');
        }
    
        // Facebook kullanıcısını alıp veritabanında arama yapma
        $user = User::where('facebook_id', $facebookUser->id)->first();
    
        if ($user) {
            // Kullanıcı zaten varsa, oturum aç
            Auth::login($user);
            return redirect('/')->with('success', 'Başarıyla giriş yapıldı.');
        } else {
            // Kullanıcı yoksa, yeni bir kullanıcı oluştur
            $newUser = new User();
            $newUser->name = $facebookUser->name;
            $newUser->email = $facebookUser->email;
            $newUser->facebook_id = $facebookUser->id;
            $newUser->save();
    
            // Oturum aç
            Auth::login($newUser);
            return redirect('/dashboard')->with('success', 'Yeni hesap oluşturuldu ve başarıyla giriş yapıldı.');
        }
    }


}
