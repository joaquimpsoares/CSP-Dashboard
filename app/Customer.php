<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Status;
use Webpatser\Countries\Countries;

class Customer extends Model
{
    protected $guards = [];

    protected $fillable = 
    ['company_name',
    'nif',
    'country_id',
    'address_1',
    'address_2',
    'city',
    'state',
    'postal_code',
    'provider_id',
    'reseller_id',
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
            'status' => $this->status->name,
            'path' => $this->path(),
            'pathUpdate' => $this->pathUpdate(),
            'reseller' => $this->resellers()->first(),
            'subscriptions' => $this->subscriptions->count(),
            'priceLists' => $this->priceLists()->first(),
            'mainUser' => $this->users()->first(),
            'users' => $this->users()->get()     
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
    public function subscriptions() {
    	return $this->hasMany('App\Subscription');
    }

    
    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function priceLists() {
    	return $this->hasMany('App\PriceList', 'id', 'price_list_id');
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

    public function pathUpdate() {
        return url("/customer/{$this->id}-" . Str::slug($this->company_name, '-')."/update");
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
