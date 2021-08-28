<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FailedJobs extends Model
{
    use HasFactory;

    // public function getPayload(){

    //     $jsonpayload = json_decode($this->payload);
    //     // dd(unserialize($jsonpayload->data->command));
    //     $data = unserialize($jsonpayload->data->command);
    //     return $data;
    //     // dd($this->payload);
    //     // $jsonpayload = json_decode($this->payload);
    //     // return $jsonpayload->map(function($item){
    //     //     dd($item);
    //     //     return unserialize($item);
    //     // });

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
