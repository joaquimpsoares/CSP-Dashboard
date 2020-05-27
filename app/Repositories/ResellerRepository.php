<?php

namespace App\Repositories;

use App\Provider;
use App\Reseller;
use App\Http\Traits\UserTrait;
use Illuminate\Support\Collection;
use App\Repositories\ResellerRepositoryInterface;

/**
 * 
 */
class ResellerRepository implements ResellerRepositoryInterface
{
	
	use UserTrait;

	public function all()
	{
		$user = $this->getUser();

		switch ($this->getUserLevel()) {
			case config('app.super_admin'):
			$resellers = Reseller::whereNull('main_office')
			->with(['country', 'subResellers', 'status' => function ($query) {
				$query->where('name', 'message.active');
			}])
			->get()
			->map->format();
			break;

			case config('app.admin'):
			$resellers = Reseller::whereNull('main_office')
			->with(['country', 'subResellers', 'status' => function ($query) {
				$query->where('name', 'message.active');
			}])
			->get()
			->map->format();
			break;

			case config('app.provider'):
			$resellers = $user->provider->resellers()->whereNull('main_office')
			->with(['country', 'subResellers', 'status' => function ($query) {
				$query->where('name', 'message.active');
			}])
			->orderBy('company_name')
			->get()->map->format();
			break;

			default:
			return abort(403, __('errors.unauthorized_action'));
			break;
		}

		return $resellers;
	}

	public function resellersOfProvider(Provider $provider){

		$resellers = [];

		foreach($provider->resellers as $reseller){
			$resellers[]=$reseller->format();
			// var_dump($reseller);
		}

		return $resellers;

	}

	public function getSubscriptions(Reseller $reseller){
		
		$customers= $reseller->customers;

		$subscriptions = new Collection();

		foreach($customers as $customer){
			$subscriptions = $subscriptions->merge($customer->subscriptions);
		}
		
		return $subscriptions;
		
	}


}
