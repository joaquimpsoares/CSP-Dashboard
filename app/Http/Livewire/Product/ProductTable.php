<?php

namespace App\Http\Livewire\Product;

use App\Order;
use App\Country;
use App\Product;
use App\Instance;
use App\Provider;
use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Traits\UserTrait;
use App\Exports\ProductsExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithPerPagePagination;

class ProductTable extends Component
{
    use WithPagination;
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;
    use UserTrait;

    public $password;
    public $license = false;
    public $perpetual = false;
    public $password_confirmation;
    public $showImportModal = false;
    public $showCreateUser = false;

    public Product $editing;
    public $filters = [
        'search' => '',
        'name' => null,
        'description' => null,
    ];
    public $search = '';
    public $selectedProducts = [];
    public bool $bulkDisabled = true;

    public function mount()
    {
        $this->editing      = $this->makeBlankTransaction();
    }

    public function makeBlankTransaction()
    {
        return Product::make(['date' => now(), 'status' => 'success']);
    }


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function import(){
        $this->showImportModal = true;
    }

    public function importproducts(){

        if($this->license == true){

            $id = Auth::user()->provider->id;
            $product = new Product();
            $provider = Provider::where('id', $id)->select('country_id')->first();
            $country = Country::select('iso_3166_2')->where('id', $provider->country_id)->first();
            $instance = Instance::where('provider_id', $id)->first();

            $product->importLicenses($instance, $country);
            $this->notify('Import Scheduled for licenses');

        }

        if($this->perpetual == true){

            $id = Auth::user()->provider->id;
            $product = new Product();
            $provider = Provider::where('id', $id)->select('country_id')->first();
            $country = Country::select('iso_3166_2')->where('id', $provider->country_id)->first();
            $instance = Instance::where('provider_id', $id)->first();

            $product->importPerpetual($instance, $country);

            $this->notify('Import Scheduled for perpetual');
        }
        $this->showImportModal = false;
    }

    public function getRowsQueryProperty()
    {
        $products = Product::query()
        ->where(function ($query)  {
            $query->where('id', "like", "%{$this->filters['search']}%");
            $query->orWhere('sku', 'like', "%{$this->filters['search']}%");
            $query->orWhere('name', 'like', "%{$this->filters['search']}%");
            $query->orWhere('category', 'like', "%{$this->filters['search']}%");
        })->
        with(['instance']);

        return $this->applySorting($products);
    }
    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function exportSelected()
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }
    public function render()
    {
        return view('livewire.product.product-table', [
            'products' => $this->rows,
        ]);
    }
}
