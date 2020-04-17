<?php

namespace App\Http\Requests\Customer;

use App\Http\Requests\Request;
use App\Customer;

class UpdateDetailsRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            'company_name' => 'required',
            'nif' => 'required|min:5',
            'country' => 'required|not_in:0|exists:countries,id',
        ];

        return $rules;
    }
}
