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
// AzureResource API removed — Tagydes\MicrosoftConnection no longer available.

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
        // AzureResource billed reconciliation API not yet implemented in MicrosoftCspConnection module.
        Log::warning('AzureBilledCommand::handle() — AzureResource invoicerecon API not yet implemented. Command is a no-op.');
        $this->warn('Azure billed reconciliation sync is not available in this version. Skipping.');
        return 0;
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
