<?php

namespace App\Http\Livewire\Job;

use App\Jobs;
use Livewire\Component;
use App\Exports\JobsExport;
use Maatwebsite\Excel\Facades\Excel;

class JobTable extends Component
{
    public $search = '';

    public function exportSelected()
    {
        return Excel::download(new JobsExport, 'Jobs.xlsx');
    }

    public function render()
    {
        $search = $this->search;

        $query = Jobs::query();

        $jobs = $query
        ->where(function ($q)  {
            $q->orWhere('id', 'like', "%{$this->search}%");
            $q->orWhere('queue', 'like', "%{$this->search}%");
        })->
        with(['prices', 'provider', 'reseller','Customer'])->paginate(10);

        $jobs->getCollection()->map(function(Jobs $job){
            $job->setRawAttributes(json_decode(json_encode($job->format()), true)); // Coverts to array recursively (make helper from it?)
            return $job;
        });
        return view('livewire.job.job-table',compact('jobs'));
    }
}
