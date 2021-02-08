<?php

namespace App\Console\Commands;

use App\Subscription;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Repositories\AnalyticRepositoryInterface;

class SyncAzureBudget extends Command
{


    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'SyncAzureBudget:daily';

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
    public function __construct(AnalyticRepositoryInterface $analyticRepository)
    {
        parent::__construct();
        $this->analyticRepository = $analyticRepository;

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
            $msId = $subscription->customer->microsoftTenantInfo->first()->tenant_id;
            $details = $this->analyticRepository->UpdateAZURE($msId, $subscription);
            Log::info('Budget updatedfor: '. $details->subscription_id);
        }

    }
}

