<?php

namespace App\Console\Commands;

use App\User;
use Exception;
use App\Customer;
use App\Instance;
use Carbon\Carbon;
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

ini_set('memory_limit', '-1');

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
        // Mail::raw("Starting Azure Syncronization", function ($mail)  {
        //     $mail->to('joaquim.soares@tagydes.com')
        //     ->subject('Daily importing Started Azure reports');
        // });


        $subscriptions = Subscription::where('billing_type', 'usage')->get();

        Log::channel('azure')->info('Preparing import for current subscription ' .$subscriptions->count() );

        foreach($subscriptions as $subscription){

            // if($subscription->product_id == 'MS-AZR-0145P'){
                $instance = Instance::where('id', $subscription->instance_id)->first();
                $msId = $subscription->customer->microsoftTenantInfo->first()->tenant_id;
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

                $resources = FacadesAzureResource::withCredentials($instance->external_id,$instance->external_token)
                ->utilizations($customer, $subscriptions);

                try{
                    $resources->each(function($resource) use($subscription){
                        $resource = collect($resource);
                        // $resource = $resource->groupBy(['usageStartTime', 'resource','id']);

                        // $resource = $resource->groupBy(function ($item, $key) {
                        //     return [
                        //         date('m/Y', strtotime($item['usageStartTime'])),
                        //         // $item['resource']['id']
                        // ];
                        // })->map(function($resource){
                        //     return $resource->sum('quantity');
                        // });



                        // $resource = $resource->groupBy(['usageStartTime', function ($item) {
                        //     return $item['resource']['id'];
                        // }], $preserveKeys = true);
                        // $resource = $resource->map(function($resource){
                        //     $resource = $resource->map(function($resource){
                        //         $resource = collect($resource);
                        //         return $resource[0]['quantity']->sum();
                        //     });
                        // });
                        $resource->each(function($resource) use($subscription){
                            // $resource->each(function($resource) use($subscription){
                            //     $resource = collect($resource);
                            //     dd($resource);
                            // });

                        $resourceGroup = Str::of($resource['instanceData']['resourceUri'])->explode('/');
                        $price = AzurePriceList::where('resource_id', $resource['resource']['id'])->first();
                        if(!isset($price)){
                            $price = AzurePriceList::updateOrCreate(
                                ['resource_id'   => $resource['resource']['id']],
                                ['rates' => [0]]);
                                Log::channel('azure')->info('Price updated for resource ' .$resource['resource']['id']);
                            }

                            $resource = AzureUsageReport::updateOrCreate([
                                'subscription_id'       => $subscription['id'],
                                'resource_name'         => $resource['resource']['name'],
                                'resource_id'           => $resource['resource']['id'],
                                'resource_group'        => $resourceGroup[4],
                            ], [
                                'usageStartTime'        => $resource['usageStartTime'],
                                'usageEndTime'          => $resource['usageEndTime'],
                                'usagedate'             => $resource['usageStartTime'],
                                'resource_location'     => $resource['instanceData']['location'],
                                'resource_category'     => $resource['resource']['category'],
                                'resource_subcategory'  => $resource['resource']['subcategory'],
                                'resource_region'       => $resource['resource']['region'],
                                'unit'                  => $resource['unit'],
                                'name'                  => $resourceGroup[8] ?? null,
                                "resourceType"          => $resource['instanceData']['additionalInfo']['resourceType'] ?? null,
                                "usageResourceKind"     => $resource['instanceData']['additionalInfo']['usageResourceKind'] ?? null,
                                "dataCenter"            => $resource['instanceData']['additionalInfo']['dataCenter'] ?? null,
                                "networkBucket"         => $resource['instanceData']['additionalInfo']['networkBucket'] ?? null,
                                "pipelineType"          => $resource['instanceData']['additionalInfo']['pipelineType'] ?? null,
                                'quantity'              => $resource['quantity'],
                            ]);
                            $price1 = AzurePriceList::where('resource_id', $resource['resource_id'])->first();
                            $price = $resource['quantity']*$price1->rates[0];
                            $resource->update(['cost' => $price]);

                            Log::channel('azure')->info('price '.$price1->rates[0]. ' This quantity '. $resource['quantity'] . ' total ->  ' . $price );
                            Log::channel('azure')->info('updated '.$resource['resource_name']. ' With price '. $price);
                        });
                    });
                    }
                    catch (\Exception $e) {
                        Log::channel('azure')->info($e->getMessage());
                        // Mail::raw($e, function ($mail) use($e) {
                        //     $mail->to('joaquim.soares@tagydes.com')
                        //     ->subject('Azure Sync Failed');
                        // });
                    }
                }
            // }

            // Mail::raw("Just finished Azure Syncronization", function ($mail)  {
            //     $mail->to('joaquim.soares@tagydes.com')
            //     ->subject('Daily imported Azure reports');
            // });

            $this->info('Successfully sent daily quote to everyone.');
        }
    }
