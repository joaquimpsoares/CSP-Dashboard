<?php

namespace App\Repositories;

use App\Customer;

interface CustomerRepositoryInterface
{
	public function all();

	public function canInteractWithCustomer(Customer $customer);
}