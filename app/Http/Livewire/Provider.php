<?php

namespace App\Http\Livewire;

use App\Provider as Prov;
use Livewire\Component;

class Provider extends Component
{
    public $prov;

    public function render()
    {

    $this->prov = Prov::orderBy('company_name')
		->with('country')
		->get()
        ;
        
        return view('livewire.provider');
    }
}
