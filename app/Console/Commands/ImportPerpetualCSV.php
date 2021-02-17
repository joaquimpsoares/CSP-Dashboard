<?php

namespace App\Console\Commands;

use App\Instance;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Spatie\SimpleExcel\SimpleExcelReader;
use App\Product;

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
        if(! Storage::exists('perpetual.xlsx')){
            $this->error('perpetual.xlsx doesnt exists on storage/app folder');
            return;
        }

        SimpleExcelReader::create(storage_path('app/perpetual.xlsx'))->getRows()->each(function(array $license){
            Instance::eachById(function(Instance $instance)use($license){
                $product = Product::updateOrCreate([
                    'vendor' => 'microsoft',
                    'is_perpetual' => true,
                    'instance_id' => $instance->id,
                    'country' => $license['region']
                ]);

                $product->prices()->updateOrCreate([
                    'product_vendor' => '',
                    'price_list_id' => '',
                    'name' => '',
                    'price' => '',
                    'msrp' => '',
                    'currency' => ''
                ]);
            });
        });

        return 0;
    }
}
