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

class Store extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $showModal = false;
    public $search;
    public $vendor;
    public $category;
    public $cartProducts = [];

    public function addToCart(Product $productId)
    {

        $price= Price::where('product_id', $productId)->get();
        $cart = $this->getUserCart();


        if (! $cart) {
            $cart = new Cart();
            $cart->save();
        }


        $cart->products()->attach($productId, [
            'price' => $productId->prices->price,
            'retail_price' => $productId->prices->msrp,
            'id' => Str::uuid(),
            'quantity' => $productId->minimum_quantity
            ]);
            // dd($productId);

            $this->showModal = true;
            session()->flash('success','Added: "' . $productId->name . '" to your your shopping cart');
        $this->emit('updateCart');
    }

    public function close()
        {
            $this->showModal = false;
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

    public function render()
    {
        $user = Auth::user();

        switch ($user->userLevel->name) {
            case 'Reseller':
                $priceList = $user->reseller->priceList;
                break;

            case 'Customer':
                $priceList = $user->customer->resellers->first()->priceList;
                break;

            default:
                return abort(403, __('errors.access_with_resellers_credentials'));
        }

        $products = Product::whereHas('prices', function(Builder $query)use($priceList){
            $query->where('price_list_id', $priceList->id);
        })->where(function(Builder $query){
            if(! $this->vendor) return;

            $query->where('vendor', $this->vendor);
        })->where(function(Builder $query){
            if(! $this->category) return;

            $query->where('category', $this->category);
        })->where(function (Builder $query)  {
            $query->where('name', "LIKE", "%{$this->search}%");
            $query->orWhere('sku', 'LIKE', "%{$this->search}%");
        })->paginate(10);

         return view('livewire.store.store', [
            'products' => $products,
            'vendors' => Product::pluck('vendor')->unique(),
            'categories' => Product::pluck('category')->unique(),
        ]);
    }
}
