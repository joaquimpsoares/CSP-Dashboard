<?php

namespace App\Http\Livewire;

use App\Price;
use App\Vendor;
use App\Product;
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
    public $vendorv= " ";
    
    use WithPagination;
    
    public function mount($category, $vendor)
        {
            $this->category = $category;
            // dd($this->category);
            $this->vendor = $vendor;
            $this->user = $this->getUser();
            
            $this->level = $this->getUserLevel();
            
            // switch ($this->category) {
            //     case 'kaspersky':
            //         $this->prices = Price::where('product_vendor',$this->category)->first();
            //         // dd($this->prices->price_list_id);
            //         // $this->priceList = PriceList::wherein('instance_id',$this->instance)
            //         // ->join('products', 'prices.product_sku', '=', 'products.sku')
            //         // ->pluck('id')
            //         // ->toArray();
            //         break;

            //         case 'microsoft':
                        
            //             // dd($this->prices->price_list_id);
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
                    $this->priceList = $this->user->customer->priceLists->first()->id;
                break;
                
                case 'Reseller':


                    $this->instance = $this->user->reseller->provider->instances->pluck('id');
                    // dd($this->instance);
                    
                    $this->priceList = PriceList::wherein('instance_id',$this->instance )->pluck('id')->toArray();
                    // dd($this->priceList);
                break;
                
                default:
                return abort(403, __('errors.unauthorized_action'));
            break;
        }

        $this->price = Price::select('price_list_id')->groupby('price_list_id')->where('product_vendor',$this->category)
        ->wherein('instance_id',$this->instance)->first();

        // dd($this->prices->price_list_id);
    }

    public function render()
    {
        return view('livewire.searchstore', 
        [
            
            'prices' => DB::table('prices')
            ->join('products', 'prices.product_sku', '=', 'products.sku')
            ->where('products.category', $this->vendor)
            ->where('prices.product_vendor', $this->category)
            ->having('price_list_id', $this->price->price_list_id)->where('prices.name', 'like', '%' . $this->search . '%')
            ->orwhere('product_sku', 'LIKE', "%$this->search%")->where('category', $this->category)
            ->paginate(9),
            
            ]);
    }
}
