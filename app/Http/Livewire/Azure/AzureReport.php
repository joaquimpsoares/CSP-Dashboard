<?php

namespace App\Http\Livewire\Azure;

use Livewire\Component;
use App\Models\AzureUsageReport;

class AzureReport extends Component
{

    public $reports;
    public $taskduedate;

    public function mount($reports)
    {
        // $this->$taskduedate;
        $this->reports = $reports;
    }

    public function render()
    {

        // $reports = AzureUsageReport::where('subscription_id', $subscription->id)->groupBy('resource_id')->get();
        return view('livewire.azure.azure-report');
    }
}
