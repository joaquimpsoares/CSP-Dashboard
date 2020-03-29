<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    public function priceList()
    {
    	return $this->belongsTo('App\PriceList');
    }
}
