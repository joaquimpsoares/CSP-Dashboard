<?php

namespace App\Rules;

use App\Countryrules;
use Illuminate\Contracts\Validation\Rule;

class checkvatIdRule implements Rule
{
    private $reg;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($vatid)
    {
        $this->reg = Countryrules::where('iso2code', $vatid)->first();
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
        return preg_match("/".$this->reg->vatIdRegex."/", $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid Vat ID Format for Country, use the following format (' .$this->reg->taxIdFormat.")";
    }
}
