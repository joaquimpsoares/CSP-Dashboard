<?php

namespace App\Repositories;

interface ProductRepositoryInterface
{
	public function all($filters = null, $quantity = null);

	public function searchFilter($filters, $quantity);
}