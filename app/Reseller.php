<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Status;
use Webpatser\Countries\Countries;

class Reseller extends Model
{
    protected $guards = [];

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
    
    public function country() {
    	return $this->belongsTo(Countries::class, 'country_id');
    }

    public function users() {
    	return $this->hasMany('App\User');
    }

    public function provider() {
    	return $this->belongsTo('App\Provider');
    }

    public function customers() {
        return $this->belongsToMany('App\Customer');
    }

    public function path() {
        return url("/resellers/{$this->id}-" . Str::slug($this->company_name, ' '));
    }

    public function subResellers() {
        return $this->hasMany('App\Reseller', 'main_office');
    }

    public function priceList() {
        return $this->belongsTo('App\PriceList');
    }

    public function status() {
        return $this->belongsTo(Status::class);
    }
}
