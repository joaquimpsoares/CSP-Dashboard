<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{

	protected $fillable = [
		'product_sku',
		'product_vendor',
		'price_list_id',
		'name',
		'price',
		'msrp',
		'currency',
	];

	public function format()
	{
		return [
			'product_sku' => $this->product_sku,
			'product_vendor' => $this->product_vendor,
			'price_list_id' => $this->price_list_id,
			'name' => $this->name,
			'price' => $this->price,
			'msrp' => $this->msrp,
			'currency' => $this->currency,
			'pricelist' => $this->pricelist,
			'instance' => $this->pricelist->id,
			'category' => $this->product,
			'provider' => $this->provider()->first()

		];
	}

	public function pricelist() {
		return $this->belongsTo('App\PriceList', 'price_list_id', 'id');
	}

	public function product() {
		return $this->belongsTo('App\Product', 'product_sku', 'sku')
		->where('vendor', $this->product_vendor)->where('instance_id', session()->get('instance_id'));
    }

    // public function products() {
    //     return $this->hasOne('App\Product', 'sku', 'product_sku');
    // }

	// public function provider() {
	// 	return $this->belongsTo('App\Provider', 'price_list_id', 'id');
	// }

	public function tiers() {
        return $this->belongsToMany('App\Tier');
    }


}
