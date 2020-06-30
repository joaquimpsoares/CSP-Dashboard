<?php

namespace App\Http\Livewire;

use App\Price;
use App\Vendor;
use App\Product;
use Livewire\Component;
use App\Http\Traits\UserTrait;
use App\CartProduct as AppCartProduct;

class CartProduct extends Component
{
    use UserTrait;
    

    public $products =[];
    public $prices ="";

    public function mount()
    {
        $user = $this->getUser();
        $userLevel = $this->getUserLevel();

        switch ($userLevel) {
            case 'Provider':
                # code...
                break;
            
            case 'Reseller':
                $priceList = $user->reseller->priceList->id;
                $prices = Price::where('price_list_id', $priceList)->paginate($this->quantity);

                foreach ($prices as $price) {
                    $products[] = $price->product;
                }

                break;
            
            default:
                # code...
                break;
        }
        
        $vendors = Vendor::orderBy('name')->get();

        $quantity = $this->quantity;
        
    }
    
    public function render()
    {
        return view('livewire.cart-product');
        }
    }
