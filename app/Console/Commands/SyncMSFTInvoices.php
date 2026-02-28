<?php

namespace App\Console\Commands;

use Exception;
use App\Instance;
use App\Models\MsftInvoices;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
// MSFTInvoice API removed — Tagydes\MicrosoftConnection no longer available.


class SyncMSFTInvoices extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'command:SyncMSFTInvoices';

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
        // MSFTInvoice API not yet implemented in MicrosoftCspConnection module.
        \Illuminate\Support\Facades\Log::warning('SyncMSFTInvoices::handle() — MSFTInvoice API not yet implemented. Command is a no-op.');
        $this->warn('MSFT invoice sync is not available in this version. Skipping.');
        return 0;
    }
}
