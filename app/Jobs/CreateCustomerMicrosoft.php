<?php

namespace App\Jobs;

use App\Order;
use Exception;
use App\Customer;
use App\Instance;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Tagydes\MicrosoftConnection\Facades\Customer as TagydesCustomer;



class CreateCustomerMicrosoft implements ShouldQueue
{
    public $order;
    
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    /**
    * Create a new job instance.
    *
    * @return void
    */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
    
    /**
    * Execute the job.
    *
    * @return void
    */
    public function handle()
    {        
        $this->order->oder_status_id = 2; //Order running state
        $this->order->save();
        
        $instance = Instance::first();
        
        // $searchCustomer = Customer::where('id', $this->order->customer_id)->first();
        
        try {
            $customer = TagydesCustomer::withCredentials($instance->external_id, $instance->external_token)->create([
                'company' => $this->order->customer->company_name,
                'domain' => "tagydescbi128.onmicrosoft.com",
                'culture' => 'EN-US',
                'language' => 'en',
                'address' => $this->order->customer->address_1,
                'city' => $this->order->customer->city,
                'province' => $this->order->customer->state,
                'postalCode' => $this->order->customer->postal_code,
                'country' => $this->order->customer->country->iso_3166_2,
                //mca agreement
                'firstName' => $this->order->agreement_firstname,
                'lastName' => $this->order->agreement_lastname,
                'email' => $this->order->agreement_email,
                'telephone' => $this->order->agreement_phone,
                //mca agreement
                ]);

                $cust = Customer::where('id', $this->order->customer->id)->first();
                $cust->tenant_id  =  $customer->id;
                $cust->tenant_user = $customer->username;
                $cust->temp_pass = $customer->temp_pass;
                $cust->save();

            } catch (Exception $e) {
                $this->order->oder_status_id = 3; //Order failed state
                $this->order->save();
            }
            
            
            $this->order->oder_status_id = 4; //Order completed state
            $this->order->save();
            
            
            
            
            
            
            
        }
    }
