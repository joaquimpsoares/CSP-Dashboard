<?php

namespace App\Http\Livewire\Job;

use Livewire\Component;
use App\Models\FailedJobs;
use Livewire\WithPagination;
use App\Http\Traits\UserTrait;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithPerPagePagination;

class FailedjobsTable extends Component
{

    use WithPagination;
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;
    use UserTrait;

    public function render()
    {
        $failedjobs = FailedJobs::get()->paginate(10);
        return view('livewire.job.failedjobs-table', compact('failedjobs'));

    }
}
