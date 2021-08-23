<?php

namespace App\Http\Controllers\Web;

use App\Price;
use Exception;
use App\Product;
use App\Instance;
use App\PriceList;
use Illuminate\Http\Request;
use App\Imports\PricesImport;
use App\Http\Traits\UserTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\PriceListRepositoryInterface;

class PriceListController extends Controller
{
    use UserTrait;
    public $priceList;

    private $priceListRepository;

    public function __construct(PriceListRepositoryInterface $priceListRepository)
    {
        $this->priceListRepository = $priceListRepository;
    }

    public function index()
    {
        $priceLists = PriceList::paginate(10);
        return view('priceList.index', compact('priceLists'));
    }

    public function show(PriceList $priceList)
    {
        return view('priceList.show', compact('priceList'));
    }

    public function create()
    {

        $products = Product::get();
        $priceLists = $this->priceListRepository->all();
        $prices = Price::get();

        return view('priceList.create', compact('priceLists', 'prices', 'products'));
    }

    public function getPrices(PriceList $priceList)
    {
        $user = $this->getUser();

        switch ($this->getUserLevel()) {
            case config('app.super_admin'):

                // $prices = $this->priceListRepository->listPrices()->paginate(10);

                // $priceList = PriceList::where('id', $priceList)->first();
                // $provider = $priceList->provider;


                $prices = $priceList->prices->paginate('10');

                $products = Product::where('instance_id', $priceList->instance_id)->whereNotIn('sku', $prices->pluck('product_sku'))->get();

                break;

            case config('app.provider'):

                $provider = $user->provider;
                $prices = $priceList->prices;
                $products = Product::where('instance_id', $priceList->instance_id)->whereNotIn('sku', $prices->pluck('product_sku'))->get();

                break;

            case config('app.reseller'):

                $priceList = PriceList::where('id', $priceList)->first();


                $prices = $priceList->prices;
                $products = Product::where('instance_id', $priceList->instance_id)->whereNotIn('sku', $prices->pluck('product_sku'))->get();

                break;
        }

        return view('priceList.prices', compact('prices', 'priceList', 'products'));
    }

    // public function update(Request $request, $priceList)
    // {

    //     $priceList = PriceList::find($priceList);


    //     $updatepriceList = $priceList->update([
    //         'name' => $request['name'],
    //         'description' => $request['description'],

    //     ]);

    //     return redirect()->back()->with(['alert' => 'success', 'message' => trans('messages.pricelist_updated_successfully')]);
    // }

    // public function storePriceList(Request $request)
    // {
    //     $priceList = $this->getUser()->reseller->priceList;

    //     $newPriceList = PriceList::create([
    //         'name' => $request->name,
    //         'description' => $request->description,
    //         'instance_id' => $request->instance_id,
    //     ]);

    //     $priceList->prices->each(function(Price $price)use($newPriceList){
    //         $attributes = $price->getAttributes();
    //         unset($attributes['id']);
    //         $newPriceList->prices()->create($attributes);
    //     });

    //     return redirect()->back()->with(['alert' => 'success', 'message' => trans('messages.pricelist_created_successfully')]);
    // }

    public function import(Request $request)
    {
        $data = Excel::import(new PricesImport, request()->file('select_file'), $request->instance_id);

        return back()->withInput(['tab' => 'contact-md']);
    }

    // public function store(Request $request)
    // {
    //     $pricelist = PriceList::find($request->priceList);


    //     $product = Product::where('sku', $request->sku)->where('instance_id', $pricelist->instance_id)->first();


    //     $validatedData = $request->validate([
    //         'sku' => 'required|max:255',
    //         'price' => 'required',
    //         'msrp' => 'required|numeric',
    //         'product_vendor' => 'required',
    //         'currency' => 'required',
    //         ]);


    //         $price = new Price();
    //         $price->product_sku     = $validatedData['sku'];
    //         $price->name            = $product->name;
    //         $price->price           = $validatedData['price'];
    //         $price->msrp            = $validatedData['msrp'];
    //         $price->product_vendor  = $validatedData['product_vendor'];
    //         $price->currency        = $validatedData['currency'];
    //         $price->instance_id     = $pricelist->instance_id;
    //         $price->price_list_id   = $request->price_list_id;


    //         // $price->product()->associate($validatedData['sku']);

    //         $price->pricelist()->associate($pricelist);

    //         $price->save();

    //         return back()->with('success', 'Excel Data Imported successfully');

    //     }


    public function clone($id)
    {


        $pricelist = PriceList::find($id);

        $newClient = $pricelist->replicate();
        $newClient->push(); //Push before to get id of $clone

        foreach ($pricelist->prices as $price) {
            $newClient->prices()->attach($price);
        }

        // $newpricelist = $pricelist->replicate();
        // // $newpricelist->id = $new_id;
        // // $newpricelist->data = $new_data;
        $newClient->save();

        return view('priceList.index', compact('prices'));
    }


    /*public function getResellerPriceList(Request $request, Reseller $reseller)
                {
                    $userLevel = $this->getUserLevel();

                }

                public function getCustomerPriceList(Request $request, Customer $customer)
                {
                    $userLevel = $this->getUserLevel();

                }*/
}
