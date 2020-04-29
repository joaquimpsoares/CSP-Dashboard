<?php

namespace App\Http\Controllers\Web;

use App\Cart;
use App\Customer;
use App\Http\Controllers\Controller;
use App\Instance;
use App\Product;
use App\Repositories\CustomerRepositoryInterface;
use Illuminate\Http\Request;
use Session;
use Tagydes\MicrosoftConnection\Facades\Customer as MicrosoftCustomer;

class CartController extends Controller
{

    private $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function index() {
        $cart = [];
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        return view('order.cart', ['products' => $cart]);
    }

    public function addProduct(Request $request, Product $product)
    {
    	
    	$oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product);
        ($cart->items[$product->id]['quantity']);
        $request->session()->put('cart', $cart);
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

    public function removeProduct(Request $request, Product $product)
    {

        $cart = Session::has('cart') ? Session::get('cart') : null;

        if (!empty($cart)) {
            unset($cart->items[$product->id]);
        }

        return redirect()->route('cart.index');
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
