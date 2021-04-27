<?php

namespace App\Http\Livewire\Store;

use App\Cart;
use Livewire\Component;
use App\Http\Traits\UserTrait;
use App\Models\CartProduct;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\ElseIf_;

class CartCounter extends Component
{
    use UserTrait;

    public $qty;
    private $cart;
    public $cycle;
    public $monthly;
    public $annualy;
    public $billing_cycle;
    public $billing = [];
    public $totalCartWithoutTax;
    public $customers;
    public $customer;
    public $city_id = '';
    protected $listeners = ['updateCart' => 'render'];


    protected $rules = [
        'company_name'          => ['required', 'string', 'regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/', 'max:255'],
    ];

    public static  function getUserCart($id = null, $token = null)
    {
        // $user = $this->getUser();
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

    public function setCustomer($value, $id)
    {

        $cart = $this->getUserCart();

        $cart->customer_id = $value;
        $cart->save();

        $this->emit('updateCart');
    }


    public function mount(){
        $user = Auth::user();

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

    public function render()
    {

        $user = Auth::user();

        $cart = $this->getUserCart();
        if (isset($cart)){


            $cart = $cart->products->map(function ($products) use($cart) {
                return (object)[
                    'token' => $cart->token,
                    'id' => $products->pivot->id,
                    'products' => $products->name,
                    'price' => $products->pivot->price,
                    'qty' => $products->pivot->quantity,
                    'cycle' => $products->supported_billing_cycles,
                    'billing_cycle' => $products->pivot->billing_cycle,
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
