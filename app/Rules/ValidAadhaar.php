<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidAadhaar implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Remove spaces and hyphens
        $aadhaar = preg_replace('/[\s\-]/', '', $value);
        
        // Check if it's exactly 12 digits
        if (!preg_match('/^[0-9]{12}$/', $aadhaar)) {
            $fail('The :attribute must be a valid 12-digit Aadhaar number.');
        }
    }
}
