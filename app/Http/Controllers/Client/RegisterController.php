<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\CustomMail;
use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3',
            'type' => 'required|in:1,2',
        ];

        // Form doğrulama işlemini gerçekleştirin
        $validatedData = $request->validate($rules);
        // Yeni kullanıcıyı oluşturun
        $user = new User();
        $user->email = $validatedData['email'];
        $user->name = $validatedData['name'];
        $user->password = bcrypt($validatedData['password']); // Şifreyi şifreleyin
        $user->type = $validatedData['type'];
        $user->status = 0; // Aktiflik durumunu kontrol edin
        $user->email_verification_token = Str::random(40);
        $user->save();

        $emailTemplate = EmailTemplate::where('slug', "account-verify")->first();

        if (!$emailTemplate) {
            return response()->json([
                'message' => 'Email template not found.',
                'status' => 203,
                'success' => true,
            ], 203);
        }

        $content = $emailTemplate->body;

        $variables = [
            'username' => $validatedData['name'],
            'companyName' => "Emlak Sepeti",
            "email" => $validatedData['email'],
            "token" => $user->email_verification_token,
            "verificationLink" => URL::to("/verify-email/{$user->email_verification_token}"),
        ];

        foreach ($variables as $key => $value) {
            $content = str_replace("{{" . $key . "}}", $value, $content);
        }

        try {
            Mail::to($request->input('email'))->send(new CustomMail($emailTemplate->subject, $content));
            session()->flash('success', 'Hesabınız oluşturuldu. Hesabınızı etkinleştirmek için lütfen e-posta adresinize gönderilen doğrulama bağlantısını tıklayarak e-postanızı onaylayın.');
            return redirect()->route('client.login');

        } catch (\Exception $e) {
            session()->flash('error', 'Hata');
            return redirect()->route('client.login');

        }

    }
}
