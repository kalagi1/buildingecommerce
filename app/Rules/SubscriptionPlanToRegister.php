<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\SubscriptionPlan;

class SubscriptionPlanToRegister implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (request()->get('type') == '2')
        {
            $data = SubscriptionPlan::where('plan_type', request()->get('corporate-account-type') ?? null)->where('id', $value)->first();
            if (!$data)
                $fail('Geçerli bir plan seçiniz.');
        }
    }
}
