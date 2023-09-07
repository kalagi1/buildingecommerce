<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePageRequest extends FormRequest
{
    public function authorize()
    {
        return true; // İsteği her zaman kabul et
    }

    public function rules()
    {
        return [
            'title' => 'required',
            'content' => 'required'
            
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Başlık alanı zorunludur.',
            'content.required' => 'İçerik alanı zorunludur.'
        ];
    }
}
