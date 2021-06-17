<?php

namespace App\Http\Livewire\Job;

use App\Jobs;
use Livewire\Component;
use App\Exports\JobsExport;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use romanzipp\QueueMonitor\Models\Monitor;


class JobTable extends Component
{
    use WithPagination;

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
        $search = $this->search;

        $query = Monitor::query();

        $jobs = $query
        ->where(function ($q)  {
            $q->orWhere('id', 'like', "%{$this->search}%");
            $q->orWhere('queue', 'like', "%{$this->search}%");
        })->paginate(10);

        // $jobs->getCollection()->map(function(Monitor $job){
        //     $job->setRawAttributes(json_decode(json_encode($job->format()), true)); // Coverts to array recursively (make helper from it?)
        //     return $job;
        // });
        return view('livewire.job.job-table',compact('jobs'));
    }
}
