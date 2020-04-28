<?php

namespace App\Repositories;

use App\Provider;

interface ResellerRepositoryInterface
{
	public function all();

	public function resellersOfProvider(Provider $provider);

}