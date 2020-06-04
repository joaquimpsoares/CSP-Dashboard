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
            'prices' => $this->prices,
            'providers' => $this->providers,
            'resellers' => $this->resellers,
            'customers' => $this->customers,
        ];
    }

    public function prices()
    {
        return $this->hasMany('App\Price');
    }
    
    public function providers()
    {
        return $this->hasMany('App\provider', 'price_list_id', 'id');
    }

    public function resellers()
    {
        return $this->hasMany('App\reseller', 'price_list_id', 'id');
    }

    public function customers()
    {
        return $this->hasMany('App\customer', 'price_list_id', 'id');
    }



}
