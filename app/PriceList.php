<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceList extends Model
{
	protected $guarded = [];

    public function format()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'prices' => $this->prices(),
            'provider' => $this->provider()->first(),
            'reseller' => $this->reseller()->get(),
            'customer' => $this->customer()->get()
        ];
    }

    public function prices(){
        return $this->hasMany('App\Price');
    }

    public function provider() {
		return $this->belongsTo('App\Provider', 'id', 'price_list_id');
    }

    public function reseller() {
		return $this->belongsTo('App\Reseller', 'id', 'price_list_id');
    }

    public function customer() {
		return $this->belongsTo('App\Customer', 'id', 'price_list_id');
    }
}
