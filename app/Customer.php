<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Status;
use Webpatser\Countries\Countries;

class Customer extends Model
{
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
        return url("/customers/{$this->id}-" . Str::slug($this->company_name, '-'));
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
        return $this->morphOne('App\PriceList', 'pricelistable');
    }

    public function status() {
        return $this->belongsTo(Status::class);
    }
}
