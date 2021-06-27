<?php

namespace App\Http\Livewire\Customer;

use App\Customer;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\CustomersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Builder;

class CustomerTable extends Component
{
    use WithPagination;
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function exportSelected()
    {
        return Excel::download(new CustomersExport, 'users.xlsx');
    }

    public function render()
    {
        $search = $this->search;

        $query = Customer::query();

        $customers = $query
        ->where(function ($q)  {
            $q->where('company_name', "like", "%{$this->search}%");
            $q->orWhere('id', 'like', "%{$this->search}%");
            $q->orwhereHas('resellers', function(Builder $q){
                $q->where('company_name', 'like', "%{$this->search}%");
            });
            $q->orwhereHas('country', function(Builder $q){
                $q->where('name', 'like', "%{$this->search}%");
            });
        })->
        with(['country', 'subscriptions', 'status'])->paginate(10);

        $customers->getCollection()->map(function(Customer $customer){
            $customer->setRawAttributes(json_decode(json_encode($customer->format()), true)); // Coverts to array recursively (make helper from it?)
            return $customer;
        });

        return view('livewire.customer.customer-table',compact('customers'));
    }
}
