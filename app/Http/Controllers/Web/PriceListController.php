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
        
        // dd($user->reseller);
        $instance = $user->reseller->provider->instances->first()->id;

        // dd($instance);
        

        
        $products = $instance->products;
        
        $priceList = PriceList::where('id', $priceList)->with('prices')->first();
        // dd($priceList->prices);
        // $prices = Price::where()
        
        $prices = $priceList->prices;
        // dd($prices   );
        // dd($prices);
        
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
            //dd($request->all());
            
            
            $pricelist = PriceList::find($request->priceList);
            // dd($pricelist);
            // $product = Product::where('sku', $request->product_sku)->first();
            $user = $this->getUser();

            $instance = $user->reseller->provider->instances->first()->id;
        
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
                'price_list_id' => '2 - Default - Provider CBI'
            ]);


            $order = new Price();

            // dd($product);
            // $order->product_sku     = $request->product_sku;
            $order->name            = $product->name;
            $order->price           = $request->price;
            $order->msrp            = $request->msrp;
            $order->product_vendor  = $request->product_vendor;
            $order->currency        = $request->currency;
            $order->price_list_id   = $request->price_list_id;

            $order->product()->ciate($product);

            $order->pricelist()->associate($pricelist);
            $order->save();

            return back()->with('success', 'Excel Data Imported successfully');

            // $show = Price::create($validatedData);
       
            // return redirect('')->with('success', 'Corona Case is successfully saved');
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
