<?php

namespace App\Repositories;

use App\Provider;
use App\Reseller;

interface ResellerRepositoryInterface
{
	public function all();

	public function resellersOfProvider(Provider $provider);

	public function getSubscriptions(Reseller $reseller);



}