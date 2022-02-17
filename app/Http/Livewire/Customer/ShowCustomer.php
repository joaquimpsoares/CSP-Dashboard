<?php

namespace App\Http\Livewire\Customer;

use Exception;
use App\Country;
use App\Customer;
use App\Instance;
use App\Models\Status;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use GuzzleHttp\Exception\ClientException;
use Tagydes\MicrosoftConnection\Models\Customer as TagydesCustomer;
use Tagydes\MicrosoftConnection\Facades\Customer as MicrosoftCustomer;
use Tagydes\MicrosoftConnection\Facades\Subscription as SubscriptionFacade;
use Tagydes\MicrosoftConnection\Models\Subscription as TagydesSubscription;

class ShowCustomer extends Component
{
    public $customer;
    public $country;
    public $countries;
    public $statuses;
    public Customer $editing;
    public $showEditModal = false;
    public $showconfirmationModal = false;

    protected $listeners = ['refreshTransactions' => '$refresh'];


    public function rules(){
        return [
            'editing.company_name'  => ['required','string','regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/','max:255'],
            'editing.address_1'     => ['required','string','max:255','min:3'],
            'editing.address_2'     => ['nullable','string','max:255','min:3'],
            'editing.city'          => ['required','string','max:255','min:3'],
            'editing.country_id'    => ['required','integer','min:1','exists:countries,id'],
            'editing.state'         => ['required','string','max:255','min:3'],
            'editing.nif'           => ['required','min:3'],
            'editing.postal_code'   => ['required','string','max:255','min:3'],
            'editing.markup'        => ['required','min:1'],
            'editing.status_id'     => ['required','exists:statuses,id'],
            'editing.price_list_id' => ['required','integer','exists:price_lists,id'],
            'editing.qualification' => ['nullable', 'string', 'min:1'],

        ];
    }

    public function checkQualificationStatus(Customer $customer){

        $return = $customer->checkCustomerQualification($customer);

        if(!$return->isempty()){
        $this->customer->update([
            'qualification_status' => $return[0]['vettingStatus'],
        ]);
        if($return[0]['vettingStatus'] == 'Denied'){
            $this->customer->update([
                'qualification' => $return[0]['vettingReason'],
            ]);
        }
    }
        $this->emit('refreshTransactions');

    }
    public function updated($propertyName){$this->validateOnly($propertyName);}

    public function edit(Customer $customer)
    {
        $this->editing = $customer;
        $this->showEditModal = true;
    }

    public function disable(Customer $customer){
        $this->showconfirmationModal = false;
        foreach ($customer->subscriptions as $key => $subscriptions) {
            $subscription = new TagydesSubscription([
                'id'            => $subscriptions->subscription_id,
                'orderId'       => $subscriptions->order_id,
                'offerId'       => $subscriptions->product_id,
                'customerId'    => $subscriptions->customer->microsoftTenantInfo->first()->tenant_id,
                'name'          => $subscriptions->name,
                'status'        => $subscriptions->status_id,
                'quantity'      => $subscriptions->amount,
                'currency'      => $subscriptions->currency,
                'billingCycle'  => $subscriptions->billing_period,
                'created_at'    => $subscriptions->created_at->__toString(),
            ]);


            try {
                SubscriptionFacade::withCredentials($subscriptions->instance->external_id, $subscriptions->instance->external_token)->update($subscription, ['status' => 'suspended']);
                Log::info(Auth::user()->name. 'MS subscriptions: '.$subscription .'suspended');
                $subscriptions->update(['status_id' => 2]);

            } catch (Exception $e) {
                return Redirect::back()->with('danger','Error Placing order to Microsoft: '.$e->getMessage());
                Log::info('Error Placing order to Microsoft: '.$e->getMessage());
            }
        }
        $customer->update(['status_id' => 2]);
        $this->notify('Customer ' . $customer->company_name . ' is disabled, refresh page');
    }

    public function enable(Customer $customer){

        foreach ($customer->subscriptions as $key => $subscriptions) {
            $subscription = new TagydesSubscription([
                'id'            => $subscriptions->subscription_id,
                'orderId'       => $subscriptions->order_id,
                'offerId'       => $subscriptions->product_id,
                'customerId'    => $subscriptions->customer->microsoftTenantInfo->first()->tenant_id,
                'name'          => $subscriptions->name,
                'status'        => $subscriptions->status_id,
                'quantity'      => $subscriptions->amount,
                'currency'      => $subscriptions->currency,
                'billingCycle'  => $subscriptions->billing_period,
                'created_at'    => $subscriptions->created_at->__toString(),
            ]);


            try {
                SubscriptionFacade::withCredentials($subscriptions->instance->external_id, $subscriptions->instance->external_token)->update($subscription, ['status' => 'active']);
                Log::info(Auth::user()->name. 'MS subscriptions: '.$subscription .'active');
                $subscriptions->update(['status_id' => 1]);

            } catch (Exception $e) {
                return Redirect::back()->with('danger','Error Placing order to Microsoft: '.$e->getMessage());
                Log::info('Error Placing order to Microsoft: '.$e->getMessage());
            }
        }
        $customer->update(['status_id' => 1]);
        $this->notify('Customer ' . $customer->company_name . ' is enabled, refresh page');
    }

    Public function CustomerServiceCosts($customer){
        if (!$customer->subscriptions->isEmpty()){
            $instance = $customer->subscriptions->first()->instance_id;
            $instance = Instance::find($instance);
            try {
                $customer = new TagydesCustomer([
                    'id' => $customer->microsoftTenantInfo->first()->tenant_id,
                    'username' => 'bill@tagydes.com',
                    'password' => 'blabla',
                    'firstName' => 'Nombre',
                    'lastName' => 'Apellido',
                    'email' => 'bill@tagydes.com',
                ]);
                $resources = MicrosoftCustomer::withCredentials($instance->external_id, $instance->external_token)->serviceCosts($customer);

                return $resources;
            } catch (\Throwable $th) {

            }
        }

    }

    Public function CustomerLicenseUsage($customer){
        if (!$customer->subscriptions->isEmpty()){
            $instance = $customer->subscriptions->first()->instance_id;
            $instance = Instance::find($instance);
            try {
                $customer = new TagydesCustomer([
                    'id' => $customer->microsoftTenantInfo->first()->tenant_id,
                    'username' => 'bill@tagydes.com',
                    'password' => 'blabla',
                    'firstName' => 'Nombre',
                    'lastName' => 'Apellido',
                    'email' => 'bill@tagydes.com',
                ]);
                $resources = MicrosoftCustomer::withCredentials($instance->external_id, $instance->external_token)->serviceUsage($customer);
                return $resources;

            } catch (\Throwable $th) {

            }
        }
    }

    public function save(Customer $customer){
        // $this->validate();
        DB::beginTransaction();
        $this->editing->save();
        if(collect($this->editing->getChanges())->has('qualification')){
            try {
               $return = $this->editing->updateCustomerQualification($customer, $this->editing->qualification);

               if ($return['vettingStatus'] == 'Denied') {
                $this->notify('', $return['vettingReason'] ,'error' );
                DB::rollBack();
                $this->editing->qualification_status = $return['vettingReason']->update();
                return false;
            }

            if ($return['vettingStatus'] == 'InReview') {
                $customer->update([
                    'qualification_status' => $return['vettingStatus']
                ]);
                $this->notify('','Your Qualification is '. $return['vettingStatus'] ,'info' );
            }

            } catch (\Throwable $th) {
                DB::rollBack();
                $this->showEditModal = false;
                $this->notify('error','updating ' . $th->getMessage());
            }
        }

        DB::commit();

        $this->showEditModal = false;
        $this->notify('Customer ' . $customer->company_name . ' saved successfully, refresh page');
        $this->emit('refreshTransactions');

    }


    public function render(Customer $customer){
        $customer = $this->customer;
        $countries = Country::get();
        $statuses = Status::get();
        $subscriptions = $this->customer->subscriptions;
        // $costs = $this->CustomerServiceCosts($customer);
        $usage = $this->CustomerLicenseUsage($customer);
        return view('livewire.customer.show-customer', compact('statuses','countries', 'customer', 'subscriptions','usage'));
    }
}
