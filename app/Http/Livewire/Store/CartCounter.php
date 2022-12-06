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
    public $product;
    public $customer;
    public $city_id = '';

    protected $listeners = ['updateCart' => 'render'];

    public $cartOpen = false;
    public $isOpen = false;

    public function open()
    {
        $this->cartOpen = true;
        $this->isOpen = true;
    }


    public function rules(){
        if($this->product != null){
            if($this->product->maximum_quantity){
                return [
                    'company_name'              => ['required', 'string', 'regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/', 'max:255'],
                    'qty'                       => ['required', 'numeric','max:'.$this->product->maximum_quantity, 'min:'.$this->product->minimum_quantity],
                ];
            }
            }else{

            return [
                'company_name'              => ['required', 'string', 'regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/', 'max:255'],
                'qty'                       => ['required', 'numeric','max:99999999', 'min:1'],
            ];
        }
    }

    // protected $rules =
    // [
    //     'company_name'=> 'required|exists:customers,id',
    //     // 'billing_cycle'=> 'sometimes|string',
    //     'qty' => 'required|integer|max:'.$this->max_quantity.'|'.'min':.$this->min_quantity,
    // ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public static  function getUserCart($id = null, $token = null){
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

    public function removeItem($item_id){
        $cart = $this->getUserCart();
        $this->product = $cart->products->first(function ($value) use ($item_id) {
            return $value->pivot->id == $item_id;
        });
        if ($cart->products->count() <= 1)
        {
            $cart->delete();
        }
        $cart->products()->wherePivot('id', $item_id)->detach();
        $this->emit('updateCart');

    }

    public function increaseQuantity($id, $qty){
        $cart = $this->getUserCart();
        $this->product = $cart->products->first(function ($value) use ($id) {
            return $value->pivot->id == $id;
        });
        $this->product->pivot->quantity = $qty + 1;
        $this->product->pivot->save();
        $this->emit('updateCart');
    }

    public function decreaseQuantity($id, $qty){
        $cart = $this->getUserCart();

        $this->product = $cart->products->first(function ($value) use ($id) {
            return $value->pivot->id == $id;
        });
        $this->product->pivot->quantity = $qty - 1;
        $this->product->pivot->save();

        $this->emit('updateCart');
    }

    public function changeQty($value, $id){
        $cart = $this->getUserCart();
        $this->product = $cart->products->first(function ($value) use ($id) {
            return $value->pivot->id == $id;
        });


        if($value > $this->product->maximum_quantity){
            $this->qty = $this->product->maximum_quantity;
        }else{
            $this->qty = $value;
        }

        $this->product->pivot->quantity = $value;
        $this->product->pivot->save();

    }

    public function setCustomer(Customer $customer){
        $this->customer =$customer;
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

    public function checkLimits($customer, $product){
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
            if($cart->products->isEmpty()){
                $cart->delete();
            }
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

    public function cartHasTenant($cart) {
        $hasTenant = false;

        foreach ($cart['products'] as $product) {
            if ($product->vendor === "microsoft") {
                $hasTenant = true;
                break;
            }
            if(strtolower($product->vendor) === "microsoft corporation"){
                $hasTenant = true;
                break;
            }
        }

        return $hasTenant;
    }

    public function checkout(){
        $this->validate();
        $customerTenant = null;


        if($this->customer->microsoftTenantInfo->first() != null){
            $customerTenant = explode('.onmicrosoft.com',  $this->customer->microsoftTenantInfo->first()->tenant_domain);
            $customerTenant = $customerTenant[0];
        }

        $cart = $this->getUserCart();

        if ($this->cartHasTenant($cart)){
            $this->emit('updateCart');
            return redirect()->route('cart.tenant', ['cart' => $cart->token, 'customerTenant' => $customerTenant]);
        }
        else{
            $this->emit('updateCart');
            return redirect()->route('cart.review', ['cart' => $cart->token]);
        }
    }


    public function render(){
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
                    'minimum_quantity' => $product->minimum_quantity,
                    'maximum_quantity' => $product->maximum_quantity,
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
            'cart' => $cart,
        ]);
    }
}
