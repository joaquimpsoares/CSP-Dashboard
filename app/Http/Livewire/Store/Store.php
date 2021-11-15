<?php

namespace App\Http\Livewire\Store;

use App\Cart;
use App\Price;
use App\Product;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use Maatwebsite\Excel\Concerns\ToArray;

class Store extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;
    protected $paginationTheme = 'bootstrap';

    public $showModal = false;

    public $details;
    public $search;
    public $vendor =[];
    public $category;
    public $cartProducts = [];
    public $selectproducttype;

    public $productName;
    public $productCategory;
    public $productSku;
    public $productDescription;
    public $productMSRP;

    public $showmobilefilter = false;
    public $showproductdetails = true;


    public $filters = [
        'search' => '',
        'category' => '',
        'vendors' => '',
        'producttype' => '',
        'plugins' => false,
        'billing' => [],
        'terms' => [],
    ];

    public function updatedQtys($field)
{
   $this->recalc($field);
}

    public function addToCart(Product $productId)
    {
        $this->showModal = false;
        $price= Price::where('product_id', $productId)->get();
        $cart = $this->getUserCart();
        if (! $cart) {
            $cart = new Cart();
            $cart->save();
        }
        $cart->products()->attach($productId, [
            'id' => Str::uuid(),
            'price' => $productId->price->price,
            'retail_price' => $productId->price->msrp,
            'quantity' => $productId->minimum_quantity,
            'billing_cycle' => "annual"
            ]);

        $this->emit('updateCart');
        $this->notify('Product added to cart: '. $productId->name );
    }

    public function showDetails($id)
    {
        $this->showModal = true;
        $details = Product::where('id', $id)->first();

        $this->productName      = $details->name;
        $this->productCategory  = $details->category;
        $this->productSku       = $details->sku;
        $this->productDescription = $details->description;
        $this->productName      = $details->name;
        $this->productMSRP      = $details->price->msrp;
    }

    public function close()
    {
        $this->showModal = false;
    }

    public function showprodcutdetails($id)
    {
        $this->showproductdetails = true;


    }

    public static  function getUserCart($id = null, $token = null)
    {

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

    public function updatedVendor()
    {
      if (!is_array($this->vendor)) return;

      $this->vendor = array_filter($this->vendor, function ($vendors) {
        return $vendors != false;
      });
    }

    public function getRowsQueryProperty()
    {
        // dd($this->filters['billing']);
        $query = Price::query()
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
            ->when($this->filters['billing'], fn($query, $billing) => $query->where('billing_plan', $billing))
            ->when($this->filters['terms'], fn($query, $terms) => $query->where('term_duration', $terms))
            ->when($this->search, fn($query, $search) => $query->where('name', 'like', '%'.$search.'%')
                                                               ->orwhere('product_sku', 'like', '%'.$search.'%'))
                                                               ->with('related_product');

        return $this->applySorting($query);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
            $categories     = Product::pluck('category')->unique()->filter();
            $terms          = Price::pluck('term_duration')->unique()->filter();
            $vendors        = Product::pluck('vendor')->unique()->filter();
            $productType    = Product::pluck('productType')->unique()->filter();

        return view('livewire.store.store', [
            'prices'        => $this->rows,
            'vendors'       => $vendors,
            'categories'    => $categories,
            'terms'         => $terms,
            'producttype'   => $productType,
        ]);
    }
}
