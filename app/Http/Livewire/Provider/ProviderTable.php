<?php

namespace App\Http\Livewire\Provider;

use App\Provider;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\ProvidersExport;
use Maatwebsite\Excel\Facades\Excel;

class ProviderTable extends Component
{
    use WithPagination;
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function exportSelected()
    {
        return Excel::download(new ProvidersExport, 'Providers.xlsx');
    }

    public function render()
    {

        $search = $this->search;

        $query = Provider::query();

        $providers = $query
            ->where(function ($q)  {
                $q->where('company_name', "like", "%{$this->search}%");
                $q->orWhere('id', 'like', "%{$this->search}%");
            })->
            with(['country', 'resellers', 'status'])->paginate(10);

        $providers->getCollection()->map(function(Provider $provider){
            $provider->setRawAttributes(json_decode(json_encode($provider->format()), true)); // Coverts to array recursively (make helper from it?)
            return $provider;
        });

        return view('livewire.provider.provider-table',compact('providers'));
    }
}
