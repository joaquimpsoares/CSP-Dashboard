<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Status;
use Webpatser\Countries\Countries;

class Reseller extends Model
{
    protected $guards = [];


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
        return $this->morphToMany('App\PriceList', 'price_listables');
    }

    public function status() {
        return $this->belongsTo(Status::class);
    }
}
