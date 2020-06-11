<?php

namespace App\Repositories;

use App\Customer;
use App\Reseller;

interface CustomerRepositoryInterface
{
	public function all();

	public function create($customer);

	public function canInteractWithCustomer(Customer $customer);

	public function customersOfReseller(Reseller $reseller);

	public function getSubscriptions(Customer $customer);

	public function ResellerOfcustomer(Customer $customer);

}