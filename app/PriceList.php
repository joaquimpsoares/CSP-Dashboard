<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceList extends Model
{

	/*
	* Para providers será criada uma unica priceList que representará o preço atual fornecido pelo canal de venda (ex: Microsoft)
	* Um provider poderao criar mais de uma priceList para distribuir entre seus resellers
	* Para resellers será criada uma única priceList que deverá ser negociada entre provider e reseller
	* Um reseller poderao criar mais de uma priceList para distribuir entre seus subreseller/customers
	* Uma priceList também poderá ser utilizada por um preço especial oferecido pelo distribuidor (ex: Microsoft) a um customer
	*/
	
	protected $guarded = [];

    public function format()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'markup' => $this->markup,
            'prices' => $this->prices
        ];
    }

    /*public function providers() {
    	return $this->morphedByMany('App\Provider', 'price_listables');
    }

    public function resellers() {
    	return $this->morphedByMany('App\Reseller', 'price_listables');
    }*/

    public function pricelistable() {
        return $this->morphTo();
    }

    public function prices()
    {
        return $this->hasMany('App\Price');
    }

}
