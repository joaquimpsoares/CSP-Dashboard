<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
    public function format()
    {
        return [
            'id'            => $this->id,
            'queue'         => $this->queue,
            'payload'       => $this->getPayload,
            'attempts'      => $this->attempts,
            'reserved_at'   => $this->reserved_at,
            'available_at'  => $this->available_at,
            'created_at'    => $this->created_at,
        ];

    }
   public function getPayload(){
        return $this->payload->map(function($item){
            return unserialize($item);
        });
    }

}
