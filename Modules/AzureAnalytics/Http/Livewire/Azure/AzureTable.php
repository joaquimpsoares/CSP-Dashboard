<?php

namespace Modules\AzureAnalytics\Http\Livewire\Azure;

use App\Subscription;
use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use Tagydes\MicrosoftConnection\Models\Customer as TagydesCustomer;
use Tagydes\MicrosoftConnection\Facades\AzureResource as FacadesAzureResource;


class AzureTable extends Component
{

    use WithPagination;
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;

    public $editedProductIndex = null;
    public $editedProductField = null;
    public $search = '';
    public $edit=false;
    public $budget;
    public $showEditModal = false;

    public Subscription $editing;

    public function rules()
    {
        return [
            'editing.budget' => 'required|min:1'
        ];
    }


    protected $analyticRepository;
    protected $rules = ['resourceName.*.budget' => ['required', 'numeric'],];
    protected $validationAttributes = ['resourceName .*.budget' => 'budget'];

    public function updatingSearch(){$this->resetPage();}
    public function resetDate(){$this->reset(['taskduedate']);}


    public function edit(Subscription $subscription)
    {
        $this->editing = $subscription;


        $this->showEditModal = true;

    }

    public function save()
    {
        $this->validate();
        $this->editing->save();

        $value =$this->editing['budget'];
        $customer = new TagydesCustomer([
            'id' => $this->editing->customer->microsoftTenantInfo->first()->tenant_id,
            'username' => 'bill@tagydes.com',
            'password' => 'blabla',
            'firstName' => 'Nombre',
            'lastName' => 'Apellido',
            'email' => 'bill@tagydes.com',
        ]);
        $result = FacadesAzureResource::withCredentials(
            $this->editing->instance->external_id,
            $this->editing->instance->external_token
            )->changeBudget($customer, $value);
            $this->showEditModal = false;
            return redirect()->back();
        }

        public function getRowsQueryProperty()
        {
            $resourceName = Subscription::where('billing_type', 'usage')->get();
            $resourceName->map(function ($item, $key) {
                foreach ($item->azureresources as $resource) {
                    $increase = ($item->budget - $item->azureresources->sum('cost'));
                    if ($item->budget > '0') {
                        if ($increase !== '0') {
                            $average1 = ($increase / $item->budget) * 100;
                            $item['calculated'] = 100 - $average1;
                        } else {
                            $item['calculated'] = '0';
                        }
                        return $item->toArray();
                    }
                }
            });
            // dd($resourceName);
            return $this->applySorting($resourceName);
        }

        public function getRowsProperty()
        {
            return $this->cache(function () {
                return $this->applyPagination($this->rowsQuery);
            });
        }

        public function render()
        {
            return view('azureanalytics::livewire.azure.azure-table',[
                'resourceName' => $this->rows,
                ])->extends('layouts.master');
        }

    }
