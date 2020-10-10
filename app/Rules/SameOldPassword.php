<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class SameOldPassword implements Rule
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
        
        $samePassword = \Hash::check($value, auth()->user()->password);
        
        return !$samePassword;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return lang('same_old_password');
    }
}
