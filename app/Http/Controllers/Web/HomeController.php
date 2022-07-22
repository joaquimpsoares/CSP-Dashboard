<?php

namespace App\Http\Controllers\Web;

use App\News;
use App\User;
use App\Order;
use App\Country;
use App\Customer;
use App\Instance;
use App\Provider;
use App\Reseller;
use Carbon\Carbon;
use App\Subscription;
use App\Models\Status;
use App\OrderProducts;
use App\Models\Activities;
use App\Models\LogActivity;
// use App\Models\MsftInvoices;
use App\Http\Traits\UserTrait;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\ProviderRepositoryInterface;
use App\Repositories\ResellerRepositoryInterface;
use App\Repositories\SubscriptionRepositoryInterface;

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
                $orders= Order::first();

                $subscriptions = $subscriptions = Subscription::with(['customer','products','status'])->get();
                $resellers = Reseller::all();
                $providers = Provider::get();
                $customers = Customer::get();

                $news = News::orderBy('id', 'DESC')->take(4)->get();

                $subscriptions = $this->subscriptionRepository->all();
                $news = News::orderBy('created_at', 'desc')->take(4)->get();


                $previousMonth = Order::select([
                    DB::raw('DATE(created_at) AS date'),
                    DB::raw('COUNT(id) AS count'),
                ])
                ->whereMonth('created_at', Carbon::now()->subMonth(1)->month)
                ->groupBy('date')
                ->orderBy('date', 'ASC')
                ->get()
                ->toArray();

                $chartDataPreviousByDay = [];
                foreach ($previousMonth as $data) {
                    $chartDataPreviousByDay[] = $data['count'];
                }

                $currentMonth = Order::select([
                    DB::raw('DATE(created_at) AS date'),
                    DB::raw('COUNT(id) AS count'),
                ])
                ->whereMonth('created_at', [Carbon::now()->subMonth(0)->month])
                ->groupBy('date')
                ->orderBy('date', 'ASC')
                ->get()
                ->toArray();


                $chartDataCurrentByDay = [];
                foreach ($currentMonth as $data) {
                    // $chartDataCurrentByDay[$data['date']] = $data['count'];
                    $chartDataCurrentByDay[] = $data['count'];
                }

                $chartDataTotalOrders = array_sum($chartDataCurrentByDay)+array_sum($chartDataPreviousByDay);


                $revenue = Order::select()
                ->with('orderproduct','subscriptions')
                ->where('order_status_id', '4')
                ->whereMonth('created_at', [Carbon::now()->subMonth(0)->month])
                ->get();

                $ChartRevenew = [];
                foreach ($revenue as $data) {
                    if($data->orderproduct != null){
                        $ChartRevenew[] = $data->orderproduct['retail_price']*$data->orderproduct['quantity'];
                    }
                }

                $resellercurrentMonth = Reseller::select([
                    DB::raw('DATE(created_at) AS date'),
                    DB::raw('COUNT(id) AS count'),
                ])
                ->whereMonth('created_at', [Carbon::now()->subMonth(0)->month])
                ->groupBy('date')
                ->orderBy('date', 'ASC')
                ->get()
                ->toArray();

                $chartDataCurrentResellerByDay = [];
                foreach ($resellercurrentMonth as $data) {
                    // $chartDataCurrentByDay[$data['date']] = $data['count'];
                    $chartDataCurrentResellerByDay[] = $data['count'];
                }

                $customercurrentMonth = Customer::select([
                    DB::raw('DATE(created_at) AS date'),
                    DB::raw('COUNT(id) AS count'),
                ])
                ->whereMonth('created_at', [Carbon::now()->subMonth(0)->month])
                ->groupBy('date')
                ->orderBy('date', 'ASC')
                ->get()
                ->toArray();

                $chartDataCurrentCustomerByDay = [];
                foreach ($customercurrentMonth as $data) {
                    // $chartDataCurrentByDay[$data['date']] = $data['count'];
                    $chartDataCurrentCustomerByDay[] = $data['count'];
                }

                $subscriptionsperMonth = Subscription::select(
                    DB::raw('SUM(amount) AS count'),
                    DB::raw("MONTHNAME(created_at) as monthname"))
                    ->whereYear('created_at', date('Y', strtotime('-1 year')))
                    ->where('billing_type', 'license')
                    ->groupBy('monthname')
                    ->get()
                    ->toArray();



                $chartDataSubscriptionYear = [];
                foreach ($subscriptionsperMonth as $data) {
                    $chartDataSubscriptionYear[$data['monthname']] = $data['count'];
                    // $chartDataCurrentCustomerByDay[] = $data['count'];
                }


            $top5Products = Subscription::select('name')
                ->where('status_id', '1')
                ->selectRaw('COALESCE(sum(amount),0) total')
                ->groupBy('id')
                ->orderBy('total','desc')
                ->take(5)
                ->get()
                ->toArray();

                // dd($top5Products);

                $Top5LicensesSubscriptions = [];
                foreach ($top5Products as $data) {
                    $Top5LicensesSubscriptions[$data['name']] = $data['total'];
                }



            return view('home', compact('Top5LicensesSubscriptions', 'chartDataSubscriptionYear','chartDataCurrentCustomerByDay','chartDataCurrentResellerByDay',
            'ChartRevenew','chartDataTotalOrders','chartDataCurrentByDay', 'chartDataPreviousByDay','orders','providers','resellers','customers','subscriptions','news'));
            break;

            case config('app.admin'):
                $news = News::get();

                $provider_id = Auth::getUser()->provider_id;
                $orders= Order::first();

                $orderMonth = Order::whereMonth(
                    'created_at', '=', Carbon::now()->subMonth()->month
                );
                if($orders){
                    $countOrders = ($orders->count()-$orderMonth->count());
                }
                $countOrders = 0;

                $resellers = $this->resellerRepository->all();

                $statuses = Status::get();
                $providers = $this->providerRepository->all();
                $provider = $this->providerRepository->all();
                $customersweek = Customer::whereMonth(
                    'created_at', '=', Carbon::now()->subWeekdays('1')
                )->get();

                // $sales = MsftInvoices::
                // select(DB::raw("MONTHNAME(invoiceDate) as date"), DB::raw('totalCharges as total'))
                // ->whereyear('invoiceDate', Carbon::today()->year)
                // ->groupBy(DB::raw("MONTHNAME(invoiceDate)"))
                // ->orderBy('invoiceDate', 'asc')
                // ->get();

                // foreach($sales as $row) {
                //     $invoicelabel['label'][] = json_encode($row->date);
                //     $invoicedata['data'][] = (int) $row->total;
                //   }

                //   $invoicelabel = $invoicelabel['label'];
                //   $invoicedata  = $invoicedata['data'];

                  return view('msft/index', compact('invoices','invoicelabel','invoicedata'));

                $topProducts = OrderProducts::with('Order')->get();

                $topProducts = OrderProducts::with(['Product' => function($query){
                    $query->groupBy('name');
                }])->get();


                return view('home', compact('Top5LicensesSubscriptions', 'chartDataSubscriptionYear','chartDataCurrentCustomerByDay','chartDataCurrentResellerByDay',
                'ChartRevenew','chartDataTotalOrders','chartDataCurrentByDay', 'chartDataPreviousByDay','providers','provider','orders','countOrders','customersweek','topProducts',
                'invoicelabel','invoicedata'));

            break;

            case config('app.provider'):

                $orders = Order::get();
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
                }else{
                    $countOrders = 0;
                }

                $statuses = Status::get();
                $resellers = $this->resellerRepository->all();
                $customers = $this->customerRepository->all();

                $subscriptions = $this->subscriptionRepository->all();
                $news = News::orderBy('created_at', 'desc')->take(4)->get();

                $previousMonth = Order::select([
                    DB::raw('DATE(created_at) AS date'),
                    DB::raw('COUNT(id) AS count'),
                ])
                ->whereMonth('created_at', Carbon::now()->subMonth(1)->month)
                ->groupBy('date')
                ->orderBy('date', 'ASC')
                ->get()
                ->toArray();

                $chartDataPreviousByDay = [];
                foreach ($previousMonth as $data) {
                    $chartDataPreviousByDay[] = $data['count'];
                }

                $currentMonth = Order::select([
                    DB::raw('DATE(created_at) AS date'),
                    DB::raw('COUNT(id) AS count'),
                ])
                ->whereMonth('created_at', [Carbon::now()->subMonth(0)->month])
                ->groupBy('date')
                ->orderBy('date', 'ASC')
                ->get()
                ->toArray();


                $chartDataCurrentByDay = [];
                foreach ($currentMonth as $data) {
                    // $chartDataCurrentByDay[$data['date']] = $data['count'];
                    $chartDataCurrentByDay[] = $data['count'];
                }

                $chartDataTotalOrders = array_sum($chartDataCurrentByDay)+array_sum($chartDataPreviousByDay);


                $revenue = Order::select()
                ->with('orderproduct','subscriptions')
                ->where('order_status_id', '4')
                ->whereMonth('created_at', [Carbon::now()->subMonth(0)->month])
                ->get();

                $ChartRevenew = [];
                foreach ($revenue as $data) {
                    if($data->orderproduct != null){
                        $ChartRevenew[] = $data->orderproduct['retail_price']*$data->orderproduct['quantity'];
                    }
                }

                $resellercurrentMonth = Reseller::select([
                    DB::raw('DATE(created_at) AS date'),
                    DB::raw('COUNT(id) AS count'),
                ])
                ->whereMonth('created_at', [Carbon::now()->subMonth(0)->month])
                ->groupBy('date')
                ->orderBy('date', 'ASC')
                ->get()
                ->toArray();

                $chartDataCurrentResellerByDay = [];
                foreach ($resellercurrentMonth as $data) {
                    // $chartDataCurrentByDay[$data['date']] = $data['count'];
                    $chartDataCurrentResellerByDay[] = $data['count'];
                }

                $customercurrentMonth = Customer::select([
                    DB::raw('DATE(created_at) AS date'),
                    DB::raw('COUNT(id) AS count'),
                ])
                ->whereMonth('created_at', [Carbon::now()->subMonth(0)->month])
                ->groupBy('date')
                ->orderBy('date', 'ASC')
                ->get()
                ->toArray();

                $chartDataCurrentCustomerByDay = [];
                foreach ($customercurrentMonth as $data) {
                    // $chartDataCurrentByDay[$data['date']] = $data['count'];
                    $chartDataCurrentCustomerByDay[] = $data['count'];
                }

                $subscriptionsperMonth = Subscription::select(
                    DB::raw('SUM(amount) AS count'),
                    DB::raw("MONTHNAME(created_at) as monthname"))
                    ->whereYear('created_at', date('Y', strtotime('-1 year')))
                    ->where('billing_type', 'license')
                    ->groupBy('monthname')
                    ->get()
                    ->toArray();



                $chartDataSubscriptionYear = [];
                foreach ($subscriptionsperMonth as $data) {
                    dd($data['monthname']);
                    $chartDataSubscriptionYear[$data['monthname']] = $data['count'];
                    // $chartDataCurrentCustomerByDay[] = $data['count'];
                }



            $top5Products = Subscription::select('name')
                ->where('status_id', '1')
                ->selectRaw('COALESCE(sum(amount),0) total')
                ->groupBy('id')
                ->orderBy('total','desc')
                ->take(5)
                ->get()
                ->toArray();


                $Top5LicensesSubscriptions = [];
                foreach ($top5Products as $data) {
                    $Top5LicensesSubscriptions[$data['name']] = $data['total'];
                }


                return view('home', compact('Top5LicensesSubscriptions', 'chartDataSubscriptionYear','chartDataCurrentCustomerByDay','chartDataCurrentResellerByDay',
                'ChartRevenew','chartDataTotalOrders','chartDataCurrentByDay', 'chartDataPreviousByDay','resellers','orders',
                'countOrders','provider','customers', 'subscriptions','news'));
            break;

            case config('app.reseller'):
                $countCustomers = $user->reseller->customers->count();
                $subscriptions = $this->resellerRepository->getSubscriptions($user->reseller);
                $countSubscriptions = $subscriptions->count();
                $orders = Order::get();

                $provider = $user->reseller->provider;

                $news = News::orderBy('id', 'DESC')->take(2)->get();

                return view('reseller.partials.home', compact('countCustomers','countSubscriptions','orders','news'));

            break;

            case config('app.subreseller'):

            break;

            case config('app.customer'):
                $customer = $this->getUser()->customer;
                $subscriptions = $this->listFromCustomer($customer);
                $expired = Carbon::now()->addDays(90);
                $abouttoexpire = $subscriptions->map(function ($name) use($expired) {
                    if ($name->expiration_data <= $expired){
                        return $name;
                    }
                });

                $abouttoexpire = $abouttoexpire->filter();

                $reseller = $user->customer->resellers->first()->provider;
                $orders = Order::get();

                $news = News::orderBy('id', 'DESC')->take(2)->get();


                return view('customer.home', compact('subscriptions', 'customer','abouttoexpire','news','orders'));

            break;

            default:
            return abort(403, __('errors.unauthorized_action'));

        break;
    }



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


                // $orderrecord = Order::select(DB::raw("COUNT(*) as count"),
                // \DB::raw("MONTHNAME(created_at) as day_name"),
                // \DB::raw("MONTH(created_at) as month"))
                // ->where('created_at', '>', Carbon::today()->subMonth(Carbon::today()->month))
                // ->groupBy('day_name','month')
                // ->orderBy('month')
                // ->get();


                // foreach($orderrecord as $row) {
                //     $orderlabel['label'][] = json_encode($row->day_name);
                //     $orderdata['data'][] = (int) $row->count;
                // }

                // if(!$orderrecord->isEmpty()){
                //     $orderlabel = $orderlabel['label'];
                //     $orderdata  = $orderdata['data'];
                // }else{
                //     $orderlabel = ['0'];
                //     $orderdata  = ['0'];
                // };


                //   $customerrecord = Customer::select(DB::raw("COUNT(*) as count"), \DB::raw("MONTHNAME(created_at) as day_name"), \DB::raw("MONTH(created_at) as month"))
                // ->where('created_at', '>', Carbon::today()->subMonth(Carbon::today()->month))
                // ->groupBy('day_name','month')
                // ->orderBy('month')
                // ->get();

                //  foreach($customerrecord as $row) {
                //     $customerlabel['label'][] = json_encode($row->day_name);
                //     $customerdata['data'][] = (int) $row->count;
                //   }
                //   if(!$customerrecord->isEmpty()){
                //   $customerlabel = $customerlabel['label'];
                //   $customerdata  = $customerdata['data'];
                // }else{
                //     $customerlabel = ['0'];
                //     $customerdata  = ['0'];
                // };

                //   $sales = MsftInvoices::
                // select(DB::raw("MONTHNAME(invoiceDate) as date"), DB::raw('totalCharges as total'))
                // ->whereyear('invoiceDate', Carbon::today()->year)
                // ->groupBy(DB::raw("MONTHNAME(invoiceDate)"))
                // ->orderBy('invoiceDate', 'asc')
                // ->get();


                // foreach($sales as $row) {
                //     $invoicelabel['label'][] = json_encode($row->date);
                //     $invoicedata['data'][] = (int) $row->total;
                //   }
                //   if(!$sales->isEmpty()){
                //   $invoicelabel = $invoicelabel['label'];
                //   $invoicedata  = $invoicedata['data'];
                // }else{
                //     $invoicelabel = ['0'];
                //     $invoicedata  = ['0'];
                // };

                // $provider_id = Auth::getUser()->provider_id;
    // $provider = Provider::where('id', $provider_id)->first();



    // $statuses = Status::get();


    // $countries = Country::all();
    // $resellers = $this->resellerRepository->resellersOfProvider($provider);
    // $customers = new Collection();

    // foreach ($resellers as $reseller){
    //     $reseller = Reseller::find($reseller['id']);
    //     $customers = $customers->merge($this->customerRepository->customersOfReseller($reseller));
    // }

    // $reseller = Reseller::get();
    // $countResellers = $reseller->count();

    // $instance = Instance::first();

    // $order = OrderProducts::get();

    // $users = User::where('provider_id', $provider->id)->first();

    // $subscriptions = $this->providerRepository->getSubscriptions($provider);
    // $countCustomers =  $customers->count();
    // $countSubscriptions = $subscriptions->count();

    // $countries = Country::all();
    // $providers = $this->providerRepository->all();
    // return view('home', compact('provider','resellers','customers','instance','users',
    // 'countries','subscriptions','order','statuses','countResellers',
    // 'countCustomers','countSubscriptions','providers','countries'));

    // $orderrecord = Order::select(DB::raw("COUNT(*) as count"), \DB::raw("MONTHNAME(created_at) as day_name"), \DB::raw("MONTH(created_at) as month"))
                // ->where('created_at', '>', Carbon::today()->subMonth(Carbon::today()->month))
                // ->groupBy('day_name','month')
                // ->orderBy('month')
                // ->get();

                // $customerrecord = Customer::select(DB::raw("COUNT(*) as count"), \DB::raw("MONTHNAME(created_at) as day_name"), \DB::raw("MONTH(created_at) as month"))
                // ->where('created_at', '>', Carbon::today()->subMonth(Carbon::today()->month))
                // ->groupBy('day_name','month')
                // ->orderBy('month')
                // ->get();

                // $sales = MsftInvoices::
                // select(DB::raw("MONTHNAME(invoiceDate) as date"), DB::raw('totalCharges as total'))
                // ->whereyear('invoiceDate', Carbon::today()->year)
                // ->groupBy(DB::raw("MONTHNAME(invoiceDate)"))
                // ->orderBy('invoiceDate', 'asc')
                // ->get();

            // if($sales->first() != null){
            //     foreach($sales as $row) {
            //         $invoicelabel['label'][] = json_encode($row->date);
            //         $invoicedata['data'][] = (int) $row->total;
            //     }

            //     $invoicelabel = $invoicelabel['label'];
            //     $invoicedata  = $invoicedata['data'];

            //     foreach($orderrecord as $row) {
            //         $orderlabel['label'][] = json_encode($row->day_name);
            //         $orderdata['data'][] = (int) $row->count;
            //     }

            //     $orderlabel = $orderlabel['label'];
            //     $orderdata  = $orderdata['data'];

            //     foreach($customerrecord as $row) {
            //         $customerlabel['label'][] = json_encode($row->day_name);
            //         $customerdata['data'][] = (int) $row->count;
            //     }

            //     $customerlabel = $customerlabel['label'];
            //     $customerdata  = $customerdata['data'];
            //     return view('home', compact('orders','providers','resellers','customers','subscriptions','news',
            //     'orderdata','orderlabel','customerlabel','customerdata','invoicelabel','invoicedata'));
            // }
            // $orderdata = [];
            // $orderlabel = [];
            // $customerlabel = [];
            // $customerdata = [];
            // $invoicelabel = [];
            // $invoicedata = [];
