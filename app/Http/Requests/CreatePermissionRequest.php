<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePermissionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'permission_group_id' => 'required|exists:permission_groups,id',
            'key' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'is_active' => 'boolean',
        ];
    }
}
