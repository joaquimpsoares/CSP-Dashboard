<?php

namespace App\Http\Livewire\Store;

use App\Cart;
use App\Customer;
use App\Http\Traits\UserTrait;
use App\Price;
use App\Product;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithPerPagePagination;

class Store extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;
    protected $paginationTheme = 'bootstrap';

    public $showModal = false;
    public $keyword;
    public $searchproduct = null;

    public $details;
    public $search;
    public $vendor =[];
    public $price;
    public $cartProducts = [];
    public $selectproducttype;
    public $priceList;

    public $vendors;
    public $categories;
    public $terms;
    public $productType;

    public $productName;
    public $productCategory;
    public $productSku;
    public $productDescription;
    public $productMSRP;

    public $showmobilefilter = false;
    public $showproductdetails = false;

    public $filters = [
        'search' => '',
        'category' => '',
        'vendors' => '',
        'producttype' => '',
        'plugins' => false,
        'billing' => [],
        'terms' => [],
        'trial' => '',
    ];

    public function updatingSearch(){$this->resetPage();}
    public function updatingcategories(){$this->resetPage();}
    public function updatingselectproducttype(){$this->resetPage();}
    public function updatedQtys($field){$this->recalc($field);}
    public function close(){$this->showModal = false;}

//     public function updatedKeyword(){
//         if(!$this->keyword){
//             return $this->searchproduct = null;
//         }

//         $this->searchproduct =  Price::query()->where('instance_id', $this->priceList)
//         ->where(function ($q) {
//             $q->orwhere('product_sku', 'like', '%'.$this->keyword.'%');
//             $q->orwhere('name', 'like', '%'.$this->keyword.'%');
//         })->orderBy('name')->get()->filter();

//         $this->searchproduct->groupBy('productType');


//    }

    // public function selectedProduct(Price $price){
    //     $this->searchproduct = null;
    //     $this->keyword = $price->name;
    //     $this->prices = $price;
    // }

    public function addToCart(Product $product, Price $price){

        $billing_cycle = 'monthly';
        $this->showModal = false;

        $cart = $this->getUserCart();

        if (!$cart) {
            $cart = new Cart();
            $cart->save();
        }

        if($product->IsNCE()){
            $billing_cycle = $price->billing_plan;
            $term_duration = $price->term_duration;
        }

        if($product->IsPerpetual()){
            $billing_cycle = $product->supported_billing_cycles[0];
        }

        $cart->products()->attach($product, [
            'id' => Str::uuid(),
            'price' => $product->price->price,
            'retail_price' => $product->price->msrp,
            'quantity' => $product->minimum_quantity,
            'billing_cycle' => $billing_cycle,
            'term_duration' => $term_duration ?? null
            ]);

        $this->emit('updateCart');
        $this->notify('Product added to cart: '. $product->name );
    }

    public function showDetails(Product $product){
        $this->showproductdetails   = true;
        $this->price                = Price::where('product_id', $product->id)->first();
        $this->retail               = $product->price->price;
        $this->msrp                 = $product->price->msrp;
        $this->productName          = $product->name;
        $this->productCategory      = $product->category;
        $this->productSku           = $product->sku;
        $this->productDescription   = $product->description;
        $this->productMSRP          = $product->price->msrp;
    }

    public static  function getUserCart($id = null, $token = null){
        $user = Auth::user();
        if (empty($token)) {
            if (empty($id)) {
                $cart = Cart::where('user_id', $user->id)->whereNull('customer_id')->with(['products', 'customer'])->first();
            } else {
                $cart = Cart::where('user_id', $user->id)->where('id', $id)->with(['products', 'customer'])->first();
            }
        } else {
            $cart = Cart::where('user_id', $user->id)->where('token', $token)->with(['products', 'customer'])->first();
        }
        return $cart;
    }

    public function updatedVendor(){
        $this->useCachedRows();
      if (!is_array($this->vendor)) return;

      $this->vendor = array_filter($this->vendor, function ($vendors) {
        return $vendors != false;
      });
    }

    public function getRowsQueryProperty(){
        $this->useCachedRows();
        $user = Auth::user();
        switch ($user->userLevel->name) {
            case 'Reseller':
                $this->priceList = $user->reseller->price_list_id;
            break;
            case 'Customer':
                $this->priceList = $user->customer->price_list_id;
                break;
                default:
            return abort(403, __('errors.access_with_resellers_credentials'));
        }

        $query = Price::query()->with('related_product')->where('price_list_id', $this->priceList)
        ->whereRelation('related_product', 'is_available_for_purchase', 1)
        ->when($this->filters['category'], fn($query, $category) => $query->whereHas('related_product', function(Builder $q) use($category){
                $q->where('category',$category);
            }))
            ->when($this->filters['vendors'], fn($query, $vendors) => $query->whereHas('related_product', function(Builder $q) use($vendors){
                $q->where('vendors', $vendors);
            }))
            ->when($this->filters['producttype'], fn($query, $producttype) => $query->whereHas('related_product', function(Builder $q) use($producttype){
                $q->where('productType', $producttype);
            }))
            ->when($this->filters['plugins'], fn($query, $plugins) => $query->whereHas('related_product', function(Builder $q) use($plugins){
                $q->where('is_addon', $plugins);
            }))
            ->when($this->filters['trial'], fn($query, $trial) => $query->whereHas('related_product', function(Builder $q) use($trial){
                $q->where('is_trial', $trial);
            }))
            ->when($this->filters['billing'], fn($query, $billing) => $query->where('billing_plan', $billing))
            ->when($this->filters['terms'], fn($query, $terms) => $query->where('term_duration', $terms))
            ->when($this->search, fn($query, $search) => $query->where('name', 'like', '%'.$search.'%')
            ->orwhere('product_sku', 'like', '%'.$search.'%'))
            ->with('related_product');

        return $this->applySorting($query);
    }

    public function mount(){
        $this->useCachedRows();

        $user = Auth::user();
        switch ($user->userLevel->name) {
            case 'Reseller':
                $this->priceList = $user->reseller->price_list_id;
            break;
            case 'Customer':
                $this->priceList = $user->customer->price_list_id;
                break;
                default:
            return abort(403, __('errors.access_with_resellers_credentials'));
        }

        switch ($user->userLevel->name) {
            case 'Reseller':
                $this->priceList = $user->reseller->price_list_id;
                break;
                case 'Customer':
                    $this->priceList = $user->customer->price_list_id;
                break;
                default:
                return abort(403, __('errors.access_with_resellers_credentials'));
            }

        $priceList = $this->priceList;

        $this->terms = Price::pluck('term_duration')->unique()->filter();

        $this->categories = product::select(['category'])->whereHas('price', function($query) use  ($priceList) {
            $query->where('price_list_id', $priceList);
        })->pluck('category')->unique()->filter();

        $this->vendors = product::select(['vendor'])->whereHas('price', function($query) use  ($priceList) {
            $query->where('price_list_id', $priceList);
        })->pluck('vendor')->unique()->filter();

        $this->productType = product::select(['productType'])->whereHas('price', function($query) use  ($priceList) {
            $query->where('price_list_id', $priceList);
        })->pluck('productType')->unique()->filter();
    }

    public function getRowsProperty(){
        $this->useCachedRows();
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        $this->useCachedRows();

        $user = Auth::user();

        return view('livewire.store.store', [
            'prices'        => $this->rows,
            'vendors'       => $this->vendors,
            'category'      => $this->categories,
            'terms'         => $this->terms,
            'producttype'   => $this->productType,
        ]);
    }
}
