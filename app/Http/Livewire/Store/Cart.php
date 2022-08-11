<?php

namespace App\Http\Livewire\Store;

use Livewire\Component;
use App\Cart as StoreCart;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;


class Cart extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $qty = 1;
    public $cart = [];
    public $billing = " ";
    public $subtotal = [];
    public $idd = [];


    public function mount() {
        $this->cart = collect($this->getUserCart());
        // $this->update();
    }


    public function remove()
    {

    }


    public function add($iff)
    {
        $this->qty++;
    }

    public function checkdomainavailability()
    {

    }


    private function getUserCart($id = null, $token = null)
    {
        $user = Auth::user();
        ;

        if (empty($token)) {
            if (empty($id)) {
                $cart = StoreCart::where('user_id', $user->id)->whereNull('customer_id')->with(['products', 'customer'])->first();
            } else {
                $cart = StoreCart::where('user_id', $user->id)->where('id', $id)->with(['products', 'customer'])->first();
            }
        } else {
            $cart = StoreCart::where('user_id', $user->id)->where('token', $token)->with(['products', 'customer'])->first();
        }
        return $cart;
    }


    public function render()
    {
        return view('livewire.store.cart');
    }
}
