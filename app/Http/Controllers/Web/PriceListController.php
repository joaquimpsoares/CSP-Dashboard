<?php

namespace App\Http\Controllers\Web;

use App\Price;
use Exception;
use App\PriceList;
use Illuminate\Http\Request;
use App\Imports\PricesImport;
use App\Http\Traits\UserTrait;
use App\Http\Controllers\Controller;
use App\Product;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\PriceListRepositoryInterface;

class PriceListController extends Controller
{
    use UserTrait;
    public $priceList;

    private $priceListRepository;

    public function __construct(PriceListRepositoryInterface $priceListRepository)
    {
        $this->priceListRepository = $priceListRepository;
    }

    public function index()
    {

        $products = Product::get();
        $priceLists = $this->priceListRepository->all();
        $prices = Price::get();


        return view('priceList.index', compact('priceLists', 'prices', 'products'));
    }

    public function create()
    {

        $products = Product::get();
        $priceLists = $this->priceListRepository->all();
        $prices = Price::get();

        return view('priceList.create', compact('priceLists', 'prices', 'products'));
    }

    public function getPrices($priceList)
    {
        $user = $this->getUser();

        switch ($this->getUserLevel()) {
            case config('app.super_admin'):

                $prices = $this->priceListRepository->listPrices();

                $priceList = PriceList::where('id', $priceList)->first();
                $provider = $priceList->provider;

                $products = Product::where('instance_id', $priceList->instance_id)->whereNotIn('sku',$prices->pluck('product_sku'))->get();

                $prices = $priceList->prices;

            break;

            case config('app.provider'):

                $prices = $this->priceListRepository->listPrices();

                $provider = $user->provider;
                $priceList = $provider->priceList;
                $products = Product::where('instance_id', $priceList->instance_id)->whereNotIn('sku',$prices->pluck('product_sku'))->get();
                $prices = $priceList->prices;

            break;

            case config('app.reseller'):

                $priceList = PriceList::where('id', $priceList)->first();

                $prices = $priceList->prices;
                $products = Product::where('instance_id', $priceList->instance_id)->whereNotIn('sku',$prices->pluck('product_sku'))->get();

            break;
        }

        // $user = $this->getUser();


        return view('priceList.prices', compact('prices','priceList', 'products'));
    }

    public function update(Request $request, $priceList)
    {

        $priceList = PriceList::find($priceList);


        $updatepriceList = $priceList->update([
            'name' => $request['name'],
            'description' => $request['description'],

            ]);

            return redirect()->back()->with(['alert' => 'success', 'message' => trans('messages.pricelist_updated_successfully')]);
        }

        public function storePriceList(Request $request)
        {
            // $priceList = PriceList::find($priceList);


            // $updatepriceList = $priceList->update([
                //     'name' => $request['name'],
                //     'description' => $request['description'],

                // ]);

                return redirect()->back()->with(['alert' => 'success', 'message' => trans('messages.pricelist_updated_successfully')]);
            }

            public function import(Request $request )
            {


                $data = Excel::import(new PricesImport, request()->file('select_file'));

                return back()->withInput(['tab'=>'contact-md']);
                // Excel::import(new PricesImport, request()->file('select_file'));

                //     try {

                    // return back();

                    //     } catch (\Exception $e) {

                        //             $errorMessage = "message.error";
                        //             redirect()->back
                        //             ->with([
                            //             'alert' => 'danger',
                            //             'message' => trans('messages.customer_not_created') . " (" . trans($errorMessage) . ")."
                            //             ]);
                            //         }

                            // return redirect()->back()->with(['alert' => 'success', 'message' => trans('messages.customer_updated_successfully')]);
                            // return back()->with('success', 'Excel Data Imported successfully');
                        }

                        public function store(Request $request)
                        {

                            $pricelist = PriceList::find($request->priceList);

                            // $price = Price::where('price_list_id', $pricelist->id)->get()->map->format();

                            $product = Product::where('sku', $request->sku)->where('instance_id', $pricelist->instance_id)->first();

                            $validatedData = $request->validate([
                                'sku' => 'required|max:255',
                                'price' => 'required',
                                'msrp' => 'required|numeric',
                                'product_vendor' => 'required',
                                'currency' => 'required',
                                ]);


                                $price = new Price();
                                $price->name            = $product->name;
                                $price->price           = $validatedData['price'];
                                $price->msrp            = $validatedData['msrp'];
                                $price->product_vendor  = $validatedData['product_vendor'];
                                $price->currency        = $validatedData['currency'];
                                $price->instance_id     = $pricelist->instance_id;
                                $price->price_list_id   = $request->price_list_id;


                                $price->product()->associate($product);

                                $price->pricelist()->associate($pricelist);

                                $price->save();

                                return back()->with('success', 'Excel Data Imported successfully');

                            }


                            public function clone($id)
                            {


                                $pricelist = PriceList::find($id);

                                $newClient = $pricelist->replicate();
                                $newClient->push(); //Push before to get id of $clone

                                foreach($pricelist->prices as $price)
                                {
                                    $newClient->prices()->attach($price);

                                }

                                // $newpricelist = $pricelist->replicate();
                                // // $newpricelist->id = $new_id;
                                // // $newpricelist->data = $new_data;
                                $newClient->save();

                                return view('priceList.index', compact('prices'));
                            }


                            /*public function getResellerPriceList(Request $request, Reseller $reseller)
                            {
                                $userLevel = $this->getUserLevel();

                            }

                            public function getCustomerPriceList(Request $request, Customer $customer)
                            {
                                $userLevel = $this->getUserLevel();

                            }*/
                        }
