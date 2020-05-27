<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instance extends Model
{
    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
        'external_token_updated_at'
    ];

    public function provider()
    {
    	return $this->belongsTo('App\Provider');
    }

}
