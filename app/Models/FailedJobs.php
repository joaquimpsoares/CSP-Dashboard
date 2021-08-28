<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FailedJobs extends Model
{
    use HasFactory;


    public function jobname(){
        $jsonpayload = json_decode($this->payload);
        return $jsonpayload->displayName;
    }

        public function getPayload(){
            return $this->payload->map(function($item){

                $item = json_decode($this->payload);
                return unserialize($item->data->command);
            });
        }
}
