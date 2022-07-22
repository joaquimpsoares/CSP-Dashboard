<?php

namespace App\Http\Livewire\Instance;

use Livewire\Component;

class ShowInstance extends Component
{
    public $instance;
    public $expiration;

    public function clear(){

        $this->instance->external_token = null;
        $this->instance->external_token_updated_at = null;
        $this->instance->save();

    }

    public function render()
    {
        return view('livewire.instance.show-instance');
    }
}
