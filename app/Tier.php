<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tier extends Model
{
    public function prices() {
        return $this->belongsToMany(Price::class);
    }

    public function products() {
        return $this->hasOne(Product::class);
    }
}
