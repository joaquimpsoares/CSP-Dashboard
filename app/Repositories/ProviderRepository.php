<?php

namespace App\Repositories;

use App\Provider;

class ProviderRepository implements ProviderRepositoryInterface
{
	
	public function all()
	{
		return Provider::orderBy('company_name')
		->with([
			'country', 
			'status' => function ($query) {
				$query->where('name', 'message.active');
			}])
		->get()
		->map->format();
	}

	
}