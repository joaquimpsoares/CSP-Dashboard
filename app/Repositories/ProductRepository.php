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
            $products = Product::with('instance')->where('addons', '<>', '[]')
            ->orderBy('name')->paginate(10); //->get()->map->format();
        } else {
            if (isset($filters['search'])) {
                $products = $this->searchFilter($filters, $quantity);
            } else {
                $products = Product::with('instance')->where('addons', '<>', '[]')
                ->orderBy('vendor')
                ->orderBy('name')
                ->paginate($quantity);
            }
        }

        return $products;

    }

    public function showall($filters = null, $quantity = null)
	{
        if (empty($filters) && empty($quantity))
        {
            $products = Product::with('instance')->
            orderBy('name')->get();
        } else {
            if (isset($filters['search'])) {
                $products = $this->searchFilter($filters, $quantity);
            } else {
                $products = Product::with('instance')->where('addons', '<>', '[]')
                ->orderBy('vendor')
                ->orderBy('name')
                ->get();
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

        if (!$product->tiers->isEmpty()) {
            $prices = $product->tiers()
                ->where('min_quantity', '<=', $quantity)
                ->where('max_quantity', '>=', $quantity)
                ->count();
            return $prices > 0 ? true : false;
        } else {
            if ($product->minimum_quantity <= $quantity && $product->maximum_quantity >= $quantity)
            return true;
        }


        return false;
    }

    public function getPriceOf($product_id) {
        $user = $this->getUser();

        switch ($this->getUserLevel()) {
            case 'Provider':
                # code...
            break;

            case 'Customer':

                $product = Product::where('id', $product_id)->first();
                // dd($product->sku);
                $priceList = Price::where('product_sku',$product->sku)->first()->price_list_id;
                // dd($priceList);
                $prices = Price::where('price_list_id', $priceList)->where('product_sku', $product->sku)->where('product_vendor', $product->vendor)->first();
                // $instance = $user->customer->resellers->first()->provider->instances->first()->id;
                // $product = Product::where('id', $product_id)->where('instance_id', $instance)->first();
                // $priceList = $user->customer->priceLists->first()->dd();
                // $prices = Price::where('price_list_id', $priceList->id)->where('product_sku', $product->sku)->where('product_vendor', $product->vendor)->first();
            break;

            case 'Reseller':
                // $instance = $user->reseller->provider->instances->first()->id;
                $product = Product::where('id', $product_id)->first();

                // If product has tiers check the lowest price on tiers relationship
                if (!$product->tiers->isEmpty()) {

                    $prices = $product->tiers()->orderBy('min_quantity', 'ASC')->first();

                } else {

                    $priceList = Price::where('product_sku',$product->sku)->first()->price_list_id;
                    $prices = Price::where('price_list_id', $priceList)->where('product_sku', $product->sku)->where('product_vendor', $product->vendor)->first();
                }


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

    public function getByID($id) {
        $product = Product::find($id);
        return $product;
    }
}
