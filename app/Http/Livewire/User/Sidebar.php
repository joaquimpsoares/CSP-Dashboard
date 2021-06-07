<?php

namespace App\Http\Livewire\User;

use Livewire\Component;

class Sidebar extends Component
{
    public $user;
    public function render()
    {
        return view('livewire.user.sidebar');
    }
}
