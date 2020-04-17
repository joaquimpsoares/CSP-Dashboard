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
            'prices' => $this->prices
        ];
    }

    public function prices()
    {
        return $this->hasMany('App\Price');
    }

}
