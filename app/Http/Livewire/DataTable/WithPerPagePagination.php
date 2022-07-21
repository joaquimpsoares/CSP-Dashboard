<?php

namespace App\Http\Livewire\DataTable;

use Livewire\WithPagination;

trait WithPerPagePagination
{
    use WithPagination;

    public $perPage = 12;

    public function mountWithPerPagePagination()
    {
        $this->perPage = session()->get('perPage', $this->perPage);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage($value)
    {
        session()->put('perPage', $value);
    }

    public function applyPagination($query)
    {
        // dd($query->count() > 0);
        if($query->count() > 0){
            return $query->orderBy('id' ?? null, 'desc')->paginate($this->perPage);
        }
        return $query->paginate($this->perPage);
    }
}
