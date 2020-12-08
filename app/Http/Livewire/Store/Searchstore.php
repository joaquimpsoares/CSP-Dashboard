<?php

namespace App\Http\Livewire\Store;

use App\Price;
use App\PriceList;
use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Traits\UserTrait;
use Illuminate\Support\Facades\DB;

class Searchstore extends Component
{
    use UserTrait;

    public $search = '';
    public $priceList = "null";
    public $category = " ";
    public $vendor= " ";
    // public $price= " ";
    
    use WithPagination;
    
    public function mount($category, $vendor)
        {
            $this->category = $category;
            $this->vendor = $vendor;
            $this->user = $this->getUser();
            
            $this->level = $this->getUserLevel();
            
            // switch ($this->category) {
            //     case 'kaspersky':
            //         $this->prices = Price::where('product_vendor',$this->category)->first();
            //         // $this->priceList = PriceList::wherein('instance_id',$this->instance)
            //         // ->join('products', 'prices.product_sku', '=', 'products.sku')
            //         // ->pluck('id')
            //         // ->toArray();
            //         break;

            //         case 'microsoft':
                        
            //             // $this->priceList = PriceList::wherein('instance_id',$this->instance)
            //             // ->join('products', 'prices.product_sku', '=', 'products.sku')
            //             // ->pluck('id')
            //             // ->toArray();
            //             break;
                
            //     default:
            //         # code...
            //         break;
            // }
            
            switch ($this->level) {

                case 'Customer':
                    $this->instance = $this->user->customer->resellers->first()->provider->instances->pluck('id');
                    $this->priceList = PriceList::wherein('instance_id',$this->instance )->pluck('id')->toArray();
                break;
                
                case 'Reseller':
                    $this->instance = $this->user->reseller->provider->instances->pluck('id');
                    $this->priceList = PriceList::wherein('instance_id',$this->instance )->pluck('id')->toArray();
                break;
                
                default:
                return abort(403, __('errors.unauthorized_action'));
            break;
        }

        $this->price = Price::select('price_list_id')->groupby('price_list_id')->where('product_vendor',$this->category)
        ->wherein('instance_id',$this->instance)->first();

    }

    public function render()
    {
        return view('livewire.store.searchstore', 
        [
            'prices' => DB::table('prices')
            ->join('products', 'prices.product_sku', '=', 'products.sku')
            ->where('products.category', $this->vendor)
            ->where('prices.product_vendor', $this->category)
            // ->having('price_list_id', $this->price->price_list_id)
            ->where('prices.name', 'like', '%' . $this->search . '%')
            ->orwhere('product_sku', 'LIKE', "%$this->search%")->where('category', $this->category)
            ->paginate(9),
            
            ]);
    }
}
