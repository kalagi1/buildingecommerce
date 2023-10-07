<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required',
            'content' => 'required',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
            'meta_author' => 'nullable|string|max:255',
            'location' => 'required|in:header,footer',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Başlık alanı zorunludur.',
            'content.required' => 'İçerik alanı zorunludur.',
            'meta_title.max' => 'Meta başlığı en fazla :max karakter olabilir.',
            'meta_description.max' => 'Meta açıklaması en fazla :max karakter olabilir.',
            'meta_keywords.max' => 'Meta anahtar kelimeleri en fazla :max karakter olabilir.',
            'meta_author.max' => 'Meta yazarı en fazla :max karakter olabilir.',
        ];
    }
}
