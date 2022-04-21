<?php

namespace App\Http\Livewire\Store;

use App\Cart;
use App\Customer;
use Livewire\Component;
use App\Http\Traits\UserTrait;
use Illuminate\Support\Facades\Auth;

class CartCounter extends Component
{
    use UserTrait;

    private $cart;


    public $qty;
    public $cycle;
    public $terms;
    public $monthly;
    public $annualy;
    public $company_name;
    public $selected = [];
    public $billing_cycle;
    public $billing = [];
    public $totalCartWithoutTax;
    public $customers;
    public $customer;
    public $city_id = '';

    protected $listeners = ['updateCart' => 'render'];
    // protected $listener = ['updateCartCount' => 'open'];

    public $cartOpen = false;
    public $isOpen = false;

    public function open()
    {
        $this->cartOpen = true;
        $this->isOpen = true;
    }

    protected $rules =
    [
        'company_name'=> ['required', 'string', 'regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/', 'max:255'],
        'billing_cycle'=> ['required', 'string'],
    ];

    // public function updated($propertyName){$this->validateOnly($propertyName);}

    public static  function getUserCart($id = null, $token = null)
    {
        $user = Auth::user();
        if (empty($token)) {
            if (empty($id)) {
                $cart = Cart::where('user_id', $user->id)->whereNull('verify')->with(['products', 'customer'])->first();
            } else {
                $cart = Cart::where('user_id', $user->id)->where('id', $id)->with(['products', 'customer'])->get();
            }
        } else {
            $cart = Cart::where('user_id', $user->id)->where('token', $token)->with(['products', 'customer'])->get();
        }
        return $cart;
    }

    public function removeItem($item_id)
    {
        $cart = $this->getUserCart();
        $product = $cart->products->first(function ($value) use ($item_id) {
            return $value->pivot->id == $item_id;
        });
        if ($cart->products->count() <= 1)
        {
            $cart->delete();
        }
        $cart->products()->wherePivot('id', $item_id)->detach();
    }

    public function increaseQuantity($id, $qty)
    {
        $cart = $this->getUserCart();
        $product = $cart->products->first(function ($value) use ($id) {
            return $value->pivot->id == $id;
        });
        $product->pivot->quantity = $qty + 1;
        $product->pivot->save();
        $this->emit('updateCart');
    }

    public function decreaseQuantity($id, $qty)
    {
        $cart = $this->getUserCart();

        $product = $cart->products->first(function ($value) use ($id) {
            return $value->pivot->id == $id;
        });
        $product->pivot->quantity = $qty - 1;
        $product->pivot->save();

        $this->emit('updateCart');
    }

    public function changeQty($value, $id)
    {
        $cart = $this->getUserCart();
        $product = $cart->products->first(function ($value) use ($id) {
            return $value->pivot->id == $id;
        });
        $product->pivot->quantity = $value;
        $product->pivot->save();
        $this->qty = $value;
    }

    public function setCustomer(Customer $customer)
    {
        $cart = $this->getUserCart();
        $productId = $cart->products->first(function ($customer) {
            return $customer->pivot->id;
        });

        $cart->update(['customer_id' => $customer->id]);

        // $limits = $this->checkLimits($customer,$productId);

        // if($limits == true){
        //     $this->removeItem($cart->id);
        // }

        $this->emit('updateCart');
    }


    public function checkLimits($customer, $product)
    {
        if($product->IsSubscribed()){
            $limit = $customer->subscriptions->where('product_id', $product->sku)->count();
            if($limit !=  null){
              if($limit >=  $product->limit){
                $this->notify('','you have reached the limits for: '. $product->name, 'error');
                return true;
            }
        }
        }
        return false;
    }

    public function mount(){

        $user = Auth::user();
        $cart = $this->getUserCart();
        if($cart){
            $this->qty = $cart->products->first()->pivot->quantity;
        }
        if($user->userLevel->name == 'Reseller'){
            $this->customers =$user->reseller->customers;
        }
    }

    public function changeBilling($value, $id){

        $cart = $this->getUserCart();
        $product = $cart->products->first(function ($value) use ($id) {
            return $value->pivot->id == $id;
        });
        $product->pivot->billing_cycle = $value;
        $product->pivot->save();
        $this->billing = $value;
        $this->emit('updateCart');
    }


    public function render(){
        $user = Auth::user();
        $cart = $this->getUserCart();
        if (isset($cart)){
            $terms = $cart->products->map(function ($item, $key) {
                if($item->IsNCE()){
                   return  $item->terms->groupBy('duration')->all();
                }
            });
            $this->terms = $terms->filter();
            $cart = $cart->products->map(function ($product) use($cart, $terms) {
                return (object)[
                    'token' => $cart->token,
                    'productType' => $product->productType,
                    'term_duration' => $product->pivot->term_duration,
                    'terms' => $this->terms ?? null,
                    'id' => $product->pivot->id,
                    'product_name' => $product->name,
                    'addon' => $product->is_addon,
                    'currency' => $product->price->currency  ?? null,
                    'price' => $product->pivot->price,
                    'qty' => $product->pivot->quantity,
                    'cycle' => $product->supported_billing_cycles,
                    'billing_cycle' => $this->billing_cycle ?? $product->pivot->billing_cycle,
                    'total' => ($product->pivot->quantity * $product->pivot->price) * ($product->pivot->billing_cycle === 'annual' ? 12 : 1 ),
                ];
            });
        }

        if(isset($cart)){
            $this->totalCartWithoutTax = $cart->sum('total');
        }
        if ($cart !=null){
            $cartAmount = $cart->count();
        }else{
            $cartAmount = '0';
        }

        return view('livewire.store.cart-counter', [
            'cartAmount' => $cartAmount,
            'cart' => $cart
        ]);
    }
}
