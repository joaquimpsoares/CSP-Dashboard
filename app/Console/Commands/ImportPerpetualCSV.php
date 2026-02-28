<?php

namespace App\Console\Commands;

use Exception;
use App\Product;
use App\Instance;
use App\PriceList;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Spatie\SimpleExcel\SimpleExcelReader;
// MicrosoftProduct API removed — perpetual import now handled by ImportPerpetuaMicrosoftJob.


class ImportPerpetualCSV extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'perpetual:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Loads the CSV perpetual.xlsx located at storage/app folder that includes Microsoft perpetual licenses and load them to the database as metafields';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (!Storage::exists('perpetual.xlsx')) {
            $this->error('perpetual.xlsx doesnt exists on storage/app folder');
            return;
        }
        // softwarePerpetualAll() API removed — perpetual products are now imported via ImportPerpetuaMicrosoftJob.
        \Illuminate\Support\Facades\Log::warning('ImportPerpetualCSV::handle() — softwarePerpetualAll API no longer available; use ImportPerpetuaMicrosoftJob instead.');
        $this->warn('Perpetual product import via old API is not available. Use the ImportPerpetuaMicrosoftJob queue job instead.');
        return 0;
    }
}
