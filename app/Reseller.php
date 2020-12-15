<?php

namespace App;

use App\Status;
use Illuminate\Support\Str;
use App\Http\Traits\ActivityTrait;
use Webpatser\Countries\Countries;
use Illuminate\Database\Eloquent\Model;

class Reseller extends Model
{
    use ActivityTrait;

    protected $guards = [];

    protected $guarded = [];

    public function format()
    {
        return [
            'id' => $this->id,
            'company_name' => $this->company_name,
            'address_1' => $this->address_1,
            'address_2' => $this->address_2,
            'mpnid' => $this->mpnid,
            'country' => $this->country->name,
            'countrycode' => $this->country->iso_3166_2,
            'city' => $this->city,
            'state' => $this->state,
            'nif' => $this->nif,
            'postal_code' => $this->postal_code,
            'status' => $this->status->name,
            'path' => $this->path(),
            'provider' => $this->provider,
            'created_at' => $this->created_at,
            'customers' => $this->customers->count(),
            'mainUser' => $this->users()->first(),
            'users' => $this->users(),
        ];

    }

    public function country() {
    	return $this->belongsTo(Countries::class, 'country_id');
    }

    public function users() {
    	return $this->hasMany(User::class);
    }

    public function provider() {
    	return $this->belongsTo('App\Provider');
    }

    public function customers() {
        return $this->belongsToMany('App\Customer');
    }

    public function path() {
        return url("/reseller/{$this->id}-" . Str::slug($this->company_name, '-'));
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
