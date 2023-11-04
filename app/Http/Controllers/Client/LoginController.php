<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\CustomMail;
use App\Models\City;
use App\Models\EmailTemplate;
use App\Models\SubscriptionPlan;
use App\Models\Town;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        $cities = City::all();

        $towns = Town::all();
        $subscriptionPlans = SubscriptionPlan::all();

        $subscriptionPlans_bireysel = SubscriptionPlan::where('plan_type', 'Bireysel')->get();
        $subscriptionPlans_emlakci = SubscriptionPlan::where('plan_type', 'Emlakçı')->get();
        $subscriptionPlans_banka = SubscriptionPlan::where('plan_type', 'Banka')->get();
        $subscriptionPlans_insaat = SubscriptionPlan::where('plan_type', 'İnşaat')->get();
        return view('client.auth.login', compact("cities", 'subscriptionPlans_bireysel', "towns", 'subscriptionPlans', 'subscriptionPlans_emlakci', 'subscriptionPlans_banka', 'subscriptionPlans_insaat'));

    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where("email", $request->email)->first();

        if ($user) {

            if ($user->status == 0) {
                $this->sendVerificationEmail($user);
                session()->flash('warning', 'Giriş Başarısız. Hesabınızı etkinleştirmek için lütfen e-posta adresinize gönderilen doğrulama bağlantısını tıklayarak e-postanızı onaylayın.');
                return redirect()->route('client.login');
            } elseif ($user->status == 5) {
                // $this->sendVerificationEmail($user);
                session()->flash('warning', 'Bu kullanıcının hesabı geçici olarak askıya alınmıştır. Hesabınızın yeniden etkinleştirilmesi için lütfen yöneticinizle iletişime geçin.');
                return redirect()->route('client.login');
            } elseif ($user->status == 1) {
                if (Auth::attempt($credentials)) {
                    $user = Auth::user();
                    if ($user->type == 3) {
                        // Giriş başarılı
                        return redirect()->intended('/admin'); // Admin paneline yönlendir
                    } elseif ($user->type != 1 && $user->type != "3") {
                        // Giriş başarılı
                        return redirect()->intended('/institutional'); // Admin paneline yönlendir
                    } else {
                        // Oturumda saklanan sepeti kontrol et
                        $cart = session('cart', []);
                        if (count($cart) != 0) {
                            session(['cart' => $cart]);
                        }
                        return redirect()->intended('/hesabim');
                    }
                }

            }
        }

        return redirect()->back()->withInput()->withErrors(['login_error' => "Giriş başarısız. Lütfen bilgilerinizi kontrol edin."]);
    }

    private function sendVerificationEmail(User $user)
    {
        $emailTemplate = EmailTemplate::where('slug', "account-confirmation")->first();

        if (!$emailTemplate) {
            return response()->json([
                'message' => 'Email template not found.',
                'status' => 203,
                'success' => true,
            ], 203);
        }

        $content = $emailTemplate->body;

        $variables = [
            'username' => $user->name,
            'companyName' => "Emlak Sepeti",
            "email" => $user->email,
            "token" => $user->email_verification_token,
            "verificationLink" => URL::to("/verify-email/{$user->email_verification_token}"),
        ];

        foreach ($variables as $key => $value) {
            $content = str_replace("{{" . $key . "}}", $value, $content);
        }

        try {
            Mail::to($user->email)->send(new CustomMail($emailTemplate->subject, $content));
            session()->flash('success', 'Hesabınız oluşturuldu. Hesabınızı etkinleştirmek için lütfen e-posta adresinize gönderilen doğrulama bağlantısını tıklayarak e-postanızı onaylayın.');
            return redirect()->route('client.login');

        } catch (\Exception $e) {
            session()->flash('error', 'Hata');
            return redirect()->route('client.login');

        }
    }
    public function logout()
    {
        Auth::logout();
        session()->forget('cart');

        return redirect('/giris-yap');
    }
}
