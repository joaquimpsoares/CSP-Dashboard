<?php

namespace App\Http\Controllers\Web;

use Exception;
use App\Instance;
use Illuminate\Http\Request;
use App\Models\msft_invoices;
use Tagydes\MicrosoftConnection\Facades\MSFTInvoice as MicrosoftInvoice;


class MsftInvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        try {
            Instance::eachById(function (Instance $instance) {
                $instance = Instance::where('id','2')->first();
                $products = MicrosoftInvoice::withCredentials($instance->external_id, $instance->external_token)->all();
dd($products);
                // $products->each(function ($importedProduct) use ($instance) {
                //     $product = Product::updateOrCreate([
                //         'sku'                       => $importedProduct[0]->productId,
                //         'instance_id'               => $instance->id,
                //         'billing'                   => "software",
                //         'addons'                    => "[]",
                //         'category'                  => "Perpetual Software",
                //     ], [
                //         'name'                      => $importedProduct[0]->title,
                //         'description'               => $importedProduct[0]->description,
                //         'uri'                       => $importedProduct[0]->uri,
                //         'minimum_quantity'          => $importedProduct[0]->minimumQuantity,
                //         'maximum_quantity'          => $importedProduct[0]->maximumQuantity,
                //         'is_trial'                  => $importedProduct[0]->isTrial,
                //         'limit'                     => $importedProduct[0]->limit,
                //         'term'                      => $importedProduct[0]->term,
                //         'locale'                    => $importedProduct[0]->locale,
                //         'supported_billing_cycles'  => $importedProduct[0]->supportedBillingCycles,
                //         'is_perpetual' => true
                //     ]);

                    // SimpleExcelReader::create(storage_path('app'.DIRECTORY_SEPARATOR.'perpetual.xlsx'))->getRows()->each(function (array $license) use ($product) {
                    //     $priceList = PriceList::first();

                    //     $product->price()->updateOrCreate([
                    //         'product_vendor' => 'microsoft',
                    //         'product_sku' => $product->sku,
                    //         'price_list_id' => $priceList->id,
                    //     ], [
                    //         'name' => $license['SkuTitle'],
                    //         'price' => $license['ListPrice'],
                    //         'msrp' => $license['Msrp'],
                    //         'currency' => $license['Currency'],
                    //         'instance_id' => $product->instance_id,
                    //     ]);
                    // });
            //     });
            });
        } catch (Exception $e) {
            echo ('Error importing products: ' . $e->getMessage());
        }
    }

    public function downloadInvoice()
    {

        try {
            Instance::eachById(function (Instance $instance) {
                $instance = Instance::where('id','2')->first();
                $products = MicrosoftInvoice::withCredentials($instance->external_id, $instance->external_token)->downloadInvoice('/invoices/D0500036HO/documents/statement');
dd($products);
                // $products->each(function ($importedProduct) use ($instance) {
                //     $product = Product::updateOrCreate([
                //         'sku'                       => $importedProduct[0]->productId,
                //         'instance_id'               => $instance->id,
                //         'billing'                   => "software",
                //         'addons'                    => "[]",
                //         'category'                  => "Perpetual Software",
                //     ], [
                //         'name'                      => $importedProduct[0]->title,
                //         'description'               => $importedProduct[0]->description,
                //         'uri'                       => $importedProduct[0]->uri,
                //         'minimum_quantity'          => $importedProduct[0]->minimumQuantity,
                //         'maximum_quantity'          => $importedProduct[0]->maximumQuantity,
                //         'is_trial'                  => $importedProduct[0]->isTrial,
                //         'limit'                     => $importedProduct[0]->limit,
                //         'term'                      => $importedProduct[0]->term,
                //         'locale'                    => $importedProduct[0]->locale,
                //         'supported_billing_cycles'  => $importedProduct[0]->supportedBillingCycles,
                //         'is_perpetual' => true
                //     ]);

                    // SimpleExcelReader::create(storage_path('app'.DIRECTORY_SEPARATOR.'perpetual.xlsx'))->getRows()->each(function (array $license) use ($product) {
                    //     $priceList = PriceList::first();

                    //     $product->price()->updateOrCreate([
                    //         'product_vendor' => 'microsoft',
                    //         'product_sku' => $product->sku,
                    //         'price_list_id' => $priceList->id,
                    //     ], [
                    //         'name' => $license['SkuTitle'],
                    //         'price' => $license['ListPrice'],
                    //         'msrp' => $license['Msrp'],
                    //         'currency' => $license['Currency'],
                    //         'instance_id' => $product->instance_id,
                    //     ]);
                    // });
            //     });
            });
        } catch (Exception $e) {
            echo ('Error importing products: ' . $e->getMessage());
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\msft_invoices  $msft_invoices
     * @return \Illuminate\Http\Response
     */
    public function show(msft_invoices $msft_invoices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\msft_invoices  $msft_invoices
     * @return \Illuminate\Http\Response
     */
    public function edit(msft_invoices $msft_invoices)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\msft_invoices  $msft_invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, msft_invoices $msft_invoices)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\msft_invoices  $msft_invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(msft_invoices $msft_invoices)
    {
        //
    }
}
