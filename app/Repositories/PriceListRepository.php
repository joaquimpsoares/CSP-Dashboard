<?php

namespace App\Repositories;

use App\User;
use App\Price;
use App\Product;
use App\Provider;
use App\Reseller;
use App\PriceList;
use App\Http\Traits\UserTrait;
use Illuminate\Support\Facades\Auth;



class PriceListRepository implements PriceListRepositoryInterface
{
	use UserTrait;
	
	public function all()
	{
		
		$user = $this->getUser();
		
			switch ($this->getUserLevel()) {
				case config('app.super_admin'):
					
						$priceLists = PriceList::orderBy('name')->get()->map->format();
						$prices = Price::get();

				break;
				
				case config('app.admin'):

						$priceLists = PriceList::orderBy('name')->get()->map->format();
						$prices = Price::get();

				break;
				
				case config('app.provider'):
					
					$provider_id=User::select('provider_id')->where('id', Auth::user()->id)->first();
					$provider=Provider::where('id', $provider_id->provider_id)->first();				
					$priceLists = PriceList::where('id', $provider->price_list_id)->get()->map->format();
					$prices = Price::get();
					
				break;
				
				case config('app.reseller'):
					
					$reseller_id=User::select('reseller_id')->where('id', Auth::user()->id)->first();
					$resellers=Reseller::where('id', $reseller_id->reseller_id)->first();
					$priceLists = PriceList::where('id', $resellers->price_list_id)->get()->map->format();
					$prices = Price::get();
					
				break;
				
				case config('app.subreseller'):
					$reseller_id=User::select('reseller_id')->where('id', Auth::user()->id)->first();
					$resellers=Reseller::where('id', $reseller_id->reseller_id)->first();
					$priceLists = PriceList::where('id', $resellers->price_list_id)->get()->map->format();
					$prices = Price::get();
				break;
				
				default:
				return abort(403, __('errors.unauthorized_action'));
				
			break;
		}
	
		return $priceLists;
	}

	public function listPrices(){

		$user = $this->getUser();

		switch ($this->getUserLevel()) {
			case config('app.super_admin'):
					
				$priceLists = PriceList::orderBy('name')->get()->map->format();
				$prices = Price::get();
		break;

		case config('app.provider'):
			$provider = $user->provider;
			$priceList = $provider->priceList;
			$prices = $priceList->prices;
		break;

		case config('app.reseller'):
			$reseller = $user->reseller;
			$priceList = $reseller->priceList;
			$prices = $priceList->prices;
		break;


		
		case config('app.subreseller'):
			$reseller_id=User::select('reseller_id')->where('id', Auth::user()->id)->first();
			$resellers=Reseller::where('id', $reseller_id->reseller_id)->first();
			$priceLists = PriceList::where('id', $resellers->price_list_id)->get()->map->format();
			$prices = Price::get();

		break;
		
			
			default:
				# code...
				break;
		}
		return $prices;
	}
}