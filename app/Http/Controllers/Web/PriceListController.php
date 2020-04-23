<?php

namespace App\Http\Controllers\Web;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Http\Traits\UserTrait;
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
        

		return view('priceList.index', compact('priceLists'));
	}

    public function getPrices($priceList)
    {

        $result = PriceList::where('id', $priceList)->with('prices')->first();
        
        $prices = $result->prices->map->format();

        return view('priceList.prices', compact('prices'));
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
