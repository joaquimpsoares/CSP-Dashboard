<?php

namespace App\Http\Livewire;

use App\Product;
use Livewire\Component;


class Filterstore extends Component
{
    public $filter = '';
    
    public function render()
    {
        return view('livewire.filterstore',[
            
            'categories' => Product::select('category')->distinct()->where("name", 'like', "%$this->filter%")->get(),

        ]);
    }
}
