<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\OfferProjectBelongsTo;

class CreateOfferRequest extends FormRequest
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
            'type' => 'required|in:housing,project',
            'housing_id' => 'required_if:type,housing|exists:housings,id',
            'project_id' => 
            [
                'required_if:type,project',
                'exists:projects,id',
                new OfferProjectBelongsTo,
            ],
            'project_housings' => 'array',
            'project_housings.*' => 'integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ];
    }

    public function messages()
    {
        return
        [
            'discount_amount' => 1,
            'type' => 2,
            'housing_id' => 3,
            'project_id' => 4,
            'project_housings' => 5,
            'project_housings.*' => 6,
            'start_date' => 7,
            'end_date' => 8,
        ];
    }
}
