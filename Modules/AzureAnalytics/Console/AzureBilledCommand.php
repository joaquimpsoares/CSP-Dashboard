<?php

namespace Modules\AzureAnalytics\Console;

use App\MicrosoftTenantInfo;
use App\Models\MsftInvoices;
use App\Http\Traits\Expirable;
use Illuminate\Console\Command;
use App\Models\AzureUsageReport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Tagydes\MicrosoftConnection\Facades\AzureResource as FacadesAzureResource;

class AzureBilledCommand extends Command
{
    use Expirable;

    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'command:billed';

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
        // Mail::raw("Starting Azure Syncronization", function ($mail)  {
        //     $mail->to('joaquim.soares@tagydes.com')
        //     ->subject('Daily importing Started Azure reports');
        // });

        MsftInvoices::eachById(function (MsftInvoices $invoice) {
            if(substr($invoice->invoice_id,0,3) === "D05"){
                    try {
                        $resources = FacadesAzureResource::withCredentials($invoice->instance->external_id,$invoice->instance->external_token)
                        ->invoicerecon($invoice->provider->country->currency_code,$invoice->invoice_id);
                        Log::channel('azure')->info($invoice->invoice_id);
                    $this->info('Updating Invoice ID '.$invoice->invoice_id);
                    } catch (\Throwable $th) {
                        $this->info('error updating Invoice ID '.$th->getMessage());
                        // Mail::raw($th->getMessage(), function ($mail) use($th) {
                        //     $mail->to('joaquim.soares@tagydes.com')
                        //     ->subject('Failed importing');
                        // });
                    }
                    $Count = 0;

                    if($resources){
                        foreach ($resources as $key => $value) {
                            foreach ($value as $key => $value) {
                                // dd($value);
                                $tenant = MicrosoftTenantInfo::where('tenant_id', $value['customerId'])->first();
                                if(isset($tenant->customer)){
                                    $tenant->customer->subscriptions->where('billing_type', 'usage')->each(function ($subscription) use($value,$Count) {
                                        try{
                                            $Count++;
                                            $resource = AzureUsageReport::updateOrCreate([
                                                'subscription_id'       => $subscription->id,
                                                'unitPrice'             => $value['listPrice'],
                                                'resource_id'           => $value['resourceGuid'],
                                                'name'                  => $value['serviceName'],
                                                'resource_name'         => $value['resourceName'],
                                                // 'resource_group'        => $value['resourceGroup'],
                                                // 'resource_location'     => $value['region'],
                                                'resource_region'       => $value['region'],
                                                // 'resource_category'     => $value['meterCategory'],
                                                'usageStartTime'        => $value['chargeStartDate'],
                                                'usageEndTime'          => $value['chargeEndDate'],
                                                // 'resource_subcategory'  => $value['meterSubCategory'],
                                            ], [
                                                'usagedate'             => $value['chargeStartDate'],
                                                'quantity'              => $value['consumedQuantity'],
                                                'unit'                  => $value['unit'],
                                                'cost'                  => $value['postTaxTotal'],
                                                // 'resourceType'          => $value['meterType'],
                                                // 'tags'                  => $value['tags'],
                                                // 'additionalinfo'        => $value['additionalInfo'],
                                            ]);
                                            $this->info('updating '.$resource->resource_name . ''. $resource->usagedate );
                                            Log::channel('azure')->info('updated '.$resource->resource_name);
                                        }
                                        catch (\Exception $e) {
                                            Log::channel('azure')->info($e->getMessage());
                                            // Mail::raw($e->getMessage(), function ($mail) use($e) {
                                            //     $mail->to('joaquim.soares@tagydes.com')
                                            //     ->subject('Azure Sync Failed');
                                            // });
                                        }
                                    });
                                }
                            }
                        }
                    }
                }
            });

            // Mail::raw("Just finished Azure Syncronization", function ($mail)  {
            //     $mail->to('joaquim.soares@tagydes.com')
            //     ->subject('Daily imported Azure reports');
            // });

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
