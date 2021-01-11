<?php

namespace App\Repositories;

use App\Provider;
use App\Http\Traits\ActivityTrait;
use Illuminate\Support\Collection;

class ProviderRepository implements ProviderRepositoryInterface
{

    use ActivityTrait;

	public function all()
	{
		return Provider::with(['resellers','status', 'resellers'])->orderBy('company_name')
		->with('country')
		->get()
		->map->format();
	}

	public function create($provider)
	{
		$newProvider = Provider::create([
			'company_name' => $provider['company_name'],
			'nif' => $provider['nif'],
			'country_id' => $provider['country_id'],
			'address_1' => $provider['address_1'],
			'address_2' => $provider['address_2'],
			'city' => $provider['city'],
			'state' => $provider['state'],
			'postal_code' => $provider['postal_code'],
			'status_id' => $provider['status']
		]);

		return $newProvider;
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
