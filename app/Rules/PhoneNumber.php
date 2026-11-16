<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * A phone number with 7 to 15 digits. Spaces, dashes, dots, brackets and a leading + are allowed,
 * so US style (123-456-7890) and international numbers (+44 20 7946 0958) both pass.
 */
class PhoneNumber implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = (string) $value;
        $digits = strlen(preg_replace('/\D/', '', $value));

        if (! preg_match('/^\+?[0-9\s().\-]+$/', $value) || $digits < 7 || $digits > 15) {
            $fail('Please enter a valid phone number.');
        }
    }
}
