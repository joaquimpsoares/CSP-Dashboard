<?php

namespace App\Repositories;

use App\Product;

class ProductRepository implements ProductRepositoryInterface
{
	
	public function all($filters = null, $quantity = null)
	{
        if (empty($filters) && empty($quantity))
        {
            $products = Product::where('addons', '<>', '[]')
            ->orderBy('name')->paginate(10); //->get()->map->format();
        } else {
            if (isset($filters['search'])) {
                $products = $this->searchFilter($filters, $quantity);
            } else {
                $products = Product::where('addons', '<>', '[]')
                ->orderBy('vendor')
                ->orderBy('name')
                ->paginate($quantity);
            }
        }

        return $products;

    }

    public function searchFilter($filters, $quantity) {

        $products = (new Product)->newQuery();

        if (isset($filters['name'])) {
            $products->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if (isset($filters['vendor']) && !empty($filters['vendor']) ) {
            $products->where('vendor', $filters['vendor']);
        }

        return $products->where('addons', '<>', '[]')->paginate($quantity);

    }
}