<?php

namespace App\Http\Controllers\Web;

use App\Cart;
use App\Customer;
use App\Http\Controllers\Controller;
use App\Http\Traits\UserTrait;
use App\Instance;
use App\Product;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Session;
use Tagydes\MicrosoftConnection\Facades\Customer as MicrosoftCustomer;

class CartController extends Controller
{

    use UserTrait;
    private $customerRepository;
    private $productRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository, ProductRepositoryInterface $productRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->productRepository = $productRepository;
    }

    public function index() {
        $user = $this->getUser();
        $cart = Cart::where('user_id', $user->id)->whereNull('customer_id')->with('products')->first();

        return view('order.cart', compact('cart'));
    }

    public function addProductToCart(Request $request)
    {

        $validate = $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        // if product aren't on the prices table doesn't add to the cart and continue
        if ($prices = $this->productRepository->getPriceOf($validate['product_id'])) {

            $user = $this->getUser();

            $cart = Cart::where('user_id', $user->id)->first();

            if (! $cart) {
                $cart = new Cart($user->id);
            }

            $cart->save();

            $cart->products()->attach($validate['product_id'], [
                'price' => $prices->price,
                'retail_price' => $prices->msrp,
                'id' => Str::uuid()
            ]);
        }
        

        return redirect()->route('cart.index');
    }

    public function changeProductQuantity(Request $request, $item_id, $quantity) {
        $user = $this->getUser();

        $cart = Cart::where('user_id', $user->id)->first();

        $product = $cart->products->first(function ($value) use ($item_id) {    
            return $value->pivot->id == $item_id;
        });

        if ($this->productRepository->verifyQuantities($product, $quantity)) {
            $product->pivot->quantity = $quantity;
            $product->pivot->save();
            return true;
        }        

        return false;

    }

    public function removeItem(Request $request, $item_id)
    {

        $user = $this->getUser();

        $cart = Cart::where('user_id', $user->id)->first();

        $product = $cart->products->first(function ($value) use ($item_id) {    
            return $value->pivot->id == $item_id;                
        });

        $cart->products()->wherePivot('id', $item_id)->detach();

        return redirect()->route('cart.index');
    }

    public function addCustomer(Request $request, Customer $customer)
    {

        /* Check if can buy to this customer */
        if (!$this->customerRepository->canInteractWithCustomer($customer)) {
            return abort(500);
        }
        /* End Check */

        $cart = [];
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        $cart->addCustomer($customer->format());
        $request->session()->put('cart', $cart);

        return true;
    }

    public function checkDomainAvailability(Request $request, $domain) {

        $domain = $domain . ".onmicrosoft.com";

        $instance = Instance::first();

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
            
            if (MicrosoftCustomer::withCredentials($instance->external_id, $instance->external_token)->getDomainAvailability($domain)){

                $oldCart = Session::get('cart');
                $cart = new Cart($oldCart);

                $cart->addDomain($domain);
                $request->session()->put('cart', $cart);

                return true;
            } else {
                return abort(500);
            }

            
        }
    }

    public function addMCAUser(Request $request)
    {
        $validate = $request->validate([
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|email:rfc,dns',
            'phoneNumber' => 'string|nullable'
        ]);


        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $request->session()->put('cart', $cart);

        $cart->addMCAUser($validate);

        return true;
    }

    

    public function destroy()
    {
        Session::forget('cart');

        return redirect()->route('cart.index');
    }

    public function checkout()
    {
        $cart = [];
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        $customers = $this->customerRepository->all();

        return view('order.checkout', ['products' => $cart, 'customers' => $customers]);
    }
}
