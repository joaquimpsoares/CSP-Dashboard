<?php

namespace App\Http\Livewire\Store;

use App\Cart as StoreCart;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;


class Cart extends Component
{

    public $qty = 1;
    public $cart = [];
    public $billing = " ";
    public $subtotal = [];
    public $idd = [];


    public function mount() {

        $this->cart = $this->getUserCart();
        // $this->update();
    }

    // public function update(){
        //     $this->qty = array_sum($this->amount);


        // }

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

        // protected $listeners = ['qtyupadated' => 'update'];

        // public function postAdded()
        // {
            //     $this->subtotal = $this->amount ;
            // }


            private function getUserCart($id = null, $token = null)
            {
                $user = Auth::user();

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
