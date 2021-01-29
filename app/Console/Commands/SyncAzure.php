<?php

namespace App\Console\Commands;

use App\User;
use Exception;
use App\Customer;
use App\Instance;
use App\Subscription;
use Illuminate\Support\Str;
use App\Models\AzurePriceList;
use Illuminate\Console\Command;
use App\Models\AzureUsageReport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Tagydes\MicrosoftConnection\Models\Customer as TagydesCustomer;
use Tagydes\MicrosoftConnection\Models\Subscription as TagydesSubscription;
use Tagydes\MicrosoftConnection\Facades\AzureResource as FacadesAzureResource;


class SyncAzure extends Command
{

    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'SyncAzure:daily';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Command description';

    /**
    * Create a new command instance.
    *
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
    }

    /**
    * Execute the console command.
    *
    * @return int
    */
    public function handle()
    {

        $subscriptions = Subscription::where('billing_type', 'usage')->get();


        foreach($subscriptions as $subscription){

            if($subscription->product_id == 'MS-AZR-0145P'){
                $instance = Instance::where('id', $subscription->instance_id)->first();

                $msId = $subscription->customer->microsoftTenantInfo->first()->tenant_id;


                $this->info('Sync customer ' . $msId . ' Subscription ' . $subscription->subscription_id . ' subscription name '. $subscription->name);

                $customer = new TagydesCustomer([
                    'id' => $msId,
                    'username' => 'bill@tagydes.com',
                    'password' => 'blabla',
                    'firstName' => 'Nombre',
                    'lastName' => 'Apellido',
                    'email' => 'bill@tagydes.com',
                    ]);

            $subscriptions = new TagydesSubscription([
                'id'            => $subscription->subscription_id,
                'orderId'       => "C01AD64D-6D65-45C4-B755-C11BD4F0DA0E",
                'offerId'       => "C01AD64D-6D65-45C4-B755-C11BD4F0DA0E",
                'customerId'    => "4e03835b-242f-441c-9958-ad3e5e05f55d",
                'name'          => "5trvfvczdfv",
                'status'        => "5trvfvczdfv",
                'quantity'      => "1",
                'currency'      => "EUR",
                'billingCycle'  => "monthly",
                'created_at'    => "5trvfvczdfv",
                ]);



            $resources = FacadesAzureResource::withCredentials(
                $instance->external_id,$instance->external_token
                )->utilizations($customer, $subscriptions);

                try{

                    $resources->items->each(function($resource) use($subscription){
                        $resourceGroup = Str::of($resource->instanceData->resourceUri)->explode('/');
                        $price = AzurePriceList::where('resource_id', $resource->resource->id)->first('rates');
                        // Log::info($price);
                        Log::info(json_encode($resource->resource->id));

                    $resource = AzureUsageReport::updateOrCreate([
                        'subscription_id'       => $subscription->id,
                        'resource_id'           => $resource->resource->id,
                        'usageStartTime'        => $resource->usageStartTime,
                        'usageEndTime'          => $resource->usageEndTime,
                    ], [
                        'resource_group'        => $resourceGroup[4],
                        'resource_location'     => $resource->instanceData->location,
                        'resource_name'         => $resource->resource->name,
                        'resource_category'     => $resource->resource->category,
                        'resource_subcategory'  => $resource->resource->subcategory,
                        'resource_region'       => $resource->resource->region,
                        'quantity'              => $resource->quantity,
                        'unit'                  => $resource->unit,
                        'cost'                  => (json_encode($price->rates[0])*$resource->quantity)
                        ]);
                        Log::info(json_encode($price->rates[0])*$resource->quantity);
                        // $this->info($resource);
                    });
                }
                catch (Exception $e) {
                    $this->info($e->getMessage());
                }

            }

        }


            Mail::raw("teste", function ($mail)  {
                $mail->from('digamber@positronx.com');
                $mail->to('joaquim.soares@tagydes.com')
                ->subject('Daily New Quote!');
            });

            $this->info('Successfully sent daily quote to everyone.');
        }
    }
