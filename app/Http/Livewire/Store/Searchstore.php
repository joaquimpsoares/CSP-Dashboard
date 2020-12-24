<?php

namespace App\Http\Livewire\Store;

use App\Price;
use App\PriceList;
use App\Subscription;
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
    public $price= " ";
    // private $instance = " ";

    use WithPagination;

    public function mount($vendor,$category )
        {
            $this->vendor = $category;
            $this->category = $vendor;
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
                    $this->priceList = $this->user->customer->resellers->first()->price_list_id;
                break;

                case 'Reseller':
                    $this->instance = $this->user->reseller->provider->instances->pluck('id');
                    $this->priceList = $this->user->reseller->price_list_id;
                break;

                default:
                return abort(403, __('errors.unauthorized_action'));
            break;
        }

        $price = Price::select('price_list_id')->groupby('price_list_id')->where('product_vendor',$this->category)
        ->wherein('instance_id',$this->instance)->first();

        // $prices = Price::with('product')
        // ->join('products', 'prices.product_sku', '=', 'products.sku')
        // ->where('prices.name', 'like', "%azure%")
        // // ->orwhere('prices.product_sku', 'LIKE', '%' . $this->search . '%')
        // ->where('products.instance_id', $this->instance)
        // ->where('price_list_id', $this->priceList)
        // ->where('products.category', $this->category)
        // ->where('product_vendor', $this->vendor)
        // // ->toSql();
        // ->paginate(9);


    }

    public function render()
    {

        $result = DB::table('subscriptions')
            ->select(DB::raw('count(*) as count, product_id'))
            ->groupBy('product_id')
            ->get();


        return view('livewire.store.searchstore',[
            'prices' => DB::table('prices')
            ->join('products', 'prices.product_sku', '=', 'products.sku')
            ->where('products.instance_id', session()->get('instance_id'))
            ->where('price_list_id', $this->priceList)
            ->where('products.category', $this->category)
            ->where('product_vendor', $this->vendor)
            ->where('products.name', 'like', '%'.$this->search.'%')
            // ->orderBy($result->max('product_id'), 'desc')
        ->paginate(10),
        ]);
    }
}
