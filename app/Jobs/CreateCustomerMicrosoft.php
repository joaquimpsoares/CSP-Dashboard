<?php

namespace App\Jobs;

use App\Order;
use Exception;
use App\Customer;
use App\Instance;
use App\MicrosoftTenantInfo;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Tagydes\MicrosoftConnection\Facades\Customer as TagydesCustomer;



class CreateCustomerMicrosoft implements ShouldQueue
{
    public $order;
    
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
    
    public function handle()
    {

        $this->order->order_status_id = 2; //Order running state
        $this->order->save();
        
        $instance = Instance::first();
        
        $customer = $this->order->customer;

        Log::info('Confirmation of Result: '.$customer);
        
        try {
            $newCustomer = TagydesCustomer::withCredentials($instance->external_id, $instance->external_token)->create([
                'company' => $customer->company_name,
                'domain' => $this->order->domain,
                'culture' => 'EN-US',
                'language' => 'en',
                'address' => $customer->address_1,
                'city' => $customer->city,
                'province' => $customer->state,
                'postalCode' => $customer->postal_code,
                'country' => $customer->country->iso_3166_2,
                //mca agreement
                'firstName' => $this->order->agreement_firstname,
                'lastName' => $this->order->agreement_lastname,
                'email' => $this->order->agreement_email,
                'telephone' => $this->order->agreement_phone,
                //mca agreement
            ]);         
            
            Log::info('Customer Created: '.$newCustomer);

            $result = MicrosoftTenantInfo::create([
                'tenant_id' => $newCustomer->id,
                'tenant_domain' => $this->order->domain,
                'customer_id' => $customer->id
            ]);

            Log::info('Tenant Created: '.$result);

            $this->order->ext_company_id = $newCustomer->id; 
            $this->order->save();

        } catch (Exception $e) {
            Log::info('Error: '.$e->getMessage());
            $this->order->order_status_id = 3; 
            $this->order->save();
        }

    }
}
