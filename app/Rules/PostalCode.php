<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * A zip / postal code of 3 to 10 characters: letters, digits, spaces and dashes (US, Canada, UK and others).
 */
class PostalCode implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! preg_match('/^[A-Za-z0-9][A-Za-z0-9 \-]{1,8}[A-Za-z0-9]$/', (string) $value)) {
            $fail('Please enter a valid zip / postal code.');
        }
    }
}
