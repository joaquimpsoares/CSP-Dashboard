<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tier extends Model
{

    protected $guarded = []; 

    
    public function prices() {
        return $this->belongsToMany('App\Price');
    }

    public function products() {
        return $this->hasOne('App\Product');
    }
    
}
