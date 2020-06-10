<?php

namespace App\Repositories;

use App\Provider;

interface ProviderRepositoryInterface
{
	public function all();

	public function create($provider);
	
	public function getSubscriptions(Provider $provider);

}