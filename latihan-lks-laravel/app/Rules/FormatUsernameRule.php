<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class FormatUsernameRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        preg_match('/^(?=.*[A-Z])(?=.*[a-z](?=.*\d)(?=.*[!@#$%^&*()_+{}|[]\:";?.,><])).+$/', $value);
    }

    public function message(){
        return "Username harus mengandung minimal 1 huruf besar, 1 huruf kecil, 1 angka, dan 1 karakter";
    }
}