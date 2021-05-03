<?php

namespace App\Repositories;

use App\Subscription;

interface AnalyticRepositoryInterface
{
	public function all($customer_id, Subscription $subscription);

    public function UpdateAZURE($customer_id, Subscription $subscription);

	public function importBudget($customer_id, Subscription $subscription);

	public function update($customer, $validate);

    public function getAzureSubscriptions();


}
