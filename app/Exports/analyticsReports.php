<?php

namespace App\Exports;

use App\AzureResource;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class analyticsReports implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('livewire.azure.azure-report', [
            'resources' => AzureResource::all()
        ]);
    }
}
