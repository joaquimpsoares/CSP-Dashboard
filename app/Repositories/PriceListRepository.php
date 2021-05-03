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

                    // $instances = Auth::user()->provider->instances;
                    // foreach ($instances as $instance)
                    // $priceLists = PriceList::where('instance_id',$instance->id)->get()->map->format();

                    // $priceLists = Auth::user()->provider->pricelist->format();

                    $priceLists = PriceList::wherein('instance_id', Auth::user()->provider->instances->pluck('id'))->get()->map->format();

					// $provider_id=User::select('provider_id')->where('id', Auth::user()->id)->first();
					// $provider=Provider::where('id', $provider_id->provider_id)->first();
					// $priceLists = PriceList::where('id', $provider->price_list_id)->get()->map->format();
					// $prices = Price::get();

				break;

				case config('app.reseller'):


					$reseller_id=User::where('id', Auth::user()->id)->first();

					$priceLists = PriceList::wherein('instance_id', Auth::user()->reseller->provider->instances->pluck('id'))->get()->map->format();
                    $prices = Price::get();

                    $priceLists = PriceList::where('id', Auth::user()->reseller->provider->price_list_id)->get()->map->format();
					// $reseller_id=User::select('reseller_id')->where('id', Auth::user()->id)->first();

					// $resellers=Reseller::where('id', $reseller_id->reseller_id)->first();

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
				$prices = Price::paginate(10);

		break;

		case config('app.provider'):
			$provider = $user->provider;
			$priceList = $provider->priceList;
			$prices = $priceList->prices;
		break;

		case config('app.reseller'):
			$reseller = $user->reseller;
			$priceList = PriceList::where('instance_id', $reseller->provider->instances->pluck('id'))->first();
			// $priceList = $reseller->priceList;
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
