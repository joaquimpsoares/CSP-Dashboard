<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cart extends Model
{
	public function __construct($user_id = null)
	{
		if (empty($this->user_id))
			$this->user_id = $user_id;

		if (empty($this->token))
			$this->token = Str::uuid();
	}

	public function products()
	{
		return $this->belongsToMany('App\Product')->withPivot('id', 'quantity', 'price', 'retail_price');
	}
}
