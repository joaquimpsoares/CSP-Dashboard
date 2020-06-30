<?php

namespace App\Repositories;

use App\Http\Traits\UserTrait;
use App\Price;
use App\Product;

class ProductRepository implements ProductRepositoryInterface
{

    use UserTrait;
	
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

    public function verifyQuantities(Product $product, $quantity) {
        if ($product->minimum_quantity <= $quantity && $product->maximum_quantity >= $quantity)
            return true;

        return false;
    }

    public function getPriceOf($product_id) {
        $user = $this->getUser();
        $instance = $user->reseller->provider->instances->first()->id;
        $product = Product::where('id', $product_id)->where('instance_id', $instance)->first();

        switch ($this->getUserLevel()) {
            case 'Provider':
                # code...
                break;
            
            case 'Reseller':
                $priceList = $user->reseller->priceList;
                $prices = Price::where('price_list_id', $priceList->id)->where('product_sku', $product->sku)->where('product_vendor', $product->vendor)->first();
                break;

            case 'Sub Reseller':
                # code...
                break;

            default:
                # code...
                break;
        }

        return $prices;
    }
}