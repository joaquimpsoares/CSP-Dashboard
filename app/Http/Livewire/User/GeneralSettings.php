<?php

namespace App\Http\Livewire\User;

use App\User;
use App\Country;
use Livewire\Component;



class GeneralSettings extends Component
{
    public User $editing;

    public function mount(User $user){
        $this->editing = $user;
    }

    public function rules()
    {
        return [
            'editing.name'         => ['required', 'string', 'regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/', 'max:255'],
            'editing.last_name'    => ['required', 'min:3'],
            'editing.socialite_id' => ['required', 'integer', 'min:1','exists:countries,id'],
            'editing.email'        => ['required', 'email', 'unique:users', 'max:255', 'min:3'],
            'editing.phone'        => ['required', 'string', 'max:255', 'min:3'],
            'editing.username'     => ['required', 'string', 'max:255', 'min:3'],
            'editing.address'      => ['required', 'string', 'max:255', 'min:3'],
            'editing.city'         => ['required', 'string', 'max:255', 'min:3'],
            'editing.state'        => ['required', 'string', 'max:255', 'min:3'],
            'editing.postal_code'  => ['required', 'string', 'max:255', 'min:3'],
            'editing.status_id'    => ['required', 'exists:statuses,id'],
            'editing.country_id'   => ['required', 'exists:countries,id'],
            'editing.locale'       => ['required', 'string', 'max:255', 'min:3'],

            // 'password'                      => ['same:password_confirmation', 'required', 'min:6'],
            // 'password_confirmation'         => ['same:password', 'required', 'min:6'],
        ];
    }
    public function render(User $user)
    {
        $countries = Country::get();
        return view('livewire.user.general-settings', compact('user','countries'))->extends('layouts.master');
    }
}
