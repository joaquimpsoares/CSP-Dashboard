<?php

namespace App\Http\Livewire\Customer;

use Livewire\Component;

class Home extends Component
{
    public $customer;
    public $subscriptions;

    public function mount(){
    }

    public function render()
    {

        $customer=$this->customer;
        $subscriptions=$this->subscriptions;
    
        return view('livewire.customer.home', compact('customer','subscriptions'));
    }
}
