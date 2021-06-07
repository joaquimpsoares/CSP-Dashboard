<?php

namespace App\Http\Livewire\User;

use Livewire\Component;

class Gdpr extends Component
{

    public function getGDPR()
    {
        $this->notify('Request submited successfully');

    }
    public function render()
    {
        return view('livewire.user.gdpr');
    }
}
