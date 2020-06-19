<?php

namespace App\Http\Livewire;

use App\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Searchstore extends Component
{

    public $search = '';
    public $categories = "uncheck";

    use WithPagination;

    public function mount()
    {
        $this->categories = Product::select('category')->distinct()->get();
        // $this->categories = $this->categories->find('name');
        // $task = $this->tasks->find($id)
    }
    public function render()
    {
        return view('livewire.searchstore', [
            'products' => Product::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('sku', 'LIKE', "%$this->search%")
            ->orWhere('category', 'LIKE', "%$this->search%")->paginate(9),
        ]);
    }
}
