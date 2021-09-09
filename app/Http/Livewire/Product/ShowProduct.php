<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;

class ShowProduct extends Component
{
    public $product;
    public function render()
    {
        return view('livewire.product.show-product');
    }
}
