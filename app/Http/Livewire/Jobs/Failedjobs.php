<?php

namespace App\Http\Livewire\Jobs;

use App\Jobs;
use Livewire\Component;
use App\Notifications\FailedJob;
use Illuminate\Support\Facades\DB;

class Failedjobs extends Component
{


    public function mount(){


    }

    public function render()
    {
        //     return view('livewire.jobs.failedjobs',[
            //         'jobs' => Jobs::all(),
            //         'failedJobs' => DB::table('failed_jobs')->get(),
            //     ]);
            //    }
    }
}
