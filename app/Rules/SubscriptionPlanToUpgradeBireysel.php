<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SubscriptionPlanToUpgradeBireysel implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $data = SubscriptionPlan::where('plan_type', 'Bireysel')->where('id', $value)->first();
        if (!$data)
            $fail('Geçerli bir plan seçiniz.');
    }
}
