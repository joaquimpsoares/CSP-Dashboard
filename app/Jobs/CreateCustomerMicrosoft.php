<?php

namespace App\Jobs;

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
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    /**
    * Create a new job instance.
    *
    * @return void
    */
    public function __construct()
    {
        //
    }
    
    /**
    * Execute the job.
    *
    * @return void
    */
    public function handle()
    {
        
        $instance = Instance::first();
        
        // $searchCustomer = Customer::where('id', $cart->customer['id'])->with('country')->first();
        $searchCustomer = Customer::first();
        
        $customer = TagydesCustomer::withCredentials($instance->external_id, $instance->external_token)->create([
            'company' => $searchCustomer->company_name,
            'domain' => "tagydescbi125.onmicrosoft.com",
            'culture' => 'EN-US',
            'email' => $searchCustomer->users()->first()->email,
            'language' => 'en',
            'firstName' => $searchCustomer->users()->first()->first_name,
            'lastName' => $searchCustomer->users()->first()->last_name,
            'address' => $searchCustomer->address_1,
            'city' => $searchCustomer->city,
            'province' => $searchCustomer->state,
            'postalCode' => $searchCustomer->postal_code,
            'country' => 'ma' //$searchCustomer->country->iso_3166_2,
            ]);

            $cust = Customer::where('id', $searchCustomer->id)->first();
                $cust->tenant_id  =  $customer->id;
                $cust->tenant_user = $customer->username;
                // $cust->temp_pass = $customer->temp_pass;
                $cust->save();

        }
    }
