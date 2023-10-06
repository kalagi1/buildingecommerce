<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\OfferProjectBelongsTo;

class UpdateOfferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'discount_amount' => 'required|integer|min:0',
            'project_id' => 
            [
                'required',
                'exists:projects,id',
                new OfferProjectBelongsTo,
            ],
            'project_housings' => 'required|array',
            'project_housings.*' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ];
    }
}
