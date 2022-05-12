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
use Illuminate\Support\Facades\Log;
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
    public $isAvailable = true;
    public $perpetual = false;
    public $showDeleteModal = false;
    public $password_confirmation;
    public $showImportModal = false;
    public $showEditModal = false;

    public Product $editing;
    public $filters = [
        'search' => '',
        'name' => null,
        'description' => null,
    ];
    public $search = '';
    public $selectedProducts = [];
    public bool $bulkDisabled = true;

    public function mount(){$this->editing = $this->makeBlankTransaction();}
    public function updatingSearch(){$this->resetPage();}
    public function import(){$this->showImportModal = true;}


    public function rules()
    {
        return [
            'editing.name'                      => 'required'|'string'|'regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/'|'max:255',
            'editing.description'               => 'required'|'min:3',
            'editing.vendor'                    => 'required'|'integer'|'min:1',
            'editing.sku'                       => 'required'|'string'|'max:255'|'min:3',
            'editing.catalog_item_id'           => 'nullable'|'string'|'max:255'|'min:3',
            'editing.vendor'                    => 'required'|'string'|'max:255'|'min:3',
            'editing.productType'               => 'required'|'string'|'max:255'|'min:3',
            'editing.minimum_quantity'          => 'required'|'string'|'max:255'|'min:3',
            'editing.maximum_quantity'          => 'required'|'integer'|'exists:statuses,id',
            'editing.limit'                     => 'nullable'|'integer'|'min:3',
            'editing.term'                      => 'required'|'integer'|'exists:price_list,id',
            'editing.supported_billing_cycles'  => 'required'|'integer'|'exists:price_list,id',
            'editing.terms'                     => 'required'|'integer'|'exists:price_list,id',
            'editing.resellee_qualifications'   => 'required'|'integer'|'exists:price_list,id',
            'is_available_for_purchase'         => 'required',
        ];
    }

    public function edit(Product $product)
    {
        $this->showEditModal = true;
        $this->useCachedRows();

        if ($this->editing->isNot($product)) $this->editing = $product;
        $this->editing = $product;
    }

    public function save(){

        $this->editing->is_available_for_purchase = $this->isAvailable;
        $this->editing->save();
        $this->showEditModal = false;
    }

    public function makeBlankTransaction(){return Product::make(['date' => now(), 'status' => 'success']);}

    public function deleteSelected(){
        $deleteCount = $this->selectedRowsQuery->count();
        foreach($this->selectedRowsQuery->get() as $row){
            if($row->hasPrice() != null) {
                $product = $row->name;
                $this->notify('','This Product '. $product . ' has a price associated, cannot be deleted','error');
                $this->showDeleteModal = false;
                return false;
            }elseif($row->hasPrice() == null){
                $this->selectedRowsQuery->delete();
                $this->showDeleteModal = false;
            }
        }
        $this->notify('You\'ve deleted '.$deleteCount.' Product');
    }


    public function importproducts(){

        if($this->license == true){

            Log::info('Started importing NCE');

            $id = Auth::user()->provider->id;
            $product = new Product();
            $provider = Provider::where('id', $id)->select('country_id')->first();
            $country = Country::select('iso_3166_2')->where('id', $provider->country_id)->first();
            $instance = Instance::where('provider_id', $id)->first();

            $product->importNCELicenses($instance, $country);
        }

        if($this->perpetual == true){

            Log::info('Started importing Perpetual');
            $id = Auth::user()->provider->id;
            $product = new Product();
            $provider = Provider::where('id', $id)->select('country_id')->first();
            $country = Country::select('iso_3166_2')->where('id', $provider->country_id)->first();
            $instance = Instance::where('provider_id', $id)->first();

            $product->importPerpetual($instance, $country);

            $this->notify('Perpetual Software has been scheduled for import');
        }
        $this->showImportModal = false;
    }

    public function getRowsQueryProperty(){
        $products = Product::query()
        ->where(function ($query)  {
            $query->where('id', "like", "%{$this->filters['search']}%");
            $query->orWhere('sku', 'like', "%{$this->filters['search']}%");
            $query->orWhere('name', 'like', "%{$this->filters['search']}%");
            $query->orWhere('productType', 'like', "%{$this->filters['search']}%");
            $query->orWhere('category', 'like', "%{$this->filters['search']}%");
        })->
        with(['instance']);

        return $this->applySorting($products);
    }
    public function getRowsProperty(){
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function exportSelected(){
        return Excel::download(new ProductsExport, 'products.xlsx');
    }
    public function render()
    {
        return view('livewire.product.product-table', [
            'products' => $this->rows,
        ]);
    }
}
