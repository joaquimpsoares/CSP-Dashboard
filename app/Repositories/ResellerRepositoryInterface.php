<?php

namespace App\Repositories;

use App\Provider;
use App\Reseller;

interface ResellerRepositoryInterface
{
	public function all();

	public function create($reseller, $user);

	public function resellersOfProvider(Provider $provider);

	public function getSubscriptions(Reseller $reseller);



}