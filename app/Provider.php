<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Status;
use Webpatser\Countries\Countries;

class Provider extends Model
{
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
			'status' => $this->status->name,
            'path' => $this->path()
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
        return url("/providers/{$this->id}-" . Str::slug($this->company_name, '-'));
    }

    public function country() {
    	return $this->belongsTo(Countries::class);
    }

    public function status() {
    	return $this->belongsTo(Status::class);
    }
    
}
