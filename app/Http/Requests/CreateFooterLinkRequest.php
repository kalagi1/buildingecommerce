<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFooterLinkRequest extends FormRequest
{
    public function authorize()
    {
        return true; // İsteği her zaman kabul et
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'widget' => 'required|string|max:255',
        ];
    }
}
