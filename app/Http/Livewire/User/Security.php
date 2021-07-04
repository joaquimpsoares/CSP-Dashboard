<?php

namespace App\Http\Livewire\User;

use App\User;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Security extends Component
{
    public $user;
    public $password;
    public $password_confirmation;
    public $token;


    protected $rules = [
        'password'              => ['required', 'confirmed', 'min:8'],
        'password_confirmation' => ['required'],
    ];


    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    public function saveauth()
    {
        dump($this->user->password);
        $this->validate();
        $this->user->password = Hash::make($this->password);
        $this->user->update();

        session()->flash('success','User ' . $this->user->name . ' Password updated successfully');
        return redirect()->to('/');
    }

    public function generateToken()
    {
        $user = Auth::user()->createToken('myapp')->plainTextToken;
        // dd($user);
        $this->token = $user;
    }

    public function render(Request $request)
    {
        return view('livewire.user.security');
    }
}
