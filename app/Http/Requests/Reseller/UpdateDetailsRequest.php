<?php

namespace App\Http\Requests\Reseller;

use App\Http\Requests\Request;
use App\Reseller;

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
            'state' => 'required',
        ];

        return $rules;
    }
}
