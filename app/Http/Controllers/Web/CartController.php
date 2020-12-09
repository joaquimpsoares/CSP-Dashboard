<?php

namespace App\Http\Controllers\Web;

use App\Cart;
use App\Order;
use App\Status;
use App\Country;
use App\Product;
use App\Customer;
use App\Instance;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Traits\UserTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\CustomerRepositoryInterface;
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

        $product = $this->productRepository->getByID($validate['product_id']);

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
                'id' => Str::uuid(),
                'quantity' => $product->minimum_quantity
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

            if (!$product->tiers->isEmpty()) {

                $prices = $product->tiers()
                ->where('min_quantity', '<=', $quantity)
                ->where('max_quantity', '>=', $quantity)
                ->first();

                $product->pivot->price = $prices->price;
                $product->pivot->retail_price = $prices->msrp;

            }

            $product->pivot->quantity = $quantity;
            $product->pivot->save();

            return true;

        }


        return false;

    }

    /* For those products who has tiers and have to change
    * the price according to the quantity */
    public function updateProductPriceOnCartByQuantity(Product $product, $quantity) {

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
        $customerTenant = null;

        $subscriptions = $customer->subscriptions;
        foreach ($subscriptions as $subscription) {
            foreach ($subscription->products as $product) {
                if ($product->billing === "license") {
                    $tenant = explode('.onmicrosoft.com', $subscription->tenant_name);
                    $customerTenant = $tenant[0];
                }
            }
        }



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
        if ($this->cartHasTenant($cart))
            return redirect()->route('cart.tenant', ['cart' => $cart->token, 'customerTenant' => $customerTenant]);
        else
            return redirect()->route('cart.review', ['cart' => $cart->token]);
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

        $hasTenant = $this->cartHasTenant($cart);

        return view('order.checkout', compact('cart', 'customers', 'status', 'countries', 'statuses', 'hasTenant'));
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
                $errorMessage = "messages.user_already_exists";
            } else {
                $errorMessage = "messages.error";
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


        // return redirect()->route('cart.tenant', ['cart' => $cart->token]);
        // return back()->withInput();

    }

    public function changeTenant(Request $request)
    {
        $validate = $request->validate([
            'cart' => 'required|uuid|exists:carts,token'
        ]);

        $cart = $this->getUserCart(null, $validate['cart']);
        $canChangeTenant = (empty($cart->agreement_firstname)) ? TRUE : FALSE;


        return view('order.tenant', compact('cart', 'canChangeTenant'));
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
            'cart' => 'required|uuid|exists:carts,token',
            'customerTenant' => 'nullable|string|regex:/(^[A-Za-z0-9 ]+$)+/'
        ]);

        $cart = $this->getUserCart(null, $validate['cart']);
        $canChangeTenant = TRUE;
        $customer = $cart->customer;


        if (!empty($validate['customerTenant'])) {
            $domain = $validate['customerTenant'] . '.onmicrosoft.com';
            $order = $customer->orders()->where('domain', $domain)->first();
            $cart->domain = $validate['customerTenant'];
            $cart->agreement_firstname = $order->agreement_firstname;
            $cart->agreement_lastname = $order->agreement_lastname;
            $cart->agreement_email = $order->agreement_email;
            $cart->agreement_phone = $order->agreement_phone;
            $cart->save();
            $canChangeTenant = FALSE;
        }

        $hasTenant = $this->cartHasTenant($cart);

        if (empty($cart->domain) && empty($cart->agreement_firstname) && $hasTenant) {
            return view('order.tenant', compact('cart', 'canChangeTenant'));
        } else {
            if (empty($cart->agreement_firstname) && $hasTenant){
                return view('order.tenant', compact('cart', 'canChangeTenant'));
            } else {
                return view('order.review', compact('cart', 'canChangeTenant', 'hasTenant'));
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

        $instance = Instance::where('id', '1')->first();

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
            'billing_cycle.*' => 'required|in:annual,monthly,PAYG,none'
        ]);

        $cart = $this->getByToken($validate['token']);

        foreach ($validate['billing_cycle'] as $key => $id) {
            $cartItem = $cart->products()->wherePivot('id', $key)->first();
            $cartItem->pivot->billing_cycle = $id;
            $cartItem->pivot->quantity = $id;
            $cartItem->pivot->save();
        }

        $status = "customer";

        switch ($this->getUserLevel()) {
            case config('app.super_admin'):

                $orders = Order::get()->map->format()->toArray();

			break;

            case config('app.customer'):
                $customers =  $this->getUser()->customer;
                $countries = Country::all();
                $statuses = Status::get();
			break;

            case config('app.provider'):

            break;

            case config('app.reseller'):

                $customers = $this->customerRepository->all();
                $countries = Country::all();
                $statuses = Status::get();

			break;

			default:
			    return abort(403, __('errors.unauthorized_action'));
			break;
		}

        $hasTenant = $this->cartHasTenant($cart);

        return view('order.checkout', compact('cart', 'customers', 'status', 'countries', 'statuses', 'hasTenant'));
    }

    public function cartHasTenant($cart) {
        $hasTenant = false;

        foreach ($cart['products'] as $product) {
            if ($product->vendor === "microsoft") {
                $hasTenant = true;
                break;
            }
        }

        return $hasTenant;
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

    public static  function getUserCart($id = null, $token = null)
    {
        // $user = $this->getUser();
        $user = Auth::user();

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

    public static  function CountCart($id = null, $token = null)
    {
        // $user = $this->getUser();
        $user = Auth::user();

        if (empty($token)) {
            if (empty($id)) {
                $cart = Cart::where('user_id', $user->id)->whereNull('customer_id')->with(['products', 'customer'])->count();
            } else {
                $cart = Cart::where('user_id', $user->id)->where('id', $id)->with(['products', 'customer'])->count();
            }
        } else {
            $cart = Cart::where('user_id', $user->id)->where('token', $token)->with(['products', 'customer'])->count();
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
