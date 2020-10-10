<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxWordCount implements Rule
{
    private $max_words;
    /**
     * Default 120 words
     *
     * @return void
     */
    public function __construct($max_words = 200)
    {
        $this->max_words = $max_words;
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
        return str_word_count($value) <= $this->max_words;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The description cannot be longer than ' .  $this->max_words . ' words.';
    }
}
