<?php

namespace App\Rules;

use App\Countryrules;
use Illuminate\Http\Client\Request;
use Illuminate\Contracts\Validation\Rule;

class checkPostalCodeRule implements Rule
{
    private $reg;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($country)
    {
        $this->reg = Countryrules::where('iso2code', $country)->first();

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
       return preg_match("/".$this->reg->postalCodeRegex."/", $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid postal Code';
    }
}
