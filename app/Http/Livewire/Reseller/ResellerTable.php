<?php

namespace App\Http\Livewire\Reseller;

use Livewire\Component;
use App\Exports\ResellersExport;
use App\Reseller;
use Maatwebsite\Excel\Facades\Excel;

class ResellerTable extends Component
{
    public $search = '';

    public function exportSelected()
    {
        return Excel::download(new ResellersExport, 'resellers.xlsx');
    }

    public function render()
    {
        $search = $this->search;
        $query = Reseller::query();
        $resellers = $query
            ->where(function ($q)  {
                $q->where('company_name', "like", "%{$this->search}%");
                $q->orWhere('id', 'like', "%{$this->search}%");
            })->
            with(['country', 'customers', 'status'])->paginate(10);

        $resellers->getCollection()->map(function(Reseller $reseller){
            $reseller->setRawAttributes(json_decode(json_encode($reseller->format()), true)); // Coverts to array recursively (make helper from it?)
            return $reseller;
        });
        return view('livewire.reseller.reseller-table', compact('resellers'));
    }
}
