<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Price;
use App\Tier;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function clone($id)
    {

        $prices = Price::find($id);
        $newprices = $prices->replicate();
            // $newpricelist->id = $new_id;
            // $newpricelist->data = $new_data;
        $newprices->save();

        return view('priceList.index', compact('prices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Price  $price
     * @return \Illuminate\Http\Response
     */
    public function show(Price $price)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Price  $price
     * @return \Illuminate\Http\Response
     */
    public function edit(Price $price)
    {
        $price = Price::find($price->id);

        return view('price.edit', compact('price'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Price  $price
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Price $price)
    {

        $pricerequest = $request->except(['_token', '_method', 'tier_name', 'min_quantity', 'max_quantity' ]);

        Price::where('id', $price->id)->update($pricerequest);

        $price->tiers()->update([
            'max_quantity' => $request->max_quantity,
            'min_quantity' => $request->min_quantity
        ]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Price  $price
     * @return \Illuminate\Http\Response
     */
    public function destroy(Price $price)
    {
        //
    }
}
