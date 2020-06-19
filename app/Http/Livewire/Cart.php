<?php

namespace App\Http\Livewire;

use App\Cart as Cartdb;
use Livewire\Component;
use App\Http\Traits\UserTrait;
use App\Repositories\ProductRepositoryInterface;


class Cart extends Component
{
    
    private $productRepository;
    
    use UserTrait;
    public $cart = [];
    public $quantity = 0;
    public $counter = 0;
    public $products = [];
    public $billing_cycle;
    
    
    // public function __construct(ProductRepositoryInterface $productRepository)
    // {
        
        // }
        
        
        private function getUserCart()
        {
            $user = $this->getUser();
            $cart = Cartdb::where('user_id', $user->id)->whereNull('customer_id')->with('products')->first();
            
            return $cart;
        }
        
        
        public function increment($item_id, $quantity) {
            
            $cart = $this->getUserCart();
            
            $product = $cart->products->first(function ($value) use ($item_id) {    
                return $value->pivot->id == $item_id;
            });
            
            if ($this->productRepository->verifyQuantities( $quantity)) {
                $product->pivot->quantity = $quantity;
                $product->pivot->save();
                return true;
            }        
            
            return false;
            
        }
        
        
        private function decrement()
        {
            
        }
        
        public function mount(ProductRepositoryInterface $productRepository)
        {
            $this->cart = $this->getUserCart();
            
            $this->productRepository = $productRepository;
            $this->billing_cycle = $this->cart->billing_cycle;
            $this->quantity = $this->cart->products()->wherePivot('id', '152a3c9e-3b57-4d57-8a71-5ccce3aee27a')->first();


            
            // foreach ($this->products as $product) {
            //     $this->quantity = $this->cart->products->pivot->quantity->toArray();
            //     }
                
                // $this->quantity = $this->products->toArray();
                // $this->quantity = $this->products->toArray();
                
                // $carts=$this->cart;
                // $this->products = $carts->products;
                
                // $this->quantity = $this->products->pivot->quantity;
                
                // $this->productspivot = $carts->products;
                
                
                
                
                
            }
            public function render()
            {
                return view('livewire.cart');
            }
        }
