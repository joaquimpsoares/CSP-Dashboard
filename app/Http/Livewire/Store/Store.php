<?php

namespace App\Http\Livewire\Store;

use App\Cart;
use App\Customer;
use App\Http\Traits\UserTrait;
use App\Price;
use App\Product;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class Store extends Component
{
    use UserTrait;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $showModal = false;

    public $details;
    public $search;
    public $vendor;
    public $category;
    public $typeselected;
    public $cartProducts = [];

    public $productName;
    public $productCategory;
    public $productSku;
    public $productDescription;
    public $productMSRP;

    public $showmobilefilter = false;
    public $showproductdetails = false;

    public function updatingSearch(){$this->resetPage();}

    public $filters = [
        'search' => '',
        'category' => '',
        'vendors' => '',
        'producttype' => '',
        'plugins' => false,
        'notplugins' => true,
        'billing' => [],
        'terms' => [],
        'trial' => '',
    ];


    public function updatedQtys($field){$this->recalc($field);}

    public function addToCart(Product $productId)
    {
        $this->showModal = false;
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

    public function addToCartWithCustomer(Product $productId,Customer $customer)
    {
        $this->showModal = false;
        $cart = Cart::where('customer_id',$customer)->first();
        $cart = $this->getUserCart($cart->id);

        //CHECK LIMITIS
        $limits = $this->checkLimits($customer,$productId );

        if($limits == false){
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

            $this->notify('Product added to cart: '. $productId->name );
        }
        $this->emit('updateCart');

    }

    public function checkLimits($customer, $product){
        if($product->IsSubscribed()){
            $limit = $customer->subscriptions->where('product_id', $product->sku)->count();
            if($limit >=  $product->limit){
                $this->notify('you have reached the limits for: '. $product->name, 'error');
                return true;
            }
        }
        return false;
    }

    public function showDetails($id)
    {
        $this->showModal = true;
        $details = Product::where('id', $id)->first();
        $this->productName          = $details->name;
        $this->productCategory      = $details->category;
        $this->productSku           = $details->sku;
        $this->productDescription   = $details->description;
        $this->productName          = $details->name;
        $this->productMSRP          = $details->price->msrp;

    }

    public function close(){$this->showModal = false;}

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

    public function render()
    {
        $user = Auth::user();
        switch ($user->userLevel->name) {
            case 'Reseller':
                $priceList = $user->reseller->price_list_id;
            break;
            case 'Customer':
                $priceList = $user->customer->price_list_id;
                break;
                default:
                return abort(403, __('errors.access_with_resellers_credentials'));
            }
        $prices = Price::with('related_product')->where('price_list_id', $priceList)
        ->whereHas('related_product', function(Builder $query){
            if($this->vendor){
                $query->where('vendor', $this->vendor);
            }
            if($this->category){
                $query->where('category', $this->category);
            }
            if($this->typeselected){
                $query->where('productType', $this->typeselected);
            }

            $query->where(function(Builder $query){
                $query->where('name', "LIKE", "%{$this->search}%");
                $query->orWhere('sku', 'LIKE', "%{$this->search}%");
                $query->orWhere('productType', 'LIKE', "%{$this->search}%");
                $query->orWhere('category', 'LIKE', "%{$this->search}%");
            });})->paginate(12);

            if($prices->total() > 0){
                $productType = $prices->map(function ($item, $key) {
                    return ($item->related_product->pluck('productType')->unique());
                });
                if($productType){
                    $productType = $productType->first()->filter();
                }

                $categories = $prices->map(function ($item, $key) {
                    return ($item->related_product->pluck('category')->unique());
                });
                $categories = $categories->first()->filter();

                $vendors = $prices->map(function ($item, $key) {
                    return ($item->related_product->pluck('vendor')->unique());
                });
                $vendors = $vendors->first()->filter();

            }else{
                $productType = [];
                $categories = [];
                $vendors = [];
            }
            return view('livewire.store.store', [
                'prices' => $prices,
                'producttype' => collect($productType),
                'categories' => $categories,
                'vendors' => $vendors,
            ]);
        }
}
