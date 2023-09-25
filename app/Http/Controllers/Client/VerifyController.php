<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class VerifyController extends Controller
{
    public function verifyEmail($token)
    {
        $user = User::where('email_verification_token', $token)->first();

        if ($user) {
            $user->email_verified_at = now();
            $user->status = 1;
            $user->email_verification_token = null;
            $user->save();
            session()->flash('success', 'E-posta adresiniz başarıyla doğrulandı.');
            return redirect()->route('client.login');
        } else {
            session()->flash('error', 'Geçersiz doğrulama kodu.');
            return redirect()->route('client.login');
        }
    }
}
