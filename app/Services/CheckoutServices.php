<?php

namespace App\Services;

use Exception;
use Tagydes\MicrosoftConnection\Facades\Order as TagydesOrder;

class CheckoutServices{

    public $mpnid = 0;

    private $reseller;

    public function __construct($reseller){
        $this->reseller = $reseller;
    }

    public function scan($mpnid){

        $instance = $this->reseller->provider->instances[0];

        $tagydesorder = TagydesOrder::withCredentials($instance->external_id, $instance->external_token)->checkMPNID($mpnid);

        return ($tagydesorder);
    }
}
