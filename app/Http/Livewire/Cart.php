<?php

namespace App\Http\Livewire;

use App\Cart as Cartdb;
use Livewire\Component;
use App\Http\Traits\UserTrait;

class Cart extends Component
{
    use UserTrait;
    public $cart =[];
    public $quantity =0;
    public $productspivot =[];
    public $products =[];

    
    private function getUserCart()
    {
        $user = $this->getUser();
        $cart = Cartdb::where('user_id', $user->id)->whereNull('customer_id')->with('products')->first();
        
        return $cart;
    }
    
    
    
    public function mount()
    {
        $this->cart = $this->getUserCart();
        $carts=$this->cart;
        $this->products = $carts->products;
        
        // $this->productspivot = $carts->products;
        // dd($this->productspivot);
        
        foreach ($this->products as $product) {
            $this->productspivot = $product->pivot;
            $this->quantity = $product->pivot->quantity;
        }

        
        // dd($this->quantity);

        
    }
    public function render()
    {
        return view('livewire.cart');
    }
}
