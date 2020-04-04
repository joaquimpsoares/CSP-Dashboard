<?php

namespace App\Http\Controllers\Web;

use App\Events\Product\MicrosoftImportProductsEvent;
use App\Http\Controllers\Controller;
use App\Instance;
use App\Jobs\ImportProductsMicrosoft;
use App\Jobs\ImportProductsMicrosoftJob;
use Tagydes\MicrosoftConnection\Facades\Product as MicrosoftProduct;

use App\MicrosoftConnection\Repositories\AbstractRestV1Repository;
use App\Product;
use App\Vendor;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public $quantity = 12;

    public function index(Request $request)
    {


        $filters = $request->validate([
            'name' => 'string|nullable',
            'vendor' => 'nullable|exists:App\Vendor,name',
            'search' => 'integer|size:1',
            'page' => 'integer',
            'quantity' => 'integer'
        ]);

        if (isset($filters['quantity']) && $filters['quantity'] > 0 && $filters['quantity'] !== 12) $this->quantity = $filters['quantity'];



        if (isset($filters['search'])) {
            $products = self::searchFilter($request, $this->quantity);
        } else {
            $products = Product::where('addons', '<>', '[]')->orderBy('vendor')->orderBy('name')->paginate($this->quantity);
        }

        $vendors = Vendor::orderBy('name')->get();
        $quantity = $this->quantity;

        //$products = Product::all();
        return view('product.index', compact('products', 'vendors', 'filters', 'quantity'));
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
        $product = Product::findOrFail($id);

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

        // $instance->update($request->all());

        return redirect()->route('products.list')->with('success', 'Instance updated succesfully');
    }


    public function destroy(Product $product)
    {}

    public function getMasterToken()
    {
        $instance = Instance::first();

        if( !$instance){
            return redirect()->route('products.list')->with('success', 'The account has no assigned instance');
        }

        if($instance->provider === 'microsoft'){
            if( ! $instance->external_id){
                return redirect()->route('products.list')->with('success', 'There is no client_id set up on the Microsoft instance');
            }

            if( ! $instance->external_token){
                $externalToken = MicrosoftProduct::getMasterTokenFromAuthorizedClientId($instance->external_id);
                $instance->update([
                    'external_token' => $externalToken,
                    'external_token_updated_at' => now()
                ]);
            }
        }
        return redirect()->route('dashboard')->with('success', 'Instance updated succesfully');
    }

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

            $products = MicrosoftProduct::withCredentials($instance->external_id, $instance->external_token)->all();

            $products->each(function($importedProduct)use($instance){
                Product::updateOrCreate([
                    'sku' => $importedProduct->id,
                    'instance_id' => $instance->id
                ],[
                    'name' => $importedProduct->name,
                    'description' => $importedProduct->description,
                    'uri' => $importedProduct->uri,

                    'minimum_quantity' => $importedProduct->minimumQuantity,
                    'maximum_quantity' => $importedProduct->maximumQuantity,
                    'limit' => $importedProduct->limit,
                    'term' => $importedProduct->term,
                    'category' => $importedProduct->category,

                    'locale' => $importedProduct->locale,
                    'country' => $importedProduct->country,

                    'is_trial' => $importedProduct->isTrial,
                    'has_addons' => $importedProduct->hasAddOns,
                    'is_autorenewable' => $importedProduct->isAutoRenewable,

                    'billing' => $importedProduct->billing,
                    'acquisition_type' => $importedProduct->acquisitionType,

                    'addons' => $importedProduct->addons->map(function($item){
                        return serialize($item);
                    }),
                    'supported_billing_cycles' => $importedProduct->supportedBillingCycles,
                    'conversion_target_offers' => $importedProduct->conversionTargetOffers,
                    'resellee_qualifications' => $importedProduct->reselleeQualifications,
                    'reseller_qualifications' => $importedProduct->resellerQualifications,
                    ]);
                });
            }


        // ImportProductsMicrosoftJob::dispatch()
        //         ->delay(now()->addSeconds(10));

        return redirect()->route('products.index')->with(['alert' => 'success', 'message' => trans('messages.example')]);
    }

    private static function searchFilter(Request $filters, $quantity) {

        $products = (new Product)->newQuery();

        if ($filters->has('name')) {
            $products->where('name', 'like', '%' . $filters->input('name') . '%');
        }

        if ($filters->has('vendor') && !empty($filters->input('vendor')) ) {
            $products->where('vendor', $filters->input('vendor'));
        }

        return $products->where('addons', '<>', '[]')->paginate($quantity);

    }
}
