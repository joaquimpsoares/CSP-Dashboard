<?php

namespace App\Http\Controllers\Web;

use App\Events\Product\MicrosoftImportProductsEvent;
use App\Http\Controllers\Controller;
use App\Instance;
use App\Jobs\ImportProductsMicrosoft;
use App\Jobs\ImportProductsMicrosoftJob;
use App\MicrosoftConnection\Repositories\AbstractRestV1Repository;
use App\Product;
use App\Repositories\ProductRepositoryInterface;
use App\Vendor;
use Illuminate\Http\Request;
use Tagydes\MicrosoftConnection\Facades\Product as MicrosoftProduct;


class ProductController extends Controller
{
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $products = Product::all();

        return  view('product.index', compact('products'));
    }

    public function index2()
    {
        $products = $this->productRepository->all();
        return  $products;
    }

    public function create()
    {}


    public function store(Request $request)
    {}


    public function show(Product $product)
    {}


    public function edit(Product $product)
    {}


    public function update(Request $request, Product $product)
    {
        $product = Product::findOrFail($request);

        $this->validate($request, [
            'name' => 'String',
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

            'name' => $product->name,
            'description' => $product->description,
            'uri' => $product->uri,
            'minimum_quantity' => $product->minimum_quantity,
            'maximum_quantity' => $product->maximum_quantity,
            'limit' => $product->limit,
            'term' => $product->term,
            'is_available_for_purchase' => $product->is_available_for_purchase,
            'locale' => $product->locale,
            'country' => $product->country,
            'is_trial' => $product->is_trial,
            'has_addons' => $product->has_addons,
            'is_autoRenewable' => $product->is_autoRenewable,
            'billing' => $product->billing,
            'acquisition_type' => $product->acquisition_type,
            'supported_billing_cycles' => $product->supported_billing_cycles,

        ]);

        $instance->update($request->all());
    }


    public function destroy(Product $product)
    {}

    public function getMasterToken()
    {
        $instance = Instance::first();

        if( !$instance){
            return redirect()->route('products.list')->with('success', 'The account has no assigned instance');
        }
        
        if( ! $instance->external_token){
            $externalToken = MicrosoftProduct::getMasterTokenFromAuthorizedClientId($instance->external_id);
            $instance->update([
                'external_token' => $externalToken,
                'external_token_updated_at' => now()
            ]);
        }
        return redirect()->route('dashboard')->with('success', 'Instance updated succesfully');
    }


    /**
     * Import Products from Microsoft
     *
     * @return void
     */
    public function import()
    {
        $instance = Instance::first();
        if( ! $instance){
            return redirect()->route('products.index')->with('success', 'The account has no assigned instance');
        }
        
        if($instance->provider === 'microsoft'){
            if( ! $instance->external_id){
                return redirect()->route('products.index')->with('success', 'There is no client_id set up on the Microsoft instance');
            }
            
            if( ! $instance->external_token){
                $externalToken = MicrosoftProduct::getMasterTokenFromAuthorizedClientId($instance->external_id);
                $instance->update([
                    'external_token' => $externalToken,
                    'external_token_updated_at' => now()
                ]);
            }

            ImportProductsMicrosoftJob::dispatch()->onQueue('SyncProducts')
            ->delay(now()->addSeconds(10));            
        }

        return redirect()->route('jobs')->with(['alert' => 'success', 'message' => trans('messages.importproducts')]);
    }


}

