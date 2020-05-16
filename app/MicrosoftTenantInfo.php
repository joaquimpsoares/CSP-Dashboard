<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MicrosoftTenantInfo extends Model
{
	protected $fillable = [
		'tenant_id',
		'tenant_domain',
		'customer_id'
	];

    public function customer() {
    	return $this->belongsTo('App\Customer');
    }
}
