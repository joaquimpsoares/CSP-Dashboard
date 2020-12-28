<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

    class UserController extends Controller
    {
        /**
        * Store a newly created resource in storage.
        *
        * @param  \Illuminate\Http\Request  $userequest
        * @return \Illuminate\Http\Response
        */
        public function store(Request $request)
        {

            $validate = $this->validator($request->all())->validate();

            return $this->userRepository->create($validate, $request->level, $request->id);



    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['sometimes', 'email', 'max:255'],
            'address_1' => ['sometimes', 'string', 'max:255'],
            'address_2' => ['sometimes', 'string', 'max:255'],
            'country_id' => ['sometimes', 'integer', 'min:1'],
            'city' => ['sometimes', 'string', 'max:255'],
            'state' => ['sometimes', 'string', 'max:255'],
            'postal_code' => ['sometimes', 'string', 'regex:/^[0-9A-Za-z.\-]+$/', 'max:255'],
            'status_id' => ['sometimes', 'integer', 'exists:statuses,id'],
            'name' => ['sometimes', 'string', 'max:255'],
            'last_name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'string', 'max:255'],
            'socialite_id' => ['sometimes', 'string', 'max:255'],
            'password' => ['sometimes', 'string', 'max:255'],
            'avatar' => ['sometimes', 'image' => 'mimes:jpg,jpeg,bmp,svg,png,gif', 'max:5000' ]
            ]);
        }
    }
