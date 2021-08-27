<?php

namespace App\Http\Controllers\Web;

use App\PriceList;
use App\Http\Traits\UserTrait;
use App\Http\Controllers\Controller;

class PriceListController extends Controller
{
    use UserTrait;

    public function index()
    {
        $priceLists = PriceList::paginate(10);
        return view('priceList.index', compact('priceLists'));
    }

    public function show(PriceList $priceList)
    {
        return view('priceList.show', compact('priceList'));
    }


}
