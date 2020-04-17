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

    
    public function show(Reseller $reseller) { }

    
    public function edit(Reseller $reseller) { }

    
    public function update(Request $request, Reseller $reseller) { }

    
    public function destroy(Reseller $reseller) { }

    public function getPriceList($reseller)
    {

        $reseller = Reseller::with('priceList')->where('id', $reseller)->first();
        dd($reseller);
    }
}
