<?php

namespace App\Http\Livewire\Log;

use Livewire\Component;
use App\Exports\JobsExport;
use Livewire\WithPagination;
use App\Http\Traits\UserTrait;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithPerPagePagination;

class LogTable extends Component
{

    public $search = '';
    public $logs;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function exportSelected()
    {
        return Excel::download(new JobsExport, 'Jobs.xlsx');
    }

    use WithPagination;
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;
    use UserTrait;

    public function render()
    {
        $logs = $this->logs->paginate(10);
        return view('livewire.log.log-table', compact('logs'));
    }
}
