<?php

namespace App\Http\Livewire\Job;

use App\Jobs;
use Livewire\Component;
use App\Models\FailedJobs;
use App\Exports\JobsExport;
use Livewire\WithPagination;
use App\Http\Traits\UserTrait;
use App\Notifications\FailedJob;
use Maatwebsite\Excel\Facades\Excel;
use romanzipp\QueueMonitor\Models\Monitor;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithPerPagePagination;

class JobTable extends Component
{
    use WithPagination;
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;
    use UserTrait;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function exportSelected()
    {
        return Excel::download(new JobsExport, 'Jobs.xlsx');
    }

    public function render()
    {

        $query = Monitor::query()->orderBy('id', 'DESC');

        $jobs = $query
        ->where(function ($q)  {
            $q->orWhere('id', 'like', "%{$this->search}%");
            $q->orWhere('queue', 'like', "%{$this->search}%");
        })->paginate(10);

        $failedjobs = FailedJobs::get();
        // dd($failedjobs->first()->getPayload->all());

        return view('livewire.job.job-table',compact('jobs', 'failedjobs'));
    }
}
