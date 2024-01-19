<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Nin implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        //
       return  strlen($value) === 13 && preg_match("/^[1-2]{12}$/", $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Numéro de téléphone invalide.';
    }
}
