<?php

namespace App\Http\Livewire\Price;

use App\Price;
use App\Product;
use App\PriceList;
use Livewire\Component;
use App\Http\Traits\UserTrait;

class ShowPricelist extends Component
{
    use UserTrait;
    public $showModal = false;
    public $editMargin = false;
    public $editPriceList = false;
    public $price;
    public $name;
    public $description;
    public $margin;
    public $sku;
    public $msrp;
    public $product_vendor;
    public $currency;
    public $priceList;

    public $selectedProducts = [];
    public $bulkDisabled = true;

    protected $rules = [
        'sku' => 'required|max:255',
        'price' => 'required|numeric',
        'msrp' => 'required|numeric',
        'product_vendor' => 'required|in:microsoft',
        'currency' => 'required|in:usd,eur',
    ];

    public function showModal()
    {
        $this->showModal = true;
    }

    public function editMargin()
    {
        $this->editMargin = true;
    }

    public function editPriceList()
    {
        $this->editPriceList = true;
    }

    public function close()
    {
        $this->showModal = false;
    }

    public function mount()
    {

        $this->margin = $this->priceList->margin;
        $this->name = $this->priceList->name;
        $this->description = $this->priceList->description;
    }

    public function deleteSelected()
    {
        $price = Price::query()
            ->whereIn('id', $this->selectedProducts)
            ->delete();
            // $price->pricelist()->dissociate($this->priceList);
        $this->selectedProducts = [];
    }

    public function save()
    {

        $this->validate();

        $product = Product::where('sku', $this->sku)->first();

        $price = new Price();
        $price->product_sku     = $this->sku;
        $price->name            = $product->name;
        $price->price           = $this->price;
        $price->msrp            = $this->msrp;
        $price->product_vendor  = $this->product_vendor;
        $price->currency        = $this->currency;
        $price->instance_id     = $this->priceList->instance_id;
        $price->price_list_id   = $this->priceList->id;
        $price->pricelist()->associate($this->priceList);
        $price->save();


        session()->flash('success','Price ' . $price->name . ' added successfully');
        $this->reset('price','msrp','sku','product_vendor','currency');
        $this->showModal = false;

    }


    public function remove(Price $price)
    {
        $price = Price::find($price->id);
        $price->delete();
        $price->pricelist()->dissociate($this->priceList);
        session()->flash('success','Price ' . $price->name . ' Removed successfully');
    }

    public function savePriceList(PriceList $priceList)
    {
        $priceList->name = $this->name;
        $priceList->description = $this->description;
        $priceList->save();

        $this->editPriceList = false;

        session()->flash('success','Price ' . $priceList->name . ' Removed successfully');
    }

    public function saveMargin(PriceList $priceList)
    {
        $priceList->margin = $this->margin;
        $priceList->save();

        $this->editMargin = false;
        session()->flash('success','Price ' . $priceList->name . ' Removed successfully');

    }

    public function render()
    {
        $user = $this->getUser();

        $this->bulkDisabled = count($this->selectedProducts) < 1;

        switch ($this->getUserLevel()) {
            case config('app.super_admin'):
                $priceList = $this->priceList;

                $products = Product::where('instance_id', $this->priceList->instance_id)->whereNotIn('sku', $this->priceList->prices->pluck('product_sku'))->get();

                $prices = $this->priceList->prices;

            break;

            case config('app.provider'):

                $provider = $user->provider;

                $priceList = $provider->priceList;

                $prices = $priceList->prices;
                $products = Product::whereIn('instance_id', $provider->instances->pluck('id'))->whereNotIn('sku',$prices->pluck('product_sku'))->get();

            break;

            case config('app.reseller'):

                $priceList = PriceList::where('id', $this->priceList->id)->first();

                $prices = $this->priceList->prices;
                $products = Product::where('instance_id',  $this->priceList->instance_id)->whereNotIn('sku',$prices->pluck('product_sku'))->get();

            break;

        }


        return view('livewire.price.show-pricelist', compact('prices', 'products'));
    }
}
