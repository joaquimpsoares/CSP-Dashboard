<?php

namespace App\Repositories;

use App\Customer;
use App\Reseller;
use App\Subscription;

interface AnalyticRepositoryInterface
{
	public function all($customer_id, Subscription $subscription);

    public function UpdateAZURE($customer_id, Subscription $subscription);

	public function importBudget($customer_id, Subscription $subscription);

	public function update($customer, $validate);

	public function canInteractWithCustomer(Customer $customer);

	public function customersOfReseller(Reseller $reseller);

	public function getSubscriptions(Customer $customer);

	public function ResellerOfcustomer(Customer $customer);

}
