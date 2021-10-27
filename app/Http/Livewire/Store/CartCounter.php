<?php

namespace App\Http\Livewire\Store;

use App\Cart;
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
    public $selected = [];
    public $billing_cycle;
    public $billing = [];
    public $totalCartWithoutTax;
    public $customers;
    public $customer;
    public $city_id = '';

    protected $listeners = ['updateCart' => 'render'];
    protected $listener = ['updateCartCount' => 'open'];

    public $cartOpen = false;
    public $isOpen = false;

    public function open()
    {
        $this->cartOpen = true;
        $this->isOpen = true;
    }

    protected $rules = [
        'company_name'          => ['required', 'string', 'regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/', 'max:255'],
    ];

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

    public function setCustomer($value, $id)
    {
        $cart = $this->getUserCart();
        $cart->customer_id = $value;
        $cart->save();
        $this->emit('updateCart');
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

    public function changeBilling($value, $id)
    {
        $cart = $this->getUserCart();
        $product = $cart->products->first(function ($value) use ($id) {
            return $value->pivot->id == $id;
        });
        $product->pivot->billing_cycle = $value;
        $product->pivot->save();
        $this->billing = $value;
        $this->emit('updateCart');
    }

    public function SelectedTerms($value, $id)
    {
        if (!is_null($value)) {
            $this->billing_cycle = json_decode($value, true);
        }
        $cart = $this->getUserCart();
        $product = $cart->products->first(function ($value) use ($id) {
            return $value->pivot->id == $id;
        });
        $product->pivot->term_duration = strtolower($this->billing_cycle[0]['duration']);
        $product->pivot->save();
        $this->SelectedTerms = strtolower($this->billing_cycle[0]['duration']);
    }

    public function selectBilling($value, $id)
    {
        $cart = $this->getUserCart();
        $product = $cart->products->first(function ($value) use ($id) {
            return $value->pivot->id == $id;
        });
        $product->pivot->billing_cycle = strtolower($value);
        $product->pivot->save();
        $this->billing = strtolower($value);
    }

    public function render()
    {
        $user = Auth::user();
        $cart = $this->getUserCart();
        if (isset($cart)){
            $terms = $cart->products->map(function ($item, $key) {
                if($item->IsNCE()){
                   return  $item->terms->groupBy('duration')->all();
                }
            });
            $this->terms = $terms->filter();
            $cart = $cart->products->map(function ($products) use($cart, $terms) {
                return (object)[
                    'token' => $cart->token,
                    'productType' => $products->productType,
                    'term_duration' => $products->pivot->term_duration,
                    'terms' => $this->terms ?? null,
                    'id' => $products->pivot->id,
                    'product_name' => $products->name,
                    'products' => $products->name,
                    'currency' => $products->price->currency,
                    'price' => $products->pivot->price,
                    'qty' => $products->pivot->quantity,
                    'cycle' => $products->supported_billing_cycles,
                    'billing_cycle' => $this->billing_cycle,
                    'total' => ($products->pivot->quantity * $products->pivot->price) * ($products->pivot->billing_cycle === 'annual' ? 12 : 1 ),
                ];
            });
        }

        if(isset($cart)){
            $this->totalCartWithoutTax = $cart->sum('total');
        }
        return view('livewire.store.cart-counter', compact('cart'));
    }
}
