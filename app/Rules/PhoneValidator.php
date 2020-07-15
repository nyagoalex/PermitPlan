<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneValidator implements Rule
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
    public function passes($attribute, $value)
    {
           // Validates Phone Number

           $pattern = '/^256[0-9]{9}+$/';
           if (!empty($value)) {
               if (preg_match($pattern, $value)) {
                   return true;
               } else {
                   return false;
               }
           }
           return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid Phone Number';
    }
}
