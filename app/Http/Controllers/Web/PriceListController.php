<?php

namespace App\Http\Controllers\Web;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Http\Traits\UserTrait;
use App\Price;
use App\PriceList;
use App\Provider;
use App\Repositories\PriceListRepositoryInterface;
use App\Reseller;
use Illuminate\Http\Request;

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
        
        // // dd($priceLists);
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
        
        $result = PriceList::where('id', $priceList)->with('prices')->first();
        
        $prices = $result->prices->map->format();
        
        return view('priceList.prices', compact('prices'));
    }
    
    public function clone($id)
    {
        
        
        $pricelist = PriceList::find($id);
        
        $newClient = $pricelist->replicate();
        $newClient->push(); //Push before to get id of $clone
        
        foreach($pricelist->prices as $price)
        {
            $newClient->prices()->attach($price);
            dd($newClient);

        }
        
    
        
        dd($pricelist->prices);
        // $newpricelist = $pricelist->replicate();
        // // $newpricelist->id = $new_id;
        // // $newpricelist->data = $new_data;
        $newClient->save();
        dd($newClient);
        
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
