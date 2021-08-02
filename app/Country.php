<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';

    public $timestamps = false;

    public function resellers()
    {
    	return $this->belongsTo(Reseller::class, 'country');
    }
}
