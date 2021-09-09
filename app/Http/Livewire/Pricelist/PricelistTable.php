<?php

namespace App\Http\Livewire\Pricelist;

use App\PriceList;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Traits\UserTrait;
use Illuminate\Support\Facades\Auth;
use App\Price;

class PricelistTable extends Component
{
    use WithPagination;
    use UserTrait;
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;

    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['sorts'];

    // public $priceLists;
    public $products;
    public $showDeleteModal = false;
    public $showEditModal = false;
    public $showFilters = false;
    public PriceList $editing;
    public $filters = [
        'search' => '',
        'name' => null,
        'description' => null,
    ];

    public function rules()
    {
        return [
        'editing.name' => 'required|min:3',
        'editing.description' => 'required',
        'editing.margin' => 'required',
        'editing.instance_id' => 'sometimes',
        'editing.provider_id' => 'sometimes',
        'editing.reseller_id' => 'sometimes',
    ]; }

    public function mount() { $this->editing = $this->makeBlankTransaction(); }

    public function save()
    {
        $this->validate();

        $this->editing->save();

        switch ($this->getUserLevel()) {
            case config('app.provider'):
                $this->editing->update(['provider_id' => $this->getUser()->provider->id]);

                break;
            case config('app.reseller'):
                $this->editing->update(['reseller_id' => $this->getUser()->reseller->id]);
                $this->getUser()->reseller->priceList->prices->each(function(Price $price){
                    $attributes = $price->getAttributes();
                    unset($attributes['id']);
                    $this->editing->prices()->create($attributes);
                });

                break;
            case config('app.customer'):
                abort(403, __('errors.unauthorized_action'));
        }

        $this->showEditModal = false;
    }

    public function create()
    {
        $this->useCachedRows();

        if ($this->editing->getKey()) $this->editing = $this->makeBlankTransaction();

        $this->showEditModal = true;
    }

    public function makeBlankTransaction(){ return PriceList::make(['date' => now(), 'status' => 'success']); }

    public function deleteSelected()
    {
        $deleteCount = $this->selectedRowsQuery->count();
        $this->selectedRowsQuery->delete();
        $this->showDeleteModal = false;
        $this->notify('You\'ve deleted '.$deleteCount.' transactions');
    }


    public function toggleShowFilters() { $this->showFilters = ! $this->showFilters; }

    public function sortByColumn($column)
    {
        if ($this->sortColumn == $column) {
            $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
        } else {
            $this->reset('sortDirection');
            $this->sortColumn = $column;
        }
    }

    public function resetFilters()
    {
        $this->reset();
    }

    public function resetDate()
    {
        $this->reset(['taskduedate']);
    }

    public function getRowsQueryProperty()
    {
        $priceLists = PriceList::query()
            ->when($this->filters['name'], fn($query, $name) => $query->where('name', '>=', $name))
            ->when($this->filters['description'], fn($query, $description) => $query->where('description', '<=', $description))
            ->when($this->filters['search'], fn($query, $search) => $query->where('name', 'like', '%'.$search.'%'));
        return $this->applySorting($priceLists);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function edit(PriceList $priceList)
    {
        $this->showEditModal = true;
        $this->useCachedRows();
        $this->editing = $priceList;

    }

    public function exportSelected()
    {
        return response()->streamDownload(function () {
            echo $this->selectedRowsQuery->toCsv();
        }, 'transactions.csv');
    }


    public function render(PriceList $priceLists)
    {
        $priceLists = PriceList::get();
        return view('livewire.pricelist.pricelist-table', [
            'priceLists' => $this->rows,
         ]);
    }
}
