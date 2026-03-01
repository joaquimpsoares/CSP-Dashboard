<?php

namespace App\Http\Livewire\Instance;

use App\Instance;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;

class InstanceTable extends Component
{
    use WithPagination;
    use WithPerPagePagination, WithSorting, WithCachedRows;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function getRowsQueryProperty()
    {
        $q = Instance::query()
            ->with(['provider'])
            ->withExpired()
            ->where(function (Builder $q) {
                $search = trim($this->search);
                if ($search === '') {
                    return;
                }

                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%")
                  ->orWhere('external_type', 'like', "%{$search}%")
                  ->orWhereHas('provider', function (Builder $p) use ($search) {
                      $p->where('company_name', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%");
                  });
            });

        return $this->applySorting($q);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.instance.instance-table', [
            'instances' => $this->rows,
        ]);
    }
}
