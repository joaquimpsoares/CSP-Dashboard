<?php

namespace App\Http\Controllers\Web;

use App\User;
use App\Order;
use App\Status;
use App\Country;
use App\Customer;
use App\Instance;
use App\Provider;
use App\Reseller;
use Carbon\Carbon;
use App\OrderProducts;
use App\Models\Activities;
use App\Models\LogActivity;
use App\Http\Traits\UserTrait;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\ProviderRepositoryInterface;
use App\Repositories\ResellerRepositoryInterface;
use App\Repositories\SubscriptionRepositoryInterface;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;

class HomeController extends Controller
{

    use UserTrait;

    private $userRepository;
    private $providerRepository;
    private $resellerRepository;
    private $customerRepository;
    private $subscriptionRepository;

    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct(ProviderRepositoryInterface $providerRepository, SubscriptionRepositoryInterface $subscriptionRepository,
    ResellerRepositoryInterface $resellerRepository, CustomerRepositoryInterface $customerRepository,
    ProductRepositoryInterface $productRepository, OrderRepositoryInterface $orderRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
        $this->providerRepository = $providerRepository;
        $this->resellerRepository = $resellerRepository;
        $this->customerRepository = $customerRepository;
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
        $this->middleware('auth');
    }

    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */
    public function index(Provider $provider)
    {

        $user = $this->getUser();

        switch ($this->getUserLevel()) {
            case config('app.super_admin'):

                $provider_id = Auth::getUser()->provider_id;
                $orders= Order::first();

                $orderMonth = Order::whereMonth(
                    'created_at', '=', Carbon::now()->subMonth()->month
                );

                if($orders){
                    $countOrders = ($orders->count()-$orderMonth->count());
                }
                $countOrders = 0;

                $statuses = Status::get();
                $providers = $this->providerRepository->all();
                $provider = Reseller::get();
                $customersweek = Customer::whereMonth(
                    'created_at', '=', Carbon::now()->subWeekdays('1')
                )->get();

                $topProducts = OrderProducts::with('Order')->get();

                $topProducts = OrderProducts::with(['Product' => function($query){
                    $query->groupBy('name');
                }])->get();


                return view('home', compact('providers','provider','orders','countOrders','customersweek','topProducts'));

            break;

            case config('app.admin'):
                $provider_id = Auth::getUser()->provider_id;
                $orders= Order::first();

                $orderMonth = Order::whereMonth(
                    'created_at', '=', Carbon::now()->subMonth()->month
                );
                if($orders){
                    $countOrders = ($orders->count()-$orderMonth->count());
                }
                $countOrders = 0;


                $statuses = Status::get();
                $providers = $this->providerRepository->all();
                $provider = $this->providerRepository->all();
                $customersweek = Customer::whereMonth(
                    'created_at', '=', Carbon::now()->subWeekdays('1')
                )->get();

                $topProducts = OrderProducts::with('Order')->get();

                $topProducts = OrderProducts::with(['Product' => function($query){
                    $query->groupBy('name');
                }])->get();


                return view('home', compact('providers','provider','orders','countOrders','customersweek','topProducts'));

            break;

            case config('app.provider'):

                $orders= Order::first();
                $provider = Auth::getUser()->provider;

                foreach ($provider->resellers as $reseller) {
                    foreach ($reseller->customers()->get(['id']) as $customer) {
                        $customers[] = $customer->id;
                    }
                }

                $orderMonth = Order::whereMonth(
                    'created_at', '=', Carbon::now()->subMonth()->month
                );
                if($orders){
                    $countOrders = ($orders->count()-$orderMonth->count());
                }
                $countOrders = 0;
                $statuses = Status::get();
                $resellers = $this->resellerRepository->all();
                $customersweek = Customer::whereMonth(
                    'created_at', '=', Carbon::now()->subWeekdays('1')
                )->get();



                // $topProducts = OrderProducts::with('Order')->get();
                $topProducts = customer::with('orders')->get();


                return view('home', compact('resellers','orders','countOrders','customersweek','topProducts','provider','customers'));


            break;

            case config('app.reseller'):

                $countCustomers = $user->reseller->customers->count();
                $subscriptions = $this->resellerRepository->getSubscriptions($user->reseller);
                $countSubscriptions = $subscriptions->count();


                $orders = $this->orderRepository->all();
                if($orders != '0'){
                $countOrders = $orders->count();
                }
                $countOrders = 0;

                return view('reseller.partials.home', compact('countCustomers','countSubscriptions','countOrders'));

            break;

            case config('app.subreseller'):

            break;

            case config('app.customer'):
                $customer = $this->getUser()->customer;
                $subscriptions = $this->listFromCustomer($customer);

                return view('subscriptions.customer', compact('subscriptions', 'customer'));

            break;

            default:
            return abort(403, __('errors.unauthorized_action'));

        break;
    }


    $provider_id = Auth::getUser()->provider_id;
    $provider = Provider::where('id', $provider_id)->first();



    $statuses = Status::get();


    $countries = Country::all();
    $resellers = $this->resellerRepository->resellersOfProvider($provider);
    $customers = new Collection();

    foreach ($resellers as $reseller){
        $reseller = Reseller::find($reseller['id']);
        $customers = $customers->merge($this->customerRepository->customersOfReseller($reseller));
    }

    $reseller = Reseller::get();
    $countResellers = $reseller->count();

    $instance = Instance::first();

    $order = OrderProducts::get();

    $users = User::where('provider_id', $provider->id)->first();

    $subscriptions = $this->providerRepository->getSubscriptions($provider);
    $countCustomers =  $customers->count();
    $countSubscriptions = $subscriptions->count();

    $countries = Country::all();
    $providers = $this->providerRepository->all();
    return view('home', compact('provider','resellers','customers','instance','users',
    'countries','subscriptions','order','statuses','countResellers',
    'countCustomers','countSubscriptions','providers','countries'));
}

    public function listFromCustomer(Customer $customer)
    {
        $subscriptions = $this->customerRepository->getSubscriptions($customer);

        return $subscriptions;
    }

    public function dashboard()
    {
        return view('dashboard');
    }


    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */
    public function userLogInfo()
    {
        $logs = LogActivity::latest()->get();
        return view('user.loginfo',compact('logs'));
    }

    public function logActivity()
    {
        $logs = Activities::latest()->get();
        return view('user.logactivity',compact('logs'));
    }
}
