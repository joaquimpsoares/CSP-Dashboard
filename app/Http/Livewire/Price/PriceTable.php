<?php

namespace App\Http\Livewire\Price;

use App\Price;
use Livewire\Component;
use App\Exports\PriceExport;
use Maatwebsite\Excel\Facades\Excel;

class PriceTable extends Component
{
    public $search = '';

    public function exportSelected()
    {
        return Excel::download(new PriceExport, 'Price.xlsx');
    }

    public function render()
    {
        $search = $this->search;

        $query = Price::query();

        $prices = $query
        ->where(function ($q)  {
            $q->where('name', "like", "%{$this->search}%");
            $q->orWhere('id', 'like', "%{$this->search}%");

        })->
        with(['pricelist', 'product','tiers'])->paginate(10);

        $prices->getCollection()->map(function(Price $price){
            $price->setRawAttributes(json_decode(json_encode($price->format()), true)); // Coverts to array recursively (make helper from it?)
            return $price;
        });
        return view('livewire.price.price-table', compact ('prices'));
    }
}
