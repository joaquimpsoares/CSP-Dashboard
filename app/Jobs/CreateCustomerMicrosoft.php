<?php

namespace App\Jobs;

use App\User;
use App\Order;
use Exception;
use App\Customer;
use App\Instance;
use App\MicrosoftTenantInfo;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use App\Events\MSCustomerCreationEvent;
use App\Notifications\UserNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;
use romanzipp\QueueMonitor\Traits\IsMonitored;
use Modules\MicrosoftCspConnection\Models\MicrosoftCspConnection;
use Modules\MicrosoftCspConnection\Services\MicrosoftCspClient;
use Modules\MicrosoftCspConnection\Services\CustomerService;

class CreateCustomerMicrosoft implements ShouldQueue
{
    public $order;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, IsMonitored;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function handle()
    {
        $this->order->details = ('Stage 1 - Creating Customer '. $this->order->customer->company_name);
        $this->order->order_status_id = 2; //Order running state
        $this->order->save();

        $customer = $this->order->customer;
        $instance = Instance::where('id', $this->order->products->first()->instance_id)->first();

        Log::info('Confirmation of Result: '.$instance);
        Log::info('Confirmation of Result: '.$customer);
        Log::info('Confirmation Customer Country: '.$customer->country->iso_3166_2);

        // Resolve CSP connection for this provider
        $connection = MicrosoftCspConnection::where('provider_id', $instance->provider_id)->firstOrFail();
        $client          = new MicrosoftCspClient($connection, config('microsoftcspconnection'));
        $customerService = new CustomerService($client);

        try {
            $newCustomer = $customerService->create([
                'company'    => $customer->company_name,
                'domain'     => $this->order->domain,
                'culture'    => 'EN-US',
                'language'   => 'en',
                'address'    => $customer->address_1,
                'city'       => $customer->city,
                'province'   => $customer->state,
                'postalCode' => $customer->postal_code,
                'country'    => $customer->country->iso_3166_2,
                // MCA agreement
                'firstName'  => $this->order->agreement_firstname,
                'lastName'   => $this->order->agreement_lastname,
                'email'      => $this->order->agreement_email,
                'telephone'  => $this->order->agreement_phone,
            ]);

            logger('Customer created via Partner Center API', $newCustomer);

        } catch (Exception $e) {
            Log::error('Error creating Customer Microsoft: '.$e->getMessage());

            $this->order->details = ('Error creating Customer Microsoft: '.$e->getMessage());
            $this->order->order_status_id = 3;
            $this->order->save();

            return;
        }

        // Partner Center response contains the Microsoft-assigned tenant ID in 'id'
        $tenantId     = $newCustomer['id'] ?? null;
        $tenantDomain = $newCustomer['companyProfile']['domain'] ?? $this->order->domain;

        $result = MicrosoftTenantInfo::create([
            'tenant_id'     => $tenantId,
            'tenant_domain' => $tenantDomain,
            'customer_id'   => $customer->id,
        ]);

        Notification::send($this->order->customer->users, new UserNotification($newCustomer));

        Log::info('Customer Created: '.json_encode($newCustomer));
        Log::info('Tenant Created: '.$result);

        $this->order->ext_company_id = $tenantId;
        $this->order->save();

        session()->flash('success', 'Customer created successfully in Partner Center');
    }
}
