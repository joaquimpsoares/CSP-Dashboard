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
// AzureResource API removed — Tagydes\MicrosoftConnection no longer available.

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
        // AzureResource utilization API not yet implemented in MicrosoftCspConnection module.
        Log::warning('SyncAzure::handle() — AzureResource utilization API not yet implemented. Command is a no-op.');
        $this->warn('Azure usage sync is not available in this version. Skipping.');
        return 0;
    }
}
