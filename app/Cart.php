<?php

namespace App;

use App\Http\Traits\UserTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cart extends Model
{
	use UserTrait;
	public function __construct($user_id = null)
	{
		if (empty($this->user_id))
			$this->user()->associate($this->getUser());

		if (empty($this->token))
			$this->token = Str::uuid();
	}

	public function products()
	{
		return $this->belongsToMany('App\Product')->withPivot('id', 'quantity', 'price', 'retail_price', 'billing_cycle');
	}

	public function customer()
	{
		return $this->belongsTo('App\Customer');
	}

	public function user()
	{
		return $this->belongsTo('App\User');
	}
}
