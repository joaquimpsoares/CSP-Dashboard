<?php

namespace App\Http\Livewire\Store;

use App\Cart;
use Livewire\Component;
use App\Http\Traits\UserTrait;
use Illuminate\Support\Facades\Auth;

class CartCounter extends Component
{
    use UserTrait;

    public $qty;
    public $cycle;
    public $totalCartWithoutTax;
    // protected $listeners = ['updateCart' => 'cartOpen'];


    public static  function getUserCart($id = null, $token = null)
    {
        // $user = $this->getUser();
        $user = Auth::user();

        if (empty($token)) {
            if (empty($id)) {
                // $cart = Cart::where('user_id', $user->id)->orWhere('customer_id', session('customer_id'))->with(['products', 'customer'])->first();
                $cart = Cart::where('user_id', $user->id)->whereNull('customer_id')->with(['products', 'customer'])->first();

            } else {
                $cart = Cart::where('user_id', $user->id)->where('id', $id)->with(['products', 'customer'])->get();
            }
        } else {
            $cart = Cart::where('user_id', $user->id)->where('token', $token)->with(['products', 'customer'])->get();
        }

        return $cart;
    }

    //* not working
    public function removeItem($item_pivot_id)
    {
        $cart = $this->getUserCart();

        $product = $cart->products->first(function ($value) use ($item_pivot_id) {
            return $value->pivot->id == $item_pivot_id;
        });

        $cart->first()->products()->wherePivot('id', $item_pivot_id)->detach();
    }

    public function increaseQuantity($id, $qty)
    {

        $cart = $this->getUserCart();
        $product = $cart->first()->products->first();

        $product->pivot->quantity = $qty + 1;
        $product->pivot->save();

        $this->emit('updateCart');

    }

    public function decreaseQuantity($id, $qty)
    {
        $cart = $this->getUserCart();
        $product = $cart->first()->products->first();

        $product->pivot->quantity = $qty - 1;
        $product->pivot->save();

        $this->emit('updateCart');

    }

    public function updateCycle(){
        $cart = $this->getUserCart();
        $product = $cart->first()->products->first();

        $product->pivot->billing_cycle = $this->cycle;
        $product->pivot->save();

        $this->emit('updateCart');
    }


    // public function mount(){
    //     $cart = $this->getUserCart();
    //     $product = $cart->first()->products->first();

    //     $product->pivot->billing_cycle = $this->cycle;
    //     $product->pivot->save();

    //     $this->emit('updateCart');
    // }

    public function render()
    {
        $user = Auth::user();

        // dd($carts = Cart::with('products')->where('user_id', $user->id)->get());
        $carts = $this->getUserCart();
        // ->map(function ($items) {
        //     dd($items->first());
        //     return (object)[
        //         'id' => $items->first()->products->first()->id,
        //         'name' => $items->first()->products->first()->name,
        //         'price' => $items->products->first()->pivot->price,
        //         'billing_cycle' => $items->products->first()->supported_billing_cycles,
        //         'qty' => $items->products->first()->pivot->quantity,
        //         'total' => ($items->products->first()->pivot->quantity * $items->products->first()->pivot->price ?? $this->cycle = "montlhy" ),
        //     ];
        // });
        // $this->totalCartWithoutTax = $carts->sum('total');

        return view('livewire.store.cart-counter', [
            'carts' => $carts,
            'total' => 1,
        ]);

    }
}
