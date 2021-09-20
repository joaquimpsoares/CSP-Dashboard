<?php

namespace App\Http\Livewire\Azure;

use App\Subscription;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Exports\exportAzure;
use App\Models\AzurePriceList;
use App\Models\AzureUsageReport;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithPerPagePagination;

class AzureReport extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;

    protected $paginationTheme = 'bootstrap';

    public $subscription;
    public $taskduedate;
    public $startdate;
    public $endtdate;

    public $dates;
    public $selectRgroup;
    public $selectCategory;
    public $selectSubCategory;
    public $selectLocation;

    protected $queryString = ['sorts'];

    public function mount(Subscription $subscription)
    {
        $this->subscription = $subscription;
        $this->taskduedate;
        $this->selectRgroup;
        $this->selectCategory;
        $this->selectSubCategory;
        $this->selectLocation;


    }

    public function resetFilters()
    {
        $this->reset();
    }

    public function resetDate()
    {
        $this->reset(['taskduedate']);
    }


    public function exportSelected()
    {
        if($this->taskduedate){
            $dates = Str::of($this->taskduedate)->explode(' - ')->collect();
        }else{
        $dates = (['0' => '1', '1' => '2']);
        }
        $query = AzureUsageReport::query();

        if ($this->selectRgroup) {
            $query->where('resource_group', $this->selectRgroup);
            $categories     = AzureUsageReport::where('resource_group', $this->selectRgroup)->groupBy('resource_category')->pluck('resource_category');
        }
        if ($this->selectCategory) {
            $query->where('resource_category', $this->selectCategory);
            $subcategories  = AzureUsageReport::where('resource_category', $this->selectCategory)->where('resource_group', $this->selectRgroup)->groupBy('resource_subcategory')->pluck('resource_subcategory');
        }
        if ($this->selectSubCategory) {
            $query->where('resource_subcategory', $this->selectSubCategory);
            $region = AzureUsageReport::where('resource_subcategory', $this->selectSubCategory)->where('resource_group', $this->selectRgroup)->groupBy('resource_region')->pluck('resource_region');
        }
        if ($this->selectLocation) {
            $query->where('resource_location', $this->selectLocation);
        }

        $reports = $query->where('subscription_id', $this->subscription->id)
        ->whereBetween('usageStartTime',["$dates[0]T00:00:00+00:00", "$dates[1]T00:00:00+00:00"])
        ->whereBetween('usageEndTime',["$dates[0]T00:00:00+00:00", "$dates[1]T00:00:00+00:00"])
        // ->orderBy($this->sortColumn, $this->sortDirection)
        ->pluck('id')->toArray();
        return (new exportAzure($reports))->download('azureReports '.$this->subscription->customer->company_name.'.xlsx');
    }

    public function getRowsQueryProperty()
    {
        if($this->taskduedate){
            $dates = Str::of($this->taskduedate)->explode(' - ')->collect();
        }else{
            $dates = (['0' => '1', '1' => '2']);
        }

        $query = AzureUsageReport::query();
        $query->where('subscription_id', $this->subscription->id)
        ->whereBetween('usageStartTime',["$dates[0]T00:00:00+00:00", "$dates[1]T00:00:00+00:00"])
        ->whereBetween('usageEndTime',["$dates[0]T00:00:00+00:00", "$dates[1]T00:00:00+00:00"]);

        $query->map(function($item, $key) {
            $azurepricelist = AzurePriceList::where('resource_id', $item->resource_id)->get('rates');
            if ($azurepricelist->first()){
                $item['cost'] = $item->quantity+$azurepricelist->first()->rates[0];
            }
            $item->cost;
            $item->save();

            return $this->cache(function () use($item){
                return $item;
            });
        });
        dd($query);
        return $this->applySorting($query);
    }


    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }


    public function render()
    {

        $top5Q          = AzureUsageReport::groupBy('resource_group')->where('subscription_id', $this->subscription->id)->selectRaw('sum(cost) as sum, resource_group, resource_category')->orderBy('sum', 'DESC')->limit(5)->get()->toArray();
        $resourceGroups = AzureUsageReport::where('subscription_id', $this->subscription->id)->groupBy('resource_group')->pluck('resource_group');
        $categories     = AzureUsageReport::where('subscription_id', $this->subscription->id)->groupBy('resource_category')->pluck('resource_category');
        $subcategories  = AzureUsageReport::where('subscription_id', $this->subscription->id)->groupBy('resource_subcategory')->pluck('resource_subcategory');
        $region         = AzureUsageReport::where('subscription_id', $this->subscription->id)->groupBy('resource_region')->pluck('resource_region');



        dd($this->rows);

    return view('livewire.azure.azure-report', [
        'reports' => $this->rows,
        'resourceGroups' => $resourceGroups,
        'categories' => $categories,
        'top5Q' => $top5Q,
        'subcategories' => $subcategories,
        'region' => $region,
        ]);
    }
}
