<?php

namespace App\Http\Livewire\Pricelist;

use App\Csv;
use App\Price;
use App\Product;
use App\Instance;
use App\PriceList;
use Livewire\Component;
use PhpParser\JsonDecoder;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithBulkActions;
use PHPUnit\Framework\MockObject\Stub\ReturnSelf;
use App\Http\Livewire\DataTable\WithPerPagePagination;

class ShowPricelist extends Component
{
    use WithPagination;
    use WithFileUploads;
    use WithPerPagePagination, WithSorting, WithBulkActions,WithCachedRows;

    protected $queryString      = ['sorts'];
    protected $paginationTheme  = 'bootstrap';
    protected $listeners        = ['refreshTransactions' => '$refresh'];

    public $priceList;
    public $products;
    public $search;
    public $license;
    public $perpetual;
    public $showImportModal = false;
    public $showDeleteModal = false;
    public $showEditModal = false;
    public $showFilters = false;
    public $showCreate = false;


    public Price $editing;

    public $filters = [
        'search' => '',
        'categories' => null,
        'price' => null,
        'msrp' => null,
    ];


    public function mount() { $this->editing = $this->makeBlankTransaction(); }
    public function makeBlankTransaction() { return Price::make(['date' => now(), 'status' => 'success']); }
    public function resetFilters(){ $this->reset(); }
    public function resetDate() { $this->reset(['taskduedate']); }
    public function toggleShowFilters() { $this->showFilters = ! $this->showFilters; }

    public function rules() {
        // dd(0);
        return [
            'fieldColumnMap.name' => 'required',
        'fieldColumnMap.product_sku' => 'required',
        'editing.product_sku'   => 'required|min:3|exists:products,sku',
            'editing.product_sku'   => 'required|min:3|exists:products,sku',
            'editing.product_id'   => 'required|min:3|exists:products,sku',
            'editing.instance_id'   => 'required|min:3|exists:products,sku',
            'editing.price_list_id'   => 'required|min:3|exists:products,sku',
            'editing.name'          => 'required|min:3',
            'editing.currency'      => 'required|min:2',
            'editing.market'        => 'required|min:2',
            'editing.term_duration' => 'required|min:2',
            'editing.billing_plan'  => 'required|min:2',
            'editing.price'         => 'required',
            'editing.msrp'          => 'required',
            'editing.product_vendor'          => 'required',
        ];
    }


    public $showModal = false;
    public $upload;
    public $columns;
    public $fieldColumnMap = [
        'type'              => '',
        'name'              => '',
        'product_sku'       => '',
        'instance_id'       => '',
        'currency'          => '',
        'market'            => '',
        'term_duration'     => '',
        'product_vendor'    => '',
        'price'             => '',
        'billing_plan'      => '',
        'msrp'              => '',
        'currency'          => '',
    ];

    // protected $rules = [
    //     'fieldColumnMap.name' => 'required',
    //     'fieldColumnMap.product_sku' => 'required',
    //     'editing.product_sku'   => 'required|min:3|exists:products,sku',
    //         'editing.product_id'   => 'required|min:3|exists:products,sku',
    //         'editing.instance_id'   => 'required|min:3|exists:products,sku',
    //         'editing.price_list_id'   => 'required|min:3|exists:products,sku',
    //         'editing.name'          => 'required|min:3',
    //         'editing.currency'      => 'required|min:2',
    //         'editing.market'        => 'required|min:2',
    //         'editing.term_duration' => 'required|min:2',
    //         'editing.billing_plan'  => 'required|min:2',
    //         'editing.price'         => 'required',
    //         'editing.msrp'          => 'required',
    //         'editing.product_vendor'          => 'required',
    // ];

    protected $customAttributes = [
        'fieldColumnMap.name' => 'name',
        'fieldColumnMap.product_sku' => 'product sku',
    ];

    public function updatingUpload($value)
    {
        Validator::make(
            ['upload' => $value],
            ['upload' => 'required|mimes:txt,csv,xlsx'],
        )->validate();
    }

    public function updatedUpload()
    {
        $this->columns = Csv::from($this->upload)->columns();

        $this->guessWhichColumnsMapToWhichFields();
    }

    public function import()
    {
        $this->validate();
        $importCount = 0;
        Csv::from($this->upload)
        ->eachRow(function ($row) use (&$importCount) {
            $tt = $this->extractFieldsFromRow($row);
            // dd($tt);
            if($tt['product_id'] != null){
                Price::updateOrCreate([
                    'product_sku'   => $tt['product_sku'],
                    'product_id'    => $tt['product_id'],
                    'instance_id'   => $this->priceList->instance_id,
                    'price_list_id' => $this->priceList->id,
                ],[
                    'name'          => $tt['name'],
                    'currency'      => $tt['currency'],
                    'market'        => $tt['market'],
                    'term_duration' => $tt['term_duration'],
                    'price'         => $tt['price'],
                    'billing_plan'  => $tt['billing_plan'],
                    'msrp'          => $tt['msrp'],
                    'product_vendor'=> $tt['product_vendor']
                ]);
                $importCount++;
            }
            });
        $this->reset();
        $this->emit('refreshTransactions');
        $this->notify('Imported '.$importCount.' transactions!');
    }

    public function extractFieldsFromRow($row)
    {
        $product = Product::where('sku', $row['SkuId'])->where('instance_id', $this->priceList->instance_id)->pluck('id')->first();
        $attributes = collect($this->fieldColumnMap)
        ->filter()
        ->mapWithKeys(function($heading, $field) use ($row) {
            return [$field => $row[$heading]];
        })->toArray();

        return $attributes + [
            'product_vendor'    => 'microsoft',
            'instance_id'       => $this->priceList->instance_id,
            'price_list_id'     => $this->priceList->id,
            'market'            => $row['Market'],
            'billing_plan'      => $row['BillingPlan'],
            'currency'          => $row['Currency'],
            'term_duration'     => $row['TermDuration'],
            'product_id'        => $product,

        ];
    }

    public function guessWhichColumnsMapToWhichFields()
    {
        $guesses = [
            'name'          => ['skutitle'],
            'product_sku'   => ['skuid'],
            'price'         => ['unitprice',],
            'msrp'          => ['erp price',],
        ];
        foreach ($this->columns as $column) {

            $match = collect($guesses)->search(fn($options) => in_array(strtolower($column), $options));

            if ($match) $this->fieldColumnMap[$match] = $column;
        }
    }

    public function importproducts(){

        if($this->license == true){
            Log::info('Started importing NCE');
            // $id = Auth::user()->provider->id;
            $product = new Product();
            // $provider = Provider::where('id', $id)->select('country_id')->first();
            // $country = Country::select('iso_3166_2')->where('id', $provider->country_id)->first();
            $instance = Instance::where('provider_id', $id)->first();

            $product->importNCELicenses($instance, $country);
            // Log::debug('Subscription id: '.$product->name .' has renewed');

        }

        if($this->perpetual == true){

            // Log::info('Started importing Perpetual');
            // $id = Auth::user()->provider->id;
            // $product = new Product();
            // $provider = Provider::where('id', $id)->select('country_id')->first();
            // $country = Country::select('iso_3166_2')->where('id', $provider->country_id)->first();
            // $instance = Instance::where('provider_id', $id)->first();

            // $product->importPerpetual($instance, $country);

            // $this->notify('Import Scheduled for perpetual');
        }
        $this->showImportModal = false;
    }

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
                $q->orwhere('product_sku', "like", "%{$this->filters['search']}%");
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
            $this->categories = Product::groupBy('category')->pluck('category');

            return view('livewire.pricelist.show-pricelist',[
                'prices' => $this->rows,
                'categories' => $this->categories,
            ]);
        }
    }

