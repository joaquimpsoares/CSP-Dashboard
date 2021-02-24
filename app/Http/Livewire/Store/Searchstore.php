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

    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    use UserTrait;

    public $search = '';
    public $priceList = "null";
    public $category = " ";
    public $vendor= " ";
    public $price= " ";
    // private $instance = " ";

    use WithPagination;


    public function updatingSearch()
    {
        $this->resetPage();
    }

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

                case 'Reseller':
                    $this->instance = $this->user->reseller->provider->instances->pluck('id');
                    $this->priceList = $this->user->reseller->price_list_id;
                break;

                case 'Customer':
                    $this->instance = $this->user->customer->resellers->first()->provider->instances->pluck('id');
                    $this->priceList = $this->user->customer->resellers->first()->price_list_id;
                break;

                default:
                return abort(403, __('errors.unauthorized_action'));
            break;
        }

        $price = Price::select('price_list_id')->groupby('price_list_id')->where('product_vendor',$this->category)
        ->wherein('instance_id',$this->instance)->first();

    }

    public function render()
    {
        $search = $this->search;

        $query = Price::query();

        $prices = $query
            ->join('products', 'prices.product_sku', '=', 'products.sku')
            ->where('products.instance_id', session()->get('instance_id'))
            ->where('price_list_id', $this->priceList)
            ->where('products.category', $this->category)
            ->where('product_vendor', $this->vendor)
            ->where(function ($q)  {
                $q->where('products.name', "like", "%{$this->search}%");
                $q->orWhere('products.sku', 'like', "%{$this->search}%");
            })
        ->paginate(10);

        return view('livewire.store.searchstore', compact('prices'));
    }

}
