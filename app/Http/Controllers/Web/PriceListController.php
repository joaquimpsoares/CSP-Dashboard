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

    public function getProviderPriceList(Request $request, Provider $provider)
    {
    	$userLevel = $this->getUserLevel();

    	dd('Provider');

		/*switch ($userLevel) {
            case config('app.super_admin'):

                $customers = Customer::with(['country', 'status'])->orderBy('company_name')->get();
                break;
            
            case config('app.admin'):
                $customers = Customer::with(['country', 'status'])->orderBy('company_name')->get();

                break;
            
            case config('app.provider'):
                $resellers = Reseller::where('provider_id', $user->provider->id)->pluck('id')->toArray();
                $customers = Customer::whereHas('resellers', function($query) use  ($resellers) {
                    $query->whereIn('id', $resellers);
                })->with(['country', 'status'])->orderBy('company_name')->get();

                break;
            
            case config('app.reseller'):
                $reseller = $user->reseller;
                $customers = $reseller->customers;

                break;
            
            case config('app.subreseller'):
                $reseller = $user->reseller;
                $customers = $reseller->customers;
                break;
            
            default:
                return abort(403, __('errors.unauthorized_action'));
                
                break;
        }*/

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
