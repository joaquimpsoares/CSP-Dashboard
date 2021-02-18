<?php

namespace App\Http\Livewire\Store;

use App\Product;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Store extends Component
{
    public String $search = '';
    public String $vendor = '';
    public String $category = '';

    public function render()
    {
        $user = Auth::user();

        switch ($user->userLevel->name) {
            case 'Reseller':
                $priceList = $user->reseller->priceList;
                break;

            case 'Customer':
                $priceList = $user->customer->resellers->first()->priceList;
                break;

            default:
                return abort(403, __('errors.access_with_resellers_credentials'));
        }

        $products = Product::whereHas('prices', function(Builder $query)use($priceList){
            $query->where('price_list_id', $priceList->id);
        })->where(function(Builder $query){
            if(! $this->vendor) return;

            $query->where('vendor', $this->vendor);
        })->where(function(Builder $query){
            if(! $this->category) return;

            $query->where('category', $this->category);
        })->where(function (Builder $query)  {
            $query->where('name', "LIKE", "%{$this->search}%");
            $query->orWhere('sku', 'LIKE', "%{$this->search}%");
        })->get();

        return view('livewire.store.store', [
            'products' => $products,
            'vendors' => Product::pluck('vendor')->unique(),
            'categories' => Product::pluck('category')->unique(),
        ]);
    }
}
