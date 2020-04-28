<?php

namespace App\Repositories;

use App\Customer;
use App\Reseller;

interface CustomerRepositoryInterface
{
	public function all();

	public function canInteractWithCustomer(Customer $customer);

	public function customersOfReseller(Reseller $reseller);
}