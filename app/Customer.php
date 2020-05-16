<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Status;
use Webpatser\Countries\Countries;

class Customer extends Model
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
        return $this->belongsToMany('App\Reseller');
    }

    public function country() {
    	return $this->belongsTo(Countries::class, 'country_id');
    }

    public function users() {
    	return $this->hasMany('App\User');
    }

    public function customer() {
    	return $this->belongsTo('App\Customer');
    }

    public function path() {
        return url("/customer/{$this->id}-" . Str::slug($this->company_name, '-'));
    }

    public function pathEdit() {
        return url("/customer/{$this->id}-" . Str::slug($this->company_name, '-')."/edit");
    }

    public function getMyResellersId() {
        $resellersList = [];

        $resellers = $this->resellers()->get(['id']);

        foreach ($resellers as $reseller) {
            $resellersList[] = $reseller->id;
        }


        return $resellersList;
    }

    public function priceList() {
        return $this->belongsTo('App\PriceList');
    }
    
    public function status() {
        return $this->belongsTo(Status::class);
    }

    public function microsoftTenantInfo() {
        return $this->hasMany('App\MicrosoftTenantInfo');
    }
}
