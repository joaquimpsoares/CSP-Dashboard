<?php

namespace App\Http\Livewire\Store;

use App\Product;
use Livewire\Component;
use App\Http\Traits\UserTrait;
use App\Price;

class Store extends Component
{
    use UserTrait;

    public function mount(){

        $this->user = $this->getUser();

        $this->level = $this->getUserLevel();

        switch ($this->level) {

            case 'Provider':
                return abort(403, __('errors.access_with_resellers_credentials'));
                $this->instance = $this->user->provider->instances->pluck('id');
                $this->priceList = Price::get('product_vendor')->groupby('product_vendor');
            break;

            case 'Reseller':
                $this->instance = $this->user->reseller->provider->instances->pluck('id');
                $this->priceList = Price::get('product_vendor')->groupby('product_vendor');
            break;
            case 'Customer':
                $this->instance = $this->user->customer->resellers->first()->provider->instances->pluck('id');
                $this->priceList = Price::get('product_vendor')->groupby('product_vendor');
                // dd($this->priceList);
            break;
            default:
            # code...
        break;
    }
    // $this->priceList = $this->user->reseller->priceLists->first()->id;
    // dd($this->priceList);
}

public function render()
{
    return view('livewire.store.store', [

        'products' => Product::select('vendor')
        ->wherein('instance_id', $this->instance)
        ->groupby('vendor')->get(),
        ]);
    }
}
