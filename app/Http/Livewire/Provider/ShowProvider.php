<?php

namespace App\Http\Livewire\Provider;

use Livewire\Component;

class ShowProvider extends Component
{
    public $provider;

    public function render()
    {
        return view('livewire.provider.show-provider-v2');
    }
}
