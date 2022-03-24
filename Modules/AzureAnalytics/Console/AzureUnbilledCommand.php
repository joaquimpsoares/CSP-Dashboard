<?php

namespace Modules\AzureAnalytics\Console;

use App\Instance;
use App\MicrosoftTenantInfo;
use App\Subscription;
use Illuminate\Console\Command;
use App\Models\AzureUsageReport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Tagydes\MicrosoftConnection\Facades\AzureResource as FacadesAzureResource;

class AzureUnbilledCommand extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'command:unbilled';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Command description.';

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
    * @return mixed
    */
    public function handle()
    {
        Mail::raw("Starting Azure Syncronization", function ($mail)  {
            $mail->to('joaquim.soares@tagydes.com')
            ->subject('Daily importing Started Azure reports');
        });

        $instances = Instance::where('id', 2)->get();
        $subscriptions = Subscription::where('billing_type', 'usage')->get();
        $instances->each(function ($instance) {
            $resources = FacadesAzureResource::withCredentials($instance->external_id,$instance->external_token)->invoiceunbilled($instance->provider->country->currency_code);
            foreach ($resources as $key => $value) {
                foreach ($value as $key => $value) {
                    $tenant = MicrosoftTenantInfo::where('tenant_id', $value['customerId'])->first();
                    if(isset($tenant->customer)){
                        $tenant->customer->subscriptions->where('billing_type', 'usage')->each(function ($subscription) use($value) {
                            try{
                                    $resource = AzureUsageReport::updateOrCreate([
                                        'subscription_id'       => $subscription->id,
                                        'resource_name'         => $value['productName'],
                                        'resource_id'           => $value['productId'],
                                        'resource_group'        => $value['resourceGroup'],
                                    ], [
                                        'usageStartTime'        => $value['chargeStartDate'],
                                        'usageEndTime'          => $value['chargeEndDate'],
                                        'resource_location'     => $value['resourceLocation'],
                                        'resource_region'       => $value['meterRegion'],
                                        'resource_category'     => $value['meterCategory'],
                                        'resource_subcategory'  => $value['meterSubCategory'],
                                        'quantity'              => $value['quantity'],
                                        'unit'                  => $value['unitOfMeasure'],
                                        'name'                  => $value['productName'],
                                        'cost'                  => $value['billingPreTaxTotal'],
                                        "resourceType"          => $value['meterType'],
                                    ]);


                                    // Log::channel('azure')->info('price '.$price1->rates[0]. ' This quantity '. $value->quantity . ' total ->  ' . $price );
                                    // Log::channel('azure')->info('updated '.$resource->resource_name. ' With price '. $price);
                            }
                            catch (\Exception $e) {
                                Log::channel('azure')->info($e->getMessage());
                                // Mail::raw($e, function ($mail) use($e) {
                                //     $mail->to('joaquim.soares@tagydes.com')
                                //     ->subject('Azure Sync Failed');
                                // });
                            }

                        });
                    }
                }
            }

        });

        Mail::raw("Just finished Azure Syncronization", function ($mail)  {
            $mail->to('joaquim.soares@tagydes.com')
            ->subject('Daily imported Azure reports');
        });

        $this->info('Successfully sent daily quote to everyone.');
    }

    /**
    * Get the console command arguments.
    *
    * @return array
    */
    protected function getArguments()
    {
        return [
            ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
    * Get the console command options.
    *
    * @return array
    */
    protected function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
