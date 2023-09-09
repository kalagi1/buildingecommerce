<?php

namespace App\Http\Controllers\ClientPanel;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function edit()
    {
        return view('clientPanel.change-password');
    }

    public function update(Request $request)
    {

        $user = User::where("id", auth()->user()->id)->first();

        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:5|confirmed',
        ], [
            'current_password.required' => 'Mevcut şifre alanı zorunludur.',
            'new_password.required' => 'Yeni şifre alanı zorunludur.',
            'new_password.min' => 'Yeni şifre en az :min karakter olmalıdır.',
            'new_password.confirmed' => 'Yeni şifreler uyuşmuyor.',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Mevcut şifre hatalı.']);
        }

        // Yeni şifreyi güncelle
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('client.password.edit')->with('success', 'Şifreniz başarıyla değiştirildi.');
    }
}
