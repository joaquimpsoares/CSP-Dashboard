<?php

namespace App\Http\Controllers\Web;

use App\Price;
use Exception;
use App\PriceList;
use Illuminate\Http\Request;
use App\Imports\PricesImport;
use App\Http\Traits\UserTrait;
use App\Http\Controllers\Controller;
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
        $priceLists = $this->priceListRepository->all();    

        $prices = Price::get();
        
        // foreach($priceLists as $pricelist);{
        // $result = PriceList::where('id', $pricelist )->with('prices')->get();
        // // dump($result);
        // }
        // foreach($result as $price){
        // $prices = $price->prices->map->format();
        // dump($prices);
        // }
        
        return view('priceList.index', compact('priceLists', 'prices'));
    }
    
    public function getPrices($priceList)
    {
        // $priceList = PriceList::where('id', $priceList)->first();
        
        $priceList = PriceList::where('id', $priceList)->with('prices')->first();
        
        $prices = $priceList->prices->map->format();
        
        return view('priceList.prices', compact('prices','priceList'));
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
            // dd($request->select_file);
            Excel::import(new PricesImport, request()->file('select_file'));
            
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
                
                return redirect()->back()->with(['alert' => 'success', 'message' => trans('messages.customer_updated_successfully')]);
            // return back()->with('success', 'Excel Data Imported successfully');
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
