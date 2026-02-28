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
// AzureResource API removed — Tagydes\MicrosoftConnection no longer available.

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
        // AzureResource unbilled API not yet implemented in MicrosoftCspConnection module.
        Log::warning('AzureUnbilledCommand::handle() — AzureResource unbilled API not yet implemented. Command is a no-op.');
        $this->warn('Azure unbilled sync is not available in this version. Skipping.');
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
