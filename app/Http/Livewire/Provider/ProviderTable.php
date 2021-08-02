<?php

namespace App\Http\Livewire\Provider;

use App\Provider;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\ProvidersExport;
use GuzzleHttp\Handler\Proxy;
use Maatwebsite\Excel\Facades\Excel;

class ProviderTable extends Component
{
    use WithPagination;
    public $search = '';
    public $sortField='company_name';
    public $sortDirection = 'asc';
    public Provider $editing;

    protected $queryString = ['sortField', 'sortDirection'];

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field
            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
            : 'asc';

        $this->sortField = $field;
    }

    public function rules()
    {
        return [
            'editing.company_name' => 'required|min:3',
            'editing.address_1' => 'required',
            // 'editing.address_2' => 'required|in:'.collect(Transaction::STATUSES)->keys()->implode(','),
            'editing.address_2' => 'required',
        ];
    }

    public function edit(Provider $editing)
    {
        $this->editing = $editing;

        $this->showEditModal = true;
    }

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
            with(['country', 'resellers', 'status'])->orderBy($this->sortField, $this->sortDirection)->paginate(10);

        $providers->getCollection()->map(function(Provider $provider){
            $provider->setRawAttributes(json_decode(json_encode($provider->format()), true)); // Coverts to array recursively (make helper from it?)
            return $provider;
        });

        return view('livewire.provider.provider-table',compact('providers'));
    }
}
