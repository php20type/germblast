<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * An email address that also has a real-looking domain (name@company.com).
 * Laravel's plain "email" rule accepts "name@company" with no extension.
 */
class StrictEmail implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = (string) $value;

        if (! filter_var($value, FILTER_VALIDATE_EMAIL) || ! preg_match('/^[^\s@]+@[^\s@]+\.[A-Za-z]{2,}$/', $value)) {
            $fail('Please enter a valid email address.');
        }
    }
}
