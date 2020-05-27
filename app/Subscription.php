<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    public function status() {
        return $this->belongsTo(Status::class);
    }

    public function customer() {
        return $this->belongsTo('App\Customer');
   }
        
}
