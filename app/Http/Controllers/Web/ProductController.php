<?php

namespace App\Http\Controllers\Web;

use App\Tier;
use App\Country;
use App\Product;
use App\Instance;
use App\Provider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\ImportProductsMicrosoftJob;
use App\Price;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use Tagydes\MicrosoftConnection\Facades\Product as MicrosoftProduct;


class ProductController extends Controller
{
    public $id;
    private $productRepository;
    private $orderRepository;


    public function __construct(ProductRepositoryInterface $productRepository, OrderRepositoryInterface $orderRepository)
    {
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;


    }

    public function index()
    {
        
        $products = $this->productRepository->showall();

        // $products = Product::all();

        return  view('product.index', compact('products'));
    }

    public function index2()
    {
        $products = $this->productRepository->all();
        return  $products;
    }

    public function create()
    {
        // dd(Tier::get());
        // dd($product = Price::first()->tiers);
        $instances = Instance::get();

        return view('product.create', compact('instances'));
    }


    public function store(Request $request)
    {
        //dd($request->all());
        $product = new Product();
            $product->vendor       = $request->vendor;
            $product->instance_id       = '3';

            $product->sku                       = $request->sku;
            $product->name                      = $request->name;
            $product->description               = $request->description;
            $product->category                  = $request->category;
            $product->addons                        = $request->addons;
            $product->minimum_quantity              = $request->minimum_quantity;
            $product->maximum_quantity              = $request->maximum_quantity;
            $product->limit                         = $request->limit;
            $product->billing                        = $request->billing;
            $product->supported_billing_cycles       = $request->supported_billing_cycles;
            $product->category                       = $request->category;
            $product->resellee_qualifications        = $request->resellee_qualifications;
            // $product->name       = $request->name;
            // $product->name       = $request->name;
            // $product->name       = $request->name;
          
            $product->save();

        return back();

    }


    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('product.show', compact('product'));
    }


    public function edit(Product $product)
    {
        // foreach ($product as $key => $product) {
            $addons = $product->getaddons()->all();
            // dd($addons);
        // }



        return view('product.edit', compact('product','addons'));
    }


    public function update(Request $request, Product $product)
    {

        $product = Product::findOrFail($product->id);

        $this->validate($request, [
            'name' => 'required|String',
            'minimum_quantity' => 'Integer',
            'maximumQuantity' => 'Integer',
            'limit' => 'Integer',
            'term' => 'String',
            'isAvailableForPurchase' => 'Integer',
            'locale' => 'String',
            'country' => 'String',
            'isTrial' => 'String',
            'hasAddOns' => 'String',
            'isAutoRenewable' => 'String',
            'billing' => 'String',
            'acquisitionType' => 'String',
            'supportedBillingCycles' => 'String',
            'conversionTargetOffers' => 'String',
            'reselleeQualifications' => 'String',
            'resellerQualifications' => 'String'
        ]);

        $product->update([

            'name' => $request->name,
            'description' => $request->description,
            'uri' => $request->uri,
            'category' => $request->category,
            'minimum_quantity' => $request->minimum_quantity,
            'maximum_quantity' => $request->maximum_quantity,
            'limit' => $request->limit,
            'term' => $request->term,
            'is_available_for_purchase' => $request->is_available_for_purchase,
            'locale' => $request->locale,
            'country' => $request->country,
            'is_trial' => $request->is_trial,
            'has_addons' => $request->has_addons,
            'is_autoRenewable' => $request->is_autoRenewable,
            'billing' => $request->billing,
            'acquisition_type' => $request->acquisition_type,
            'supported_billing_cycles' => $request->supported_billing_cycles,

            ]);
            
            return back()->withInput();

    }


    public function destroy(Product $product)
    {}

    public function getMasterToken($id)
    {
        $instance = Instance::findorFail($id);

        if( !$instance){
            return redirect()->back()->with('warning', 'The account has no assigned tenant');
        }
        
        if( ! $instance->external_token){
            $externalToken = MicrosoftProduct::getMasterTokenFromAuthorizedClientId($instance->tenant_id);
            $instance->update([
                'external_token' => $externalToken,
                'external_token_updated_at' => now()
            ]);
        }
        return redirect()->back()->with('success', 'Instance updated succesfully');
    }


    /**
     * Import Products from Microsoft
     *
     * @return void
     */
    public function import($id)
    {

        $order = $this->orderRepository->ImportProductsMicrosoftOrder();

        $provider = Provider::where('id', $id)->select('country_id')->first();

        $country = Country::select('iso_3166_2')->where('id', $provider->country_id)->first();
        

        $instance = Instance::where('provider_id', $id)->first();

        if( ! $instance){
            return redirect()->route('products.index')->with('success', 'The account has no assigned instance');
        }
        
        if($instance->type === 'microsoft'){
            if( ! $instance->tenant_id){
                return redirect()->route('products.index')->with('success', 'There is no client_id set up on the Microsoft instance');
            }
            
            if( ! $instance->external_token){
                $externalToken = MicrosoftProduct::getMasterTokenFromAuthorizedClientId($instance->tenant_id);
                $instance->update([
                    'external_token' => $externalToken,
                    'external_token_updated_at' => now()
                ]);
            }

            ImportProductsMicrosoftJob::dispatch($instance, $order, $country->iso_3166_2)->onQueue('SyncProducts')
            ->delay(now()->addSeconds(10));            
        }

        return redirect()->route('jobs')->with(['alert' => 'success', 'message' => trans('messages.importproducts')]);
    }


}

