<?php

namespace App\Http\Livewire\Price;

use App\PriceList;
use Livewire\Component;
use App\Exports\PriceListExport;
use Maatwebsite\Excel\Facades\Excel;


class PricelistTable extends Component
{
    public $search = '';

    public function exportSelected()
    {
        return Excel::download(new PriceListExport, 'PriceList.xlsx');
    }

    public function render()
    {
        $search = $this->search;

        $query = PriceList::query();

        $pricelists = $query
        ->where(function ($q)  {
            $q->where('name', "like", "%{$this->search}%");
            $q->orWhere('id', 'like', "%{$this->search}%");
            $q->orWhere('description', 'like', "%{$this->search}%");
        })->
        with(['prices', 'provider', 'reseller','Customer'])->paginate(10);

        $pricelists->getCollection()->map(function(PriceList $pricelist){
            $pricelist->setRawAttributes(json_decode(json_encode($pricelist->format()), true)); // Coverts to array recursively (make helper from it?)
            return $pricelist;
        });
        return view('livewire.price.pricelist-table', compact('pricelists'));
    }
}
