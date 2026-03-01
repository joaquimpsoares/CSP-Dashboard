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

    /**
     * The new pricing UI handles price list creation via a Livewire drawer.
     * Redirect any request for the legacy create page to the new UI.
     */
    public function create(): \Illuminate\Http\RedirectResponse
    {
        return redirect(route('pricing.price_lists.index'));
    }
}
