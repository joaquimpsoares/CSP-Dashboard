<?php

namespace App\Http\Livewire\Customer;

use Exception;
use App\Country;
use App\Customer;
use App\Instance;
use App\Models\Status;
use Livewire\Component;
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


    public function rules()
    {
        return [
            'editing.company_name'  => ['required', 'string', 'regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/', 'max:255'],
            'editing.address_1'     => ['required', 'string', 'max:255', 'min:3'],
            'editing.address_2'     => ['nullable', 'string', 'max:255', 'min:3'],
            'editing.city'          => ['required', 'string', 'max:255', 'min:3'],
            'editing.country_id'    => ['required', 'integer', 'min:1','exists:countries,id'],
            'editing.state'         => ['required', 'string', 'max:255', 'min:3'],
            'editing.nif'           => ['required', 'min:3'],
            'editing.postal_code'   => ['required', 'string', 'max:255', 'min:3'],
            'editing.markup'        => ['required', 'min:1'],
            'editing.status_id'     => ['required', 'exists:statuses,id'],
            'editing.price_list_id' => ['required','integer', 'exists:price_lists,id']
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function edit(Customer $customer)
    {
        $this->editing = $customer;
        $this->showEditModal = true;
    }

    public function disable(Customer $customer)
    {
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

    public function enable(Customer $customer)
    {

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

    Public function CustomerServiceCosts($customer)
    {
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

    Public function CustomerLicenseUsage($customer)
    {
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


    public function save(Customer $customer)
    {
        $validatedData = $this->validate();
        try {
            // $newCustomer = TagydesCustomer::withCredentials($customer->provider->instances->first()->external_id, $customer->provider->instances->first()->external_token)
            // ->checkAddress([
                //     'AddressLine1'  => $this->editing->address_1,
                //     'City'          => $this->editing->city,
                //     'State'         => $this->editing->state,
                //     'PostalCode'    => $this->editing->postal_code,
                //     'Country'       => $this->editing->country->iso_3166_2,
                // ]);

                // if($newCustomer->status === 'NotValidated'){
                    //     $this->showEditModal = false;
                    //     $this->notify($newCustomer->validationMessage);
                    // }

                    $this->editing->save();
                    $this->showEditModal = false;


                } catch (ClientException $e) {
                    $this->showEditModal = false;
                    $this->notify('Customer ' . $e->getMessage() . ' created successfully');
                    Log::info('Error saving reseller: '.$e->getMessage());
                }
                $this->notify('Customer ' . $customer->company_name . ' saved successfully, refresh page');


            }


            public function render(Customer $customer)
            {
                $customer = $this->customer;
                $countries = Country::get();
                $statuses = Status::get();
                $subscriptions = $this->customer->subscriptions;
                // $costs = $this->CustomerServiceCosts($customer);
                $usage = $this->CustomerLicenseUsage($customer);
                return view('livewire.customer.show-customer', compact('statuses','countries', 'customer', 'subscriptions','usage'));
            }
        }
