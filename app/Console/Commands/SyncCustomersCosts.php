<?php

namespace App\Console\Commands;

use Exception;
use App\Customer;
use App\Instance;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Tagydes\MicrosoftConnection\Models\Customer as TagydesCustomer;
use Tagydes\MicrosoftConnection\Facades\Customer as MicrosoftCustomer;

class SyncCustomersCosts extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'command:synccosts';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Command description';

    /**
    * Execute the console command.
    *
    * @return int
    */
    public function handle()
    {
        try {
           $resources = Customer::eachById(function (Customer $customer)  {
                $instance = $customer->resellers->first()->provider->instances->first();
                $customer = new TagydesCustomer([
                    'id' => $customer->microsoftTenantInfo->first()->tenant_id,
                    'username' => 'bill@tagydes.com',
                    'password' => 'blabla',
                    'firstName' => 'Nombre',
                    'lastName' => 'Apellido',
                    'email' => 'bill@tagydes.com',
                ]);
                $resources = MicrosoftCustomer::withCredentials($instance->external_id, $instance->external_token)->serviceCosts($customer);
                dd($resources);
                return $resources;

            });

        } catch (\Throwable $th) {
            //throw $th;
        }

        // Mail::raw("Just finished msft invoices Syncronization", function ($mail)  {
            //     $mail->to('joaquim.soares@tagydes.com')
            //     ->subject('Monthly import MSFT Invoices');
            // });
            $this->info('Successfully sent daily quote to everyone.');
        }
}
