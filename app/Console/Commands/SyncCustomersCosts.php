<?php

namespace App\Console\Commands;

use Exception;
use App\Customer;
use App\Instance;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
// Customer service-costs API removed — Tagydes\MicrosoftConnection no longer available.

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
        // Service costs API not yet implemented in MicrosoftCspConnection module.
        \Illuminate\Support\Facades\Log::warning('SyncCustomersCosts::handle() — service costs API not yet implemented. Command is a no-op.');
        $this->warn('Customer service costs sync is not available in this version. Skipping.');
        return 0;
    }
}
