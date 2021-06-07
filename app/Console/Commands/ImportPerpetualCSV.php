<?php

namespace App\Console\Commands;

use Exception;
use App\Product;
use App\Instance;
use App\PriceList;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Spatie\SimpleExcel\SimpleExcelReader;
use Tagydes\MicrosoftConnection\Facades\Product as MicrosoftProduct;


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
        try {
            Instance::eachById(function (Instance $instance) {

                $products = MicrosoftProduct::withCredentials($instance->external_id, $instance->external_token)
                    ->forCountry($instance->provider->country->iso_3166_2)->softwarePrepetualAll($instance->provider->country->iso_3166_2);

                $products->each(function ($importedProduct) use ($instance) {
                    $product = Product::updateOrCreate([
                        'sku'                       => $importedProduct[0]->productId,
                        'instance_id'               => $instance->id,
                        'billing'                   => "software",
                        'addons'                    => "[]",
                        'category'                  => "Perpetual Software",
                    ], [
                        'name'                      => $importedProduct[0]->title,
                        'description'               => $importedProduct[0]->description,
                        'uri'                       => $importedProduct[0]->uri,
                        'minimum_quantity'          => $importedProduct[0]->minimumQuantity,
                        'maximum_quantity'          => $importedProduct[0]->maximumQuantity,
                        'is_trial'                  => $importedProduct[0]->isTrial,
                        'limit'                     => $importedProduct[0]->limit,
                        'term'                      => $importedProduct[0]->term,
                        'locale'                    => $importedProduct[0]->locale,
                        'supported_billing_cycles'  => $importedProduct[0]->supportedBillingCycles,
                        'is_perpetual' => true
                    ]);

                    SimpleExcelReader::create(storage_path('app'.DIRECTORY_SEPARATOR.'perpetual.xlsx'))->getRows()->each(function (array $license) use ($product) {
                        $priceList = PriceList::first();

                        $product->price()->updateOrCreate([
                            'product_vendor' => 'microsoft',
                            'product_sku' => $product->sku,
                            'price_list_id' => $priceList->id,
                        ], [
                            'name' => $license['SkuTitle'],
                            'price' => $license['ListPrice'],
                            'msrp' => $license['Msrp'],
                            'currency' => $license['Currency'],
                            'instance_id' => $product->instance_id,
                        ]);
                    });
                });
            });
        } catch (Exception $e) {
            echo ('Error importing products: ' . $e->getMessage());
        }
    }
}
