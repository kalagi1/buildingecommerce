<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function edit()
    {
        return view('client.panel.change-password');
    }

    public function update(Request $request)
    {
        $user = User::findOrFail(auth()->user()->id);
    
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'Mevcut şifre alanı zorunludur.',
            'new_password.required' => 'Yeni şifre alanı zorunludur.',
            'new_password.min' => 'Yeni şifre en az :min karakter olmalıdır.',
            'new_password.confirmed' => 'Yeni şifreler uyuşmuyor.',
        ]);
    
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('institutional.password.edit')
                ->withErrors(['current_password' => 'Mevcut şifre hatalı.'])
                ->withInput();
        }
    
        $user->password = Hash::make($request->new_password);
        $user->save();
    
        return redirect()->route('institutional.password.edit')->with('success', 'Şifreniz başarıyla değiştirildi.');
    }
    
}
