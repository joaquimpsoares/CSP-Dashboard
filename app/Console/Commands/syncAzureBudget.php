<?php

namespace App\Console\Commands;

use App\Subscription;
use Illuminate\Console\Command;
use App\Repositories\AnalyticRepositoryInterface;

class syncAzureBudget extends Command
{

    public function __construct(
        AnalyticRepositoryInterface $analyticRepository
        ) {
            $this->analyticRepository = $analyticRepository;
        }

        /**
        * The name and signature of the console command.
        *
        * @var string
        */
        protected $signature = 'syncAzureBudget:daily';

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
            $subscriptions = Subscription::where('billing_type', 'usage')->get();


            foreach($subscriptions as $subscription){
                $msId = $subscription->customer->microsoftTenantInfo->first()->tenant_id;
                $details = $this->analyticRepository->UpdateAZURE($msId, $subscription);

                // dd($details);

            }
        }
    }
