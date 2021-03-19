<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ShowProfile extends Component
{
    public function render()
    {

        $account = Auth::user()->provider;

        return view('livewire.profile.show-profile', compact('account'));
    }
}
