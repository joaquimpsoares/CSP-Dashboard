<?php

namespace App\Http\Controllers\Api;

use App\Reseller;
use App\Http\Traits\ApiResponser;
use App\Http\Controllers\Controller;

class ResellerController extends ApiController
{
    use ApiResponser;
    public function index()
    {
        return Reseller::all();
    }
}
