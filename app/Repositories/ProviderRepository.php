<?php

namespace App\Repositories;

use App\Provider;
use Illuminate\Support\Collection;

class ProviderRepository implements ProviderRepositoryInterface
{
	
	public function all()
	{
		return Provider::orderBy('company_name')
		->with('country')
		->get()
		->map->format();
	}
	
	public function getSubscriptions(Provider $provider){
		
		$resellers= $provider->resellers;
		
		$subscriptions = new Collection();
		
		foreach ($resellers as $reseller){
			$customers=$reseller->customers;
			foreach($customers as $customer)
			{
				$subscriptions = $subscriptions->merge($customer->subscriptions);
			}
		}
		return $subscriptions;
	}
	
	
}