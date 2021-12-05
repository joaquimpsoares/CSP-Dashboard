<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use ALajusticia\Expirable\Traits\Expirable;

class Instance extends Model
{

    // use Expirable;
    // const EXPIRES_AT = 'external_token_updated_at';

    protected $dates = [
        'created_at',
        'updated_at',
        'external_token_updated_at'
    ];

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function invoices()
    {
        return $this->hasMany(Models\MsftInvoices::class);
    }

    // public function isExpired()
    // {
    //     return !is_null($this->{self::getExpirationAttribute()}) && $this->{self::getExpirationAttribute()} <= Carbon::now();
    // }
}
