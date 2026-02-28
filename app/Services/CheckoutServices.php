<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
// TagydesOrder removed — Tagydes\MicrosoftConnection no longer available.

class CheckoutServices{

    public $mpnid = 0;

    private $reseller;

    public function __construct($reseller){
        $this->reseller = $reseller;
    }

    public function scan($mpnid)
    {
        // checkMPNID not yet implemented in MicrosoftCspConnection module.
        Log::warning('CheckoutServices::scan() — checkMPNID not yet implemented.', ['mpnid' => $mpnid]);
        return null;
    }
}
