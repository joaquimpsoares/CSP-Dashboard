<?php

namespace App\Repositories;


interface OrderRepositoryInterface
{
	public function all();
	
	public function newFromCartToken($token);

	public function UpdateMSSubscription($subscription,$request);

	public function ImportProductsMicrosoftOrder();


}