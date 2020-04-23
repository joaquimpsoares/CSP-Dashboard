<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Provider;
use App\Repositories\ProviderRepositoryInterface;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    
    private $providerRepository;

    public function __construct(ProviderRepositoryInterface $providerRepository)
    {
        $this->providerRepository = $providerRepository;
    }

    public function getPriceList(Provider $provider)
    {
        $resellers = $provider->resellers()->with('priceList')->get();

        $priceLists = [];
        foreach ($resellers as $reseller) {
            if (!in_array($reseller->priceList, $priceLists))
                $priceLists[] = $reseller->priceList;
        }

        return view('priceList.index', compact('priceLists'));

    }

    public function index()
    {
        $providers = $this->providerRepository->all();
        return view('provider.index', compact('providers'));
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
    }

    
    public function show(Provider $provider)
    {
        //
    }

    
    public function edit(Provider $provider)
    {
        //
    }

    
    public function update(Request $request, Provider $provider)
    {
        //
    }

    
    public function destroy(Provider $provider)
    {
        //
    }
}
