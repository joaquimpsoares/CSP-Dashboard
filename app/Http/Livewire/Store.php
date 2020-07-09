<?php

namespace App\Http\Livewire;

use App\Product;
use Livewire\Component;

class Store extends Component
{
    // [
    //     'prices' => Price::having('price_list_id', $this->priceList)->where('name', 'like', '%' . $this->search . '%')
    //     ->orwhere('product_sku', 'LIKE', "%$this->search%")->paginate(9),
    // ]);
    public function render()
    {
        return view('livewire.store', [
            'products' => Product::select('vendor')->groupby('vendor')->get(),
        ]);
    }
}
