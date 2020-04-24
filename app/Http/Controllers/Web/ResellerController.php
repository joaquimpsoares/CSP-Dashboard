<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\ResellerRepositoryInterface;
use App\Reseller;
use Illuminate\Http\Request;

class ResellerController extends Controller
{

    private $resellerRepository;

    public function __construct(ResellerRepositoryInterface $resellerRepository)
    {
        $this->resellerRepository = $resellerRepository;
    }


    public function getCustomersFromReseller(Reseller $reseller) {
        dd($reseller);
    }
    

    public function index()
    {
        $resellers = $this->resellerRepository->all();        
        return view('reseller.index', compact('resellers'));
    }

    
    public function create() { }

    
    public function store(Request $request) { }

    
    public function show(Reseller $reseller) { 
        return view('reseller.show', compact('reseller'));
    }

    
    public function edit(Reseller $reseller) { }

    
    public function update(Request $request, Reseller $reseller) { }

    
    public function destroy(Reseller $reseller) { }

    public function getPriceList(Reseller $reseller)
    {

        $priceLists = [];

        $priceLists[] = $reseller->priceList;

        $customers = $reseller->customers()->with('priceList')->get();
        
        foreach ($customers as $customer) {
            if (!in_array($customer->priceList, $priceLists))
                $priceLists[] = $customer->priceList;
        }

        return view('priceList.index', compact('priceLists'));
    }
}
