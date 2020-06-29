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
    
    private $priceListRepository;
    
    public function __construct(PriceListRepositoryInterface $priceListRepository)
    {
        $this->priceListRepository = $priceListRepository;
    }
    
    public function index()
    {

        $products = Product::get();
        $priceLists = $this->priceListRepository->all();    
        // dd($products);
        $prices = Price::get();
        
        // foreach($priceLists as $pricelist);{
        // $result = PriceList::where('id', $pricelist )->with('prices')->get();
        // // dump($result);
        // }
        // foreach($result as $price){
        // $prices = $price->prices->map->format();
        // dump($prices);
        // }
        
        return view('priceList.index', compact('priceLists', 'prices', 'products'));
    }

    
    public function getPrices($priceList)
    {

        $user = $this->getUser();
        $prices = $this->priceListRepository->listPrices();
        $priceList = $user->reseller->priceList;
        $products = Product::where('instance_id', $priceList->instance_id)->get();

        return view('priceList.prices', compact('prices','priceList', 'products'));
    }

    public function update(Request $request, $priceList)
    {

        // dd($priceList);
        $priceList = PriceList::find($priceList);

        // dd($customer);
        
        $updatepriceList = $priceList->update([
            'name' => $request['name'],
            'description' => $request['description'],
            
        ]);

        return redirect()->back()->with(['alert' => 'success', 'message' => trans('messages.pricelist_updated_successfully')]);
        }

        public function import(Request $request )
        {


            $data = Excel::import(new PricesImport, request()->file('select_file'));
            // dd($data);

            return back()->withInput(['tab'=>'contact-md']);
            // dd($request->select_file);
            // Excel::import(new PricesImport, request()->file('select_file'));
            
        //     try {
           
        // return back();
        //             // dd($request);

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
            // dd($request->all());
            
            
            $pricelist = PriceList::find($request->priceList);

            $price = Price::where('price_list_id', $pricelist->id)->get()->map->format();

            // dd($price);
            // $product = Product::where('sku', $request->product_sku)->first();
            $user = $this->getUser();


            $instance = $user->reseller->provider->instances->first()->id;
            // dd($instance);
        
            $product = Product::where('sku', $request->product_sku)->where('instance_id', $instance)->first();
            // dd($product);

            // $user->account()->ciate($account);

            // $user->save();

            $validatedData = $request->validate([
                'product_sku' => 'required|max:255',
                'price' => 'required',
                'msrp' => 'required|numeric',
                'product_vendor' => 'required',
                'currency' => 'required',
                ]);


                // dd($validatedData['price']);
            $price = new Price();

            // $price->product_sku     = $validatedData['product_sku'];
            $price->name            = $product->name;
            $price->price           = $validatedData['price'];
            $price->msrp            = $validatedData['msrp'];
            $price->product_vendor  = $validatedData['product_vendor'];
            $price->currency        = $validatedData['currency'];
            $price->instance_id     = $pricelist->instance_id;
            $price->price_list_id   = $request->price_list_id;

            $price->product()->associate($product);
            
            
            $price->pricelist()->associate($pricelist);
            // dd($price);
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
        
        dd('reseller');
    }
    
    public function getCustomerPriceList(Request $request, Customer $customer)
    {
        $userLevel = $this->getUserLevel();
        
        dd('Customer');
    }*/
}
