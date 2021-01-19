<?php

namespace App\Http\Livewire\Azure;

use App\Subscription;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Models\AzurePriceList;
use App\Models\AzureUsageReport;

class AzureReport extends Component
{
    use WithPagination;

    public $subscription;
    public $taskduedate;
    public $startdate = "2021-01-18 - 2021-01-19";
    public $endtdate;
    public $dates;

    public function mount(Subscription $subscription)
    {
        $this->subscription = $subscription;
        $this->taskduedate;
    }

    public function render()
    {
        if($this->taskduedate){
            $dates = Str::of($this->taskduedate)->explode(' - ')->collect();
        }else{
        $dates = ([
            '0' => '1',
            '1' => '2',

            ]);
        }

        $reports = AzureUsageReport::where('subscription_id', $this->subscription->id)
        ->whereBetween('usageStartTime',["$dates[0]T00:00:00+00:00", "$dates[1]T00:00:00+00:00"])
        ->whereBetween('usageEndTime',["$dates[0]T00:00:00+00:00", "$dates[1]T00:00:00+00:00"])
        ->groupBy('resource_id')->paginate('10');

        $reports->map(function($item, $key) {
            $azurepricelist = AzurePriceList::where('resource_id', $item->resource_id)->get('rates');
            if ($azurepricelist->first()){
                $item['cost'] = $item->quantity+$azurepricelist->first()->rates[0];
            }
            $item->cost;
            $item->save();
            return $item;
        });
        $top5Q = AzureUsageReport::groupBy('resource_group')->where('subscription_id', $this->subscription->id)->selectRaw('sum(cost) as sum, resource_group, resource_category')->orderBy('sum', 'DESC')->limit(5)->get()->toArray();
        $resourceGroups = AzureUsageReport::where('subscription_id', $this->subscription->id)->groupBy('usageStartTime')->pluck('resource_group');


        return view('livewire.azure.azure-report', [
            'reports' => $reports,
            'resourceGroups' => $resourceGroups,
            'top5Q' => $top5Q,
            ]);
    }
}
