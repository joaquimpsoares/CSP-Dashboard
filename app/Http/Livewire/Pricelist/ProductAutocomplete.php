<?php

namespace App\Http\Livewire\Pricelist;

use App\Product;
use App\Http\Livewire\SearchDropdown;

class ProductAutocomplete extends SearchDropdown
{
    protected $listeners = ['valueSelected'];

    public function valueSelected(Product $product)
    {
        $this->emitUp('productSelected', $product);
    }

    public function query() {
        return Product::where('sku', 'like', '%' . $this->search . '%')->orderBy('name');
    }
}
