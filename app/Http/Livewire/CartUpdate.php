<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Request;

class CartUpdate extends Component
{
    public $quantity =0;
    public $productspivot =[];
    public $product =[];
    
    
    public function mount($quantity, $productspivot, $product)
    {
        $this->quantity = $quantity;
        $this->productspivot = $productspivot;
        $this->product = $product;   
    }

    // public function changeProductQuantity(Request $request, $item_id, $quantity) {

    //     $cart = $this->getUserCart();

    //     $product = $cart->products->first(function ($value) use ($item_id) {    
    //         return $value->pivot->id == $item_id;
    //     });

    //     if ($this->productRepository->verifyQuantities($product, $quantity)) {
    //         $product->pivot->quantity = $quantity;
    //         $product->pivot->save();
    //         return true;
    //     }        

    //     return false;

    // }
    
    public function render()
    {
        return view('livewire.cart-update');
    }
}
