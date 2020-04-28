<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{

    public function getPayload(){
        return $this->payload->map(function($item){
            return unserialize($item);
        });
    }
    
}
