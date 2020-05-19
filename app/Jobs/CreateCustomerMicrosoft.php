<?php

namespace App\Jobs;

use App\Customer;
use App\Instance;
use App\MicrosoftTenantInfo;
use App\Order;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
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

            $result = MicrosoftTenantInfo::create([
                'tenant_id' => $newCustomer->id,
                'tenant_domain' => $this->order->domain,
                'customer_id' => $customer->id
            ]);


        } catch (Exception $e) {
            $this->order->order_status_id = 3; 
            $this->order->save();
        }

    }
}
