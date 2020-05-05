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

        $cart = $this->getUserCart();

        return view('order.cart', compact('cart'));
    }

    public function getPending() {
        $user = $this->getUser();
        $carts = Cart::where('user_id', $user->id)->get();

        return view('order.pending_carts', compact('carts'));
    }

    public function addProductToCart(Request $request)
    {

        $validate = $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        // if product aren't on the prices table doesn't add to the cart and continue
        if ($prices = $this->productRepository->getPriceOf($validate['product_id'])) {

            $cart = $this->getUserCart();

            if (! $cart) {
                $cart = new Cart();
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

        $cart = $this->getUserCart();

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

        $cart = $this->getUserCart();

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
            return abort(401);
        }
        /* End Check */

        $cart = $this->getUserCart();

        $cart->customer()->associate($customer);

        $cart->save();
        
        return true;
    }

    public function checkDomainAvailability(Request $request) {

        $validate = $request->validate([
            'token' => 'required|uuid',
            'domain' => 'required|string|regex:/(^[A-Za-z0-9 ]+$)+/'
        ]);

        $cart = $this->getByToken($validate['token']);

        $domain = $validate['domain'] . ".onmicrosoft.com";

        $instance = Instance::first();
        
        if($instance->type === 'microsoft'){
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

                $cart->domain = $domain;
                $cart->save();

                return true;
            } else {
                return abort(401);
            }

            
            
        }

        return abort(401);
    }

    public function getMainUser(Request $request)
    {
        $validate = $request->validate([
            'token' => 'required|uuid'
        ]);

        $cart = $this->getByToken($validate['token']);

        $user = $cart->customer->users->first();

        return $user;
    }

    public function addMCAUser(Request $request)
    {
        $validate = $request->validate([
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|email:rfc,dns',
            'phoneNumber' => 'string|nullable',
            'token' => 'required|uuid'
        ]);


        $cart = $this->getByToken($validate['token']);

        $cart->agreement_firstname = $validate['firstName'];
        $cart->agreement_lastname = $validate['lastName'];
        $cart->agreement_email = $validate['email'];
        $cart->agreement_phone = $validate['phoneNumber'];
        $cart->save();

        return true;
    }

    

    public function destroy()
    {
        $cart = $this->getUserCart();
        $cart->delete();

        return redirect()->route('cart.index');
    }

    public function changeBillingCycle(Request $request)
    {
        $validate = $request->validate([
            'token' => 'required|uuid',
            'item' => 'required|uuid',
            'value' => 'required|in:annual,monthly,none'
        ]);

        $cart = $this->getByToken($validate['token']);

        $cartItem = $cart->products()->wherePivot('id', $validate['item'])->first();
        $cartItem->pivot->billing_cycle = $validate['value'];
        $cartItem->pivot->save();

        return true;
    }

    public function checkout(Request $request)
    {

        $validate = $request->validate([
            'token' => 'required|uuid',
            'billing_cycle.*' => 'required|in:annual,monthly,none'
        ]);

        $cart = $this->getByToken($validate['token']);

        foreach ($validate['billing_cycle'] as $key => $id) {
            $cartItem = $cart->products()->wherePivot('id', $key)->first();
            $cartItem->pivot->billing_cycle = $id;
            $cartItem->pivot->save();
        }

        $customers = $this->customerRepository->all();

        return view('order.checkout', compact('cart', 'customers'));
    }

    public function pendingCheckout(Request $request)
    {

        $validate = $request->validate([
            'token' => 'required|uuid',
            
        ]);

        $cart = $this->getByToken($validate['token']);

        $customers = $this->customerRepository->all();

        return view('order.checkout', compact('cart', 'customers'));
    }

    private function getUserCart()
    {
        $user = $this->getUser();
        $cart = Cart::where('user_id', $user->id)->whereNull('customer_id')->with('products')->first();
        
        return $cart;
    }

    private function getByToken($token)
    {
        $user = $this->getUser();

        $cart = Cart::where('token', $token)->first();

        if ($user->id !== $cart->user_id)
            return abort(401);

        return $cart;
    }

    
}
