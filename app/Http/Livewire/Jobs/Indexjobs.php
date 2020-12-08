<?php

namespace App\Http\Livewire\Jobs;

use App\Jobs;
use Livewire\Component;
use App\Notifications\FailedJob;
use Illuminate\Support\Facades\DB;

class Indexjobs extends Component
{


    public function mount(){
                
      
    }

    public function render()
    {
        return view('livewire.jobs.indexjobs',[
            'jobs' => Jobs::all(),
            'failedJobs' => DB::table('failed_jobs')->get(),
        ]);
       }
}
