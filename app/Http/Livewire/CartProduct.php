<?php

namespace App\Http\Livewire;

use App\Product;
use Livewire\Component;
use App\Http\Traits\UserTrait;
use App\CartProduct as AppCartProduct;

class CartProduct extends Component
{
    use UserTrait;
    

    public $products =[];

    public function mount()
    {
        $this->products = Product::get();
        
    }
    
    public function render()
    {
        return view('livewire.cart-product');
        }
    }
