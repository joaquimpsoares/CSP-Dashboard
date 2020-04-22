<?php

namespace App\Repositories;

use App\Product;

interface ProductRepositoryInterface
{
	public function all($filters = null, $quantity = null);

	public function searchFilter($filters, $quantity);

	public function verifyQuantities(Product $product, $quantity);
}