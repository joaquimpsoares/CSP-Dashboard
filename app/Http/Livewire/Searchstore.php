<?php

namespace App\Http\Livewire;

use App\Price;
use App\Vendor;
use App\Product;
use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Traits\UserTrait;

class Searchstore extends Component
{
    use UserTrait;
    
    public $search = '';
    public $categories = '';
    public $prices = "null";
    // public $products = [];

    use WithPagination;

    public function mount()
    {
        $user = $this->getUser();

        $priceList = $user->reseller->priceList->id;
        $this->products = Price::where('price_list_id', $priceList)->paginate(9);

    }

    public function searchCategory($name)
    {
         $this->search = $name;
    }

    public function render()
    {
        return view('livewire.searchstore', [
            'products' => Product::where('name', 'like', "%$this->search%")
            ->orWhere('sku', 'LIKE', "%$this->search%")
            ->orWhere('category', 'LIKE', "%$this->search%")->paginate(9),
        ]);
    }
}
