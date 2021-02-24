<?php

namespace App\Http\Livewire\Store;

use App\Cart;
use Livewire\Component;
use App\Http\Controllers\Web\CartController;

class CartCounter extends Component
{
    protected $listeners = ['updateCart' => 'render'];

    public function render()
    {
        return view('livewire.store.cart-counter', [
            'cartAmount' => CartController::getPendingCart(),
        ]);
    }
}
