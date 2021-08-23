<?php

namespace App\Console\Commands;

use App\Subscription;
use Illuminate\Console\Command;

class SubscriptionRenovation extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'subscription:renovation';

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
        $subscriptions = Subscription::get();

        $subscriptions = Subscription::expiring()->get();
        dd($subscriptions->onlyExpired());
        foreach($subscriptions as $subscription){
            if ($subscription->expiration_data == now()){
            }
        }
    }
}
