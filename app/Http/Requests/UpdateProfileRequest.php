<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'nullable|string|max:20', // Telefon numarası, isteğe bağlı ve maksimum 20 karakter
            'birthday' => 'nullable|date', // Doğum tarihi, isteğe bağlı ve tarih formatında olmalı
        ];
    }
    
}
