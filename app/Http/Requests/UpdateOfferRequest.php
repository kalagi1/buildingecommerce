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
}
