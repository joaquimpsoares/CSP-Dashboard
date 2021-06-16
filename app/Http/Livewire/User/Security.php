<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Security extends Component
{
    public $token;

    public function generateToken()
    {
        $user = Auth::user()->createToken('myapp')->plainTextToken;
        // dd($user);
        $this->token = $user;
    }

    public function render()
    {
        return view('livewire.user.security');
    }
}
