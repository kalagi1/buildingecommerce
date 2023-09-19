<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
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
        $user->status = 1; // Aktiflik durumunu kontrol edin

        // Kullanıcıyı veritabanına kaydedin
        $user->save();
        session()->flash('success', 'Hesap başarıyla oluşturuldu.');

    }
}
