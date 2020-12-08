<?php

namespace App\Repositories;

use App\Customer;

interface SubscriptionRepositoryInterface
{
	public function all();

	// public function canInteractWithCustomer(Customer $customer);

	public function subscriptionsOfCustomer(Customer $customer);
}