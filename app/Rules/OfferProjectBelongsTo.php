<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Project;

class OfferProjectBelongsTo implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!Project::where('user_id', auth()->user()->id)->where('id', $value)->first())
            $fail('Geçerli bir proje seçiniz.');
    }
}
