<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Mail\CustomMail;
use App\Models\EmailTemplate;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class LoginController extends Controller
{
    public function index()
    {
        return view('institutional.login.index');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where("email", $request->email)->first();

        if ($user) {

            if ($user->status == 0) {
                $this->sendVerificationEmail($user);
                session()->flash('warning', 'Giriş Başarısız. Hesabınızı etkinleştirmek için lütfen e-posta adresinize gönderilen doğrulama bağlantısını tıklayarak e-postanızı onaylayın.');
                return redirect()->route('institutional.login');
            } elseif ($user->status == 5) {
                session()->flash('warning', 'Bu kullanıcının hesabı geçici olarak askıya alınmıştır. Hesabınızın yeniden etkinleştirilmesi için lütfen yöneticinizle iletişime geçin.');
                return redirect()->route('institutional.login');
            } elseif ($user->status == 1) {
                if (Auth::attempt($credentials)) {
                    $user = Auth::user();
                    if ($user->type == 3) {
                        // Giriş başarılı
                        return redirect()->intended('/admin'); // Admin paneline yönlendir
                    } elseif ($user->type != "1" && $user->type != "3") {
                        return redirect()->intended(route('index'));
                    } else {
                        Auth::logout();
                        return redirect()->back()->withInput()->withErrors(['email' => 'Giriş başarısız. Yetkiniz yok.']);
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
}
