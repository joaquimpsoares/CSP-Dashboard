<?php

namespace App\Repositories;


interface OrderRepositoryInterface
{
	public function newFromCartToken($token);
}