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
    public $name;

    protected $listeners = ['refreshTransactions' => '$refresh'];

    protected $rules = [
        'password'              => ['required', 'confirmed', 'min:8'],
        'password_confirmation' => ['required'],
        'name'                  => ['required'],
    ];

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }


    public function saveauth(){
        $this->user->password = Hash::make($this->password);
        $this->user->save();
        $this->notify('User ' . $this->user->name . ' Password updated successfully','success');

    }

    public function generateToken(){
        if($this->name){
            $user = Auth::user()->createToken($this->name)->plainTextToken;
            $this->token = $user;
            $this->emit('refreshTransactions');
        }
    }

    public function deleteToken($tokenId){
        Auth::user()->tokens()->where('id', $tokenId)->delete();
        $this->emit('refreshTransactions');
    }

    public function render(Request $request)
    {
        return view('livewire.user.security');
    }
}
