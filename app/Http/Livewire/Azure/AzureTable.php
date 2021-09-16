<?php

namespace App\Http\Livewire\Azure;

use App\Instance;
use App\Subscription;
use Livewire\Component;
use Livewire\WithPagination;
use App\Repositories\AnalyticRepositoryInterface;
use Tagydes\MicrosoftConnection\Models\Customer as TagydesCustomer;
use Tagydes\MicrosoftConnection\Facades\AzureResource as FacadesAzureResource;


class AzureTable extends Component
{

    use WithPagination;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public $editedProductIndex = null;
    public $editedProductField = null;
    public $search = '';
    public $resourceName =[];
    public $edit=false;
    public $budget;

    protected $analyticRepository;

    protected $rules = [
        'resourceName.*.budget' => ['required', 'numeric'],
    ];

    protected $validationAttributes = [
        'resourceName .*.budget' => 'budget',
    ];


    public function mount()
    {
        $this->resourceName = Subscription::where('billing_type', 'usage')->get();

        $this->resourceName->map(function ($item, $key) {
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

    }


    public function editProduct($productIndex)
    {
        $this->editedProductIndex = $productIndex;
    }

    public function editProductField($productIndex, $fieldName)
    {
        $this->editedProductField = $productIndex . '.' . $fieldName;
    }

    public function saveBudget($productIndex){

        $subscription = $this->resourceName[$productIndex]->toArray() ?? NULL;

        $instance = Instance::where('id', $subscription['instance_id'])->first();

        $value =$subscription['budget'];
        $customer = new TagydesCustomer([
            'id' => $this->resourceName[$productIndex]->customer->microsoftTenantInfo->first()->tenant_id,
            'username' => 'bill@tagydes.com',
            'password' => 'blabla',
            'firstName' => 'Nombre',
            'lastName' => 'Apellido',
            'email' => 'bill@tagydes.com',
        ]);

        $result = FacadesAzureResource::withCredentials(
            $instance->external_id,
            $instance->external_token
        )->changeBudget($customer, $value);

        if (!is_null($subscription)) {
            optional(Subscription::find($subscription['id']))->update(['budget' => $subscription['budget']]);
        }

        $this->editedProductIndex = null;
        $this->editedProductField = null;

        session()->flash('success','Budget ' . $subscription['name'] . ' Updated successfully');
        return redirect()->back();

    }

    public function render()
    {
        return view('livewire.azure.azure-table',[
            'resourceName' => $this->resourceName->paginate(10)]);
    }



}
