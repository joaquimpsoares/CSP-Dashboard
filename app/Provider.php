<?php

namespace App;

use App\Status;
use Illuminate\Support\Str;
use Webpatser\Countries\Countries;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{

	protected $fillable = ['company_name',
							'nif',
							'country_id',
							'address_1',
							'address_2',
							'city',
							'state',
							'postal_code',
							'status_id'];


    public function format()
	{

		return [
			'id' => $this->id,
			'company_name' => $this->company_name,
			'address_1' => $this->address_1,
			'address_2' => $this->address_2,
			'country' => $this->country->name,
			'city' => $this->city,
			'state' => $this->state,
			'nif' => $this->nif,
			'postal_code' => $this->postal_code,
			'resellers' => $this->resellers,
			'customers' => $this->resellers,
			'status' => $this->status->name,
			'path' => $this->path(),
			'mainUser' => $this->users()->first(),
			'instance' => $this->instances()->get()

		];

	}

    public function resellers() {
		return $this->hasMany('App\Reseller');
	}

	public function getMyCustomersId() {
		$customers = [];

		$resellers = $this->resellers()->whereNull('main_office')->get(['id']);
		foreach ($resellers as $reseller) {
			foreach ($reseller->customers()->get(['id']) as $customer) {
				$customers[] = $customer->id;
			}
		}

		return $customers;
	}

	public function path() {
        return url("/provider/{$this->id}-" . Str::slug($this->company_name, '-'));
    }

    public function country() {
    	return $this->belongsTo(Countries::class);
    }

    public function status() {
    	return $this->belongsTo(Status::class);
	}
	
	public function users() {
    	return $this->hasMany('App\User');
    }


	public function instances()
    {
    	return $this->hasMany('App\Instance');
    }

    public function priceList() {
        return $this->belongsTo('App\PriceList');
    }
    
}
