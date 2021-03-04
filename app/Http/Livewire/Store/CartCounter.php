<?php

namespace App\Http\Livewire\Store;

use App\Cart;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Web\CartController;

class CartCounter extends Component
{
    protected $listeners = ['updateCart' => 'open'];

    public $cartOpen = false;
    public $isOpen = false;

    public function close()
    {
        $this->cartOpen = false;
        $this->isOpen = false;
    }

    public function open()
    {
        $this->cartOpen = true;
        $this->isOpen = true;
    }

    public function removeItem($item_pivot_id)
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->latest()->first();
        $cart->products()->wherePivot('id', $item_pivot_id)->detach();
    }


    public function render()
    {
        return view('livewire.store.cart-counter', [
            'cart' => CartController::getPendingCart(),
        ]);
    }
}
