<?php

namespace App\Http\Livewire\Product;

use App\Product;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;

class ProductTable extends Component
{
    use WithPagination;
    public $search = '';
    public $selectedProducts = [];
    public bool $bulkDisabled = true;

    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function exportSelected()
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }
    public function render()
    {
        $this->bulkDisabled = count($this->selectedProducts) < 1;

        $search = $this->search;

        $query = Product::query();

        $products = $query
        ->where(function ($q)  {
            $q->where('id', "like", "%{$this->search}%");
            $q->orWhere('sku', 'like', "%{$this->search}%");
            $q->orWhere('name', 'like', "%{$this->search}%");
            $q->orWhere('category', 'like', "%{$this->search}%");
        })->
        with(['instance'])->paginate(10);

        $products->getCollection()->map(function(Product $product){
            $product->setRawAttributes(json_decode(json_encode($product->format()), true)); // Coverts to array recursively (make helper from it?)
            return $product;
        });

        return view('livewire.product.product-table', compact('products'));
    }
}
