<?php

namespace App\Http\Livewire\Pricelist;

use App\Price;
use App\Product;
use App\PriceList;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use PhpParser\JsonDecoder;
use PHPUnit\Framework\MockObject\Stub\ReturnSelf;

class ShowPricelist extends Component
{
    use WithPagination;
    use WithPerPagePagination, WithSorting, WithBulkActions,WithCachedRows;

    protected $queryString      = ['sorts'];
    protected $paginationTheme  = 'bootstrap';
    protected $listeners        = ['refreshTransactions' => '$refresh'];

    public $priceList;
    public $products;
    public $search;
    public $showDeleteModal = false;
    public $showEditModal = false;
    public $showFilters = false;
    public $showCreate = false;

    public Price $editing;
    public $filters = [
        'search' => '',
        'name' => null,
        'price' => null,
        'msrp' => null,
    ];


    public function mount() { $this->editing = $this->makeBlankTransaction(); }
    public function makeBlankTransaction() { return Price::make(['date' => now(), 'status' => 'success']); }
    public function resetFilters(){ $this->reset(); }
    public function resetDate() { $this->reset(['taskduedate']); }
    public function toggleShowFilters() { $this->showFilters = ! $this->showFilters; }

    public function rules() {
        return [
            'editing.product_sku'   => 'required|min:3|exists:prices,product_sku',
            'editing.name'          => 'required|min:3',
            'editing.price'         => 'required',
            'editing.msrp'          => 'required',
        ]; }

        public function create()
        {
            $this->showCreate = true;
            $this->useCachedRows();
            if ($this->editing->getKey()) $this->editing = $this->makeBlankTransaction();
            $this->showEditModal = true;
        }

        public function edit(Price $price)
        {
            $this->showEditModal = true;
            $this->showCreate = false;
            $this->useCachedRows();
            $this->editing = $price;
        }

        public function editList(PriceList $pricelist)
        {
            $this->showEditModalpricelist = true;
            $this->useCachedRows();
            $this->editingpricelist = $pricelist;
        }



        public function save()
        {
            $this->validate();
            $this->editing->save();
            $this->showCreate = false;
            $this->showEditModal = false;
            $this->notify('You\'ve updated '.  $this->editing->name .' prices');
        }


        public function savecreate()
        {

            $this->validate();

            $product = Product::where('sku', $this->editing->product_sku)->where('instance_id', $this->priceList->instance_id)->pluck('id')->first();

            $attributes = $this->editing->toArray();

            $tt = $attributes + [
                'product_vendor' => 'microsoft',
                'instance_id' => $this->priceList->instance_id,
                'price_list_id' => $this->priceList->id,
                'product_id' => $product,
            ];

            if(Price::where('product_id', $product)->where('instance_id', $this->priceList->instance_id)->where('price_list_id',$this->priceList->id)->first()){
                $this->showEditModal = false;
                $this->notify('Cannot add the product. '. $tt['name'] . 'This Price already exists in the table');
                return back();
            }

            $price =  Price::create([
                'product_sku'       => $tt['product_sku'],
                'name'              => $tt['name'],
                'price'             => $tt['price'],
                'msrp'              => $tt['msrp'],
                'product_vendor'    => $tt['product_vendor'],
                'instance_id'       => $tt['instance_id'],
                'price_list_id'     => $tt['price_list_id'],
                'product_id'        => $tt['product_id'],
            ]);

            $this->showEditModal = false;
            $this->showCreate = false;
            $fields = collect($this->editing->getChanges())->except(['updated_at']);

            $this->notify('You\'ve updated '.  $fields .' prices');
        }

        public function deleteSelected()
        {

            foreach($this->selectedRowsQuery->get() as $row){
                if($row->related_product->IsSubscribed() == null) {
                    $deleteCount = $this->selectedRowsQuery->count();
                    $this->selectedRowsQuery->delete();
                    $this->notify('You\'ve deleted '.$deleteCount.' Price');
                }else{
                    $deleted = $row->name;
                    $this->notify('This price '. $deleted . 'is already subscribed, cannot be deleted');
                }
                $this->showDeleteModal = false;
            }
        }


        public function sortByColumn($column)
        {
            if ($this->sortColumn == $column) {
                $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
            } else {
                $this->reset('sortDirection');
                $this->sortColumn = $column;
            }
        }

        public function getRowsQueryProperty()
        {
            $prices = Price::query()
            ->where(function ($q)  {
                $q->orwhere('price_list_id', $this->priceList);
                $q->orwhere('name', "like", "%{$this->filters['search']}%");
                $q->orWhere('price', 'like', "%{$this->filters['search']}%");
                $q->orWhere('msrp', 'like', "%{$this->filters['search']}%");
                $q->orwhereHas('product', function(Builder $q){
                    $q->where('category', 'like', "%{$this->filters['search']}%");
                });
            });


            return $this->applySorting($prices);
        }

        public function exportSelected()
        {
            return response()->streamDownload(function () {
                echo $this->selectedRowsQuery->toCsv();
            }, 'transactions.csv');
        }

        public function getRowsProperty()
        {
            return $this->cache(function () {
                return $this->applyPagination($this->rowsQuery->where('price_list_id', $this->priceList->id));
            });
        }


        public function render(PriceList $priceList)
        {
            $priceList = $this->priceList;
            if(isset($priceList->reseller)){
                $resellers=$priceList->reseller->paginate(10);
            }else{
                $resellers='';
            }
            if(isset($priceList->customer)){
                $customers=$priceList->customer->paginate(10);
            }else{
                $customers='';
            }

            $this->products = Product::where('sku', $this->editing->product_sku)->where('instance_id', $this->priceList->instance_id)->pluck('id')->first();

            return view('livewire.pricelist.show-pricelist',[
                'prices' => $this->rows,
            ]);
        }
    }

