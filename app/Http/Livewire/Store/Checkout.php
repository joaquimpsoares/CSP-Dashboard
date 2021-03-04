<?php

namespace App\Http\Livewire\Store;

use App\Cart;
use App\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Web\CartController;


class Checkout extends Component
{

    public $currentProduct = 1;

    public function mount()
    {
        $this->currentProduct = new Product();
    }

    public function increment()
    {

        $this->currentProduct++;

    }



    public function removeItem($item_pivot_id)
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->latest()->first();
        $cart->products()->wherePivot('id', $item_pivot_id)->detach();
    }

    public function render()
    {
        return view('livewire.store.checkout', [
            'cart' => CartController::getPendingCart(),
        ]);
    }
}
