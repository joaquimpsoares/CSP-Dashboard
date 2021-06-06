<?php

namespace App\Http\Controllers\Web;

use Exception;
use App\Product;
use App\Instance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Msft_invoices;
use Illuminate\Support\Facades\DB;
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

            // try {
            //     Instance::eachById(function (Instance $instance) {
            //         $instance = Instance::where('id','2')->first();
            //         $invoices = MicrosoftInvoice::withCredentials($instance->external_id, $instance->external_token)->all();
            //         // dd($invoices);
            //         $invoices->each(function ($invoices) use ($instance) {
            //             $product = Msft_invoices::updateOrCreate([
            //                 'provider_id'               => $instance->provider_id,
            //                 'invoice_id'                => $invoices->invoice_id,
            //                 'invoiceDate'               => $invoices->invoiceDate,
            //                 'billingPeriodStartDate'    => $invoices->billingPeriodStartDate,
            //                 'billingPeriodEndDate'      => $invoices->billingPeriodEndDate,
            //                 'totalCharges'              => $invoices->totalCharges,
            //             ], [
            //                 'instance_id'               => $instance->id,
            //                 'paidAmount'                => $invoices->paidAmount,
            //                 'currencyCode'              => $invoices->currencyCode,
            //                 'currencySymbol'            => $invoices->currencySymbol,
            //                 'pdfDownloadLink'           => $invoices->pdfDownloadLink,
            //                 'invoiceDetails'            => $invoices->invoiceLineItemType,
            //                 ]);
            //             });
            //         });

            //     } catch (Exception $e) {
            //         echo ('Error importing products: ' . $e->getMessage());
            // }

                $invoices = Msft_invoices::paginate(10);

                $sales = DB::table('msft_invoices')
                ->whereyear('invoiceDate', Carbon::today()->year)
                ->select(DB::raw("MONTHNAME(invoiceDate) as date"), DB::raw('totalCharges as total'))
                ->groupBy(DB::raw("MONTHNAME(invoiceDate)"))
                ->orderBy('invoiceDate', 'asc')
                ->get();

                // dd($sales);

                 foreach($sales as $row) {
                    $customerlabel['label'][] = json_encode($row->date);
                    $customerdata['data'][] = (int) $row->total;
                  }

                  $customerlabel = json_encode($customerlabel['label']);
                  $customerdata  = json_encode($customerdata['data']);
                // dd($invoices->first()->provider);
                return view('msft/index', compact('invoices','customerlabel','customerdata'));

            }

            public function downloadInvoice()
            {

                try {
                    Instance::eachById(function (Instance $instance) {
                        $instance = Instance::where('id','2')->first();
                        $products = MicrosoftInvoice::withCredentials($instance->external_id, $instance->external_token)->downloadInvoice('/invoices/D0500036HO/documents/statement');
                        // dd($products);
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
