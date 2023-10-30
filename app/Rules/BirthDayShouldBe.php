<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class BirthDayShouldBe implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value >= date('Y-m-d')) {
            $fail('The :attribute : Date of birth must be smaller than today\'s date ' . date('Y-m-d'));
        }
    }
}