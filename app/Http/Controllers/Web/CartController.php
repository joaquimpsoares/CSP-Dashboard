<?php

namespace App\Http\Controllers\Web;

use App\Cart;
use App\Country;
use App\Customer;
use App\Http\Controllers\Controller;
use App\Http\Traits\UserTrait;
use App\Instance;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tagydes\MicrosoftConnection\Facades\Customer as MicrosoftCustomer;

class CartController extends Controller
{

    use UserTrait;
    private $customerRepository;
    private $productRepository;
    private $userRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository, ProductRepositoryInterface $productRepository, UserRepositoryInterface $userRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
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

    public function addCustomer(Request $request)
    {
        $validate = $request->validate([
            'customer_id' => 'required|integer|exists:customers,id',
            'cart' => 'required|uuid|exists:carts,token'
        ]);

        $customer = Customer::find($validate['customer_id']);

        /* Check if can buy to this customer */
        if (!$this->customerRepository->canInteractWithCustomer($customer)) {
            return abort(401);
        }
        /* End Check */

        $cart = $this->getUserCart(null, $validate['cart']);

        $cart->customer()->associate($customer);
        
        $cart->save();

        $status = "tenant";
        
        //return view('order.tenant', compact('cart'));
        return redirect()->route('cart.tenant', ['cart' => $cart->token]);
    }

    public function changeCustomer(Request $request)
    {
        $validate = $request->validate([
            'cart' => 'required|uuid|exists:carts,token'
        ]);

        $cart = $this->getUserCart(null, $validate['cart']);
        $status = "customer";

        $customers = $this->customerRepository->all();
        $countries = Country::all();
        $statuses = Status::get();

        return view('order.checkout', compact('cart', 'customers', 'status', 'countries', 'statuses'));
    }

    public function storeCustomerAndBuy(Request $request) { 

        $validate = $request->validate([
            'company_name' => ['required', 'string', 'regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/', 'max:255'],
            'nif' => ['required', 'string', 'regex:/^[0-9A-Za-z.\-_:]+$/', 'max:20'],
            'email' => ['required', 'email', 'max:255'],
            'address_1' => ['required', 'string', 'max:255'],
            'address_2' => ['nullable', 'string', 'max:255'],
            'country_id' => ['required', 'integer', 'min:1'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'regex:/^[0-9A-Za-z.\-]+$/', 'max:255'],
            'status_id' => ['required', 'integer', 'exists:statuses,id'],
            'sendInvitation' => ['nullable', 'integer'],
            'cart' => 'required|uuid|exists:carts,token'
        ]);
        
        $user = $this->getUser();
        
        try {
            DB::beginTransaction();
            
            $customer = $this->customerRepository->create($validate);
            
            $customer->resellers()->attach($user->reseller->id);
            
            $mainUser = $this->userRepository->create($validate, 'customer', $customer);
            
            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
            if ($e->errorInfo[1] == 1062) {
                $errorMessage = "message.user_already_exists";
            } else {
                $errorMessage = "message.error";
            }
            return redirect()->route('customer.index')
            ->with([
                'alert' => 'danger', 
                'message' => trans('messages.customer_not_created') . " (" . trans($errorMessage) . ")."
            ]);
        }

        $cart = $this->getUserCart(null, $validate['cart']);

        $cart->customer()->associate($customer);
        
        $cart->save();

        $status = "tenant";
        
        //return view('order.tenant', compact('cart'));
        return redirect()->route('cart.tenant', ['cart' => $cart->token]);
        
    }

    public function changeTenant(Request $request)
    {
        $validate = $request->validate([
            'cart' => 'required|uuid|exists:carts,token'
        ]);

        $cart = $this->getUserCart(null, $validate['cart']);
        
        return view('order.tenant', compact('cart'));
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

        return redirect()->route('cart.review', ['cart' => $cart->token]);
    }

    public function continueCheckout(Request $request)
    {
        $validate = $request->validate([
            'cart' => 'required|uuid|exists:carts,token'
        ]);

        $cart = $this->getUserCart(null, $validate['cart']);
        //dd($cart);

        if (empty($cart->domain) && empty($cart->agreement_firstname)) {
            return view('order.tenant', compact('cart'));
        } else {
            if (empty($cart->agreement_firstname)){
                return view('order.tenant', compact('cart'));
            } else {
                return view('order.review', compact('cart'));
            }
        }
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

            if (MicrosoftCustomer::withCredentials($instance->external_id, $instance->external_token)->getDomainAvailability($domain)){

                $cart->domain = $domain;
                $cart->save();

                return true;

            } else {
                return abort(401);
            }            
        }
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

        $status = "customer";

        $customers = $this->customerRepository->all();
        $countries = Country::all();
        $statuses = Status::get();

        return view('order.checkout', compact('cart', 'customers', 'status', 'countries', 'statuses'));
    }

    /*public function checkout(Request $request)
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

        $status = "customer";

        $customers = $this->customerRepository->all();

        return view('order.checkout', compact('cart', 'customers', 'status'));
    }*/

    public function getMainUser(Request $request)
    {
        $validate = $request->validate([
            'token' => 'required|uuid'
        ]);

        $cart = $this->getByToken($validate['token']);

        $user = $cart->customer->users->first();

        return $user;
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

    

    public function pendingCheckout(Request $request)
    {

        $validate = $request->validate([
            'token' => 'required|uuid',

        ]);

        $cart = $this->getByToken($validate['token']);

        $customers = $this->customerRepository->all();

        return view('order.checkout', compact('cart', 'customers'));
    }

    private function getUserCart($id = null, $token = null)
    {
        $user = $this->getUser();

        if (empty($token)) {
            if (empty($id)) {
                $cart = Cart::where('user_id', $user->id)->whereNull('customer_id')->with(['products', 'customer'])->first();
            } else {
                $cart = Cart::where('user_id', $user->id)->where('id', $id)->with(['products', 'customer'])->first();
            }
        } else {
            $cart = Cart::where('user_id', $user->id)->where('token', $token)->with(['products', 'customer'])->first();
        }

        return $cart;
    }

    private function getByToken($token)
    {
        $user = $this->getUser();

        $cart = Cart::where('token', $token)->with('products')->first();

        if ($user->id !== $cart->user_id)
            return abort(401);

        return $cart;
    }


}
