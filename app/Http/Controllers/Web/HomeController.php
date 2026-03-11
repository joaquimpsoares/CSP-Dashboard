<?php

namespace App\Http\Controllers\Web;

use App\News;
use App\Order;
use App\Customer;
use App\Provider;
use App\Reseller;
use Carbon\Carbon;
use App\Subscription;
use App\Models\Status;
use App\OrderProducts;
use App\Models\Activities;
use App\Models\LogActivity;
use App\Http\Traits\UserTrait;
use App\Services\ChatGptService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\ProviderRepositoryInterface;
use App\Repositories\ResellerRepositoryInterface;
use App\Repositories\SubscriptionRepositoryInterface;

class HomeController extends Controller
{
    protected $chatGptService;

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
    ProductRepositoryInterface $productRepository, OrderRepositoryInterface $orderRepository,ChatGptService $chatGptService)
    {
        $this->subscriptionRepository = $subscriptionRepository;
        $this->providerRepository = $providerRepository;
        $this->resellerRepository = $resellerRepository;
        $this->customerRepository = $customerRepository;
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
        $this->chatGptService = $chatGptService;
        $this->middleware('auth');

        $this->middleware('auth');
    }


    public function getSubscriptionInfo(Request $request)
    {
        $chatResponse = $request->input('chat_response');
        $result = $this->chatGptService->handleChatGptResponse($chatResponse);
        return response()->json(['result' => $result]);
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
                    $chartDataCurrentCustomerByDay[] = $data['count'];
                }

                $driver = DB::getDriverName();

                $sumAmountExpr = $driver === 'pgsql'
                    ? "SUM(CAST(NULLIF(amount, '') AS numeric)) AS count"
                    : "SUM(amount) AS count";

                $monthNameExpr = $driver === 'pgsql'
                    ? "TO_CHAR(created_at, 'Mon') as monthname"
                    : "MONTHNAME(created_at) as monthname";

                $subscriptionsperMonth = Subscription::select(
                    DB::raw($sumAmountExpr),
                    DB::raw($monthNameExpr)
                )
                    ->whereYear('created_at', date('Y', strtotime('-1 year')))
                    ->where('billing_type', 'license');

                if ($driver === 'pgsql') {
                    $subscriptionsperMonth = $subscriptionsperMonth
                        ->groupByRaw("TO_CHAR(created_at, 'Mon'), EXTRACT(MONTH FROM created_at)")
                        ->orderByRaw('EXTRACT(MONTH FROM created_at) ASC');
                } else {
                    $subscriptionsperMonth = $subscriptionsperMonth
                        ->groupBy('monthname')
                        ->orderBy('monthname');
                }

                $subscriptionsperMonth = $subscriptionsperMonth->get()->toArray();

                $chartDataSubscriptionYear = [];
                foreach ($subscriptionsperMonth as $data) {
                    $chartDataSubscriptionYear[$data['monthname']] = $data['count'];
                }

                $subscriptionsperMonthCurrent = Subscription::select(
                    DB::raw($sumAmountExpr),
                    DB::raw($monthNameExpr)
                )
                    ->whereYear('created_at', date('Y'))
                    ->where('billing_type', 'license');

                if ($driver === 'pgsql') {
                    $subscriptionsperMonthCurrent = $subscriptionsperMonthCurrent
                        ->groupByRaw("TO_CHAR(created_at, 'Mon'), EXTRACT(MONTH FROM created_at)")
                        ->orderByRaw('EXTRACT(MONTH FROM created_at) ASC');
                } else {
                    $subscriptionsperMonthCurrent = $subscriptionsperMonthCurrent
                        ->groupBy('monthname')
                        ->orderBy('monthname');
                }

                $subscriptionsperMonthCurrent = $subscriptionsperMonthCurrent->get()->toArray();

                $chartDataSubscriptionYearCurrent = [];
                foreach ($subscriptionsperMonthCurrent as $data) {
                    $chartDataSubscriptionYearCurrent[$data['monthname']] = $data['count'];
                }



            $top5Products = Subscription::select('name')
                ->where('status_id', '1')
                ->selectRaw(
                    DB::getDriverName() === 'pgsql'
                        ? "COALESCE(sum(CAST(NULLIF(amount, '') AS numeric)),0) total"
                        : 'COALESCE(sum(amount),0) total'
                )
                ->groupBy('id')
                ->orderBy('total','desc')
                ->take(5)
                ->get()
                ->toArray();

                $Top5LicensesSubscriptions = [];
                foreach ($top5Products as $data) {
                    $Top5LicensesSubscriptions[$data['name']] = $data['total'];
                }



            return view('home', compact('chartDataSubscriptionYearCurrent', 'Top5LicensesSubscriptions', 'chartDataSubscriptionYear','chartDataCurrentCustomerByDay','chartDataCurrentResellerByDay',
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

                $driver = DB::getDriverName();

                $sumAmountExpr = $driver === 'pgsql'
                    ? "SUM(CAST(NULLIF(amount, '') AS numeric)) AS count"
                    : "SUM(amount) AS count";

                $monthNameExpr = $driver === 'pgsql'
                    ? "TO_CHAR(created_at, 'Mon') as monthname"
                    : "MONTHNAME(created_at) as monthname";

                $subscriptionsperMonth = Subscription::select(
                    DB::raw($sumAmountExpr),
                    DB::raw($monthNameExpr)
                )
                    ->whereYear('created_at', date('Y', strtotime('-1 year')))
                    ->where('billing_type', 'license');

                if ($driver === 'pgsql') {
                    $subscriptionsperMonth = $subscriptionsperMonth
                        ->groupByRaw("TO_CHAR(created_at, 'Mon'), EXTRACT(MONTH FROM created_at)")
                        ->orderByRaw('EXTRACT(MONTH FROM created_at) ASC');
                } else {
                    $subscriptionsperMonth = $subscriptionsperMonth
                        ->groupBy('monthname')
                        ->orderBy('monthname');
                }

                $subscriptionsperMonth = $subscriptionsperMonth->get()->toArray();

                $chartDataSubscriptionYear = [];
                foreach ($subscriptionsperMonth as $data) {
                    $chartDataSubscriptionYear[$data['monthname']] = $data['count'];
                    // $chartDataCurrentCustomerByDay[] = $data['count'];
                }

                $subscriptionsperMonthCurrent = Subscription::select(
                    DB::raw($sumAmountExpr),
                    DB::raw($monthNameExpr)
                )
                    ->whereYear('created_at', date('Y'))
                    ->where('billing_type', 'license');

                if ($driver === 'pgsql') {
                    $subscriptionsperMonthCurrent = $subscriptionsperMonthCurrent
                        ->groupByRaw("TO_CHAR(created_at, 'Mon'), EXTRACT(MONTH FROM created_at)")
                        ->orderByRaw('EXTRACT(MONTH FROM created_at) ASC');
                } else {
                    $subscriptionsperMonthCurrent = $subscriptionsperMonthCurrent
                        ->groupBy('monthname')
                        ->orderBy('monthname');
                }

                $subscriptionsperMonthCurrent = $subscriptionsperMonthCurrent->get()->toArray();

                $chartDataSubscriptionYearCurrent = [];
                foreach ($subscriptionsperMonthCurrent as $data) {
                    $chartDataSubscriptionYearCurrent[$data['monthname']] = $data['count'];
                }


            $top5Products = Subscription::select('name')
                ->where('status_id', '1')
                ->selectRaw(
                    DB::getDriverName() === 'pgsql'
                        ? "COALESCE(sum(CAST(NULLIF(amount, '') AS numeric)),0) total"
                        : 'COALESCE(sum(amount),0) total'
                )
                ->groupBy('id')
                ->orderBy('total','desc')
                ->take(5)
                ->get()
                ->toArray();


                $Top5LicensesSubscriptions = [];
                foreach ($top5Products as $data) {
                    $Top5LicensesSubscriptions[$data['name']] = $data['total'];
                }


                return view('home', compact('chartDataSubscriptionYearCurrent', 'Top5LicensesSubscriptions', 'chartDataSubscriptionYear','chartDataCurrentCustomerByDay','chartDataCurrentResellerByDay',
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
        $user      = \Illuminate\Support\Facades\Auth::user();
        $userLevel = $user?->userLevel?->name;
        $news      = News::orderBy('created_at', 'desc')->take(5)->get();

        // ── Customer: show only their own data ──────────────────────────────
        if ($userLevel === config('app.customer')) {
            $customerId = $user?->customer_id;

            $metrics = [
                'subscriptions'        => Subscription::where('customer_id', $customerId)->count(),
                'subscriptions_active' => Subscription::where('customer_id', $customerId)->where('status_id', 1)->count(),
                'orders'               => Order::where('customer_id', $customerId)->count(),
                'orders_month'         => Order::where('customer_id', $customerId)
                                              ->whereMonth('created_at', now()->month)
                                              ->whereYear('created_at', now()->year)->count(),
            ];

            $recentOrders = Order::with('customer')
                ->where('customer_id', $customerId)
                ->latest()->limit(10)->get();

            $expiringSoon = Subscription::with(['customer', 'status'])
                ->where('customer_id', $customerId)
                ->where('status_id', 1)
                ->where('expiration_data', '>=', now())
                ->where('expiration_data', '<=', now()->addDays(90))
                ->orderBy('expiration_data')->limit(5)->get();

            $estRiskCount   = 0;
            $orderChartDates = $orderChartData = $subChartLabels = $subChartData = [];
            $top5Products   = $subsByStatus = [];

            return view('dashboard', compact(
                'metrics', 'recentOrders', 'userLevel', 'news',
                'estRiskCount', 'expiringSoon',
                'orderChartDates', 'orderChartData',
                'subChartLabels', 'subChartData',
                'top5Products', 'subsByStatus'
            ));
        }

        // ── Platform-wide metrics ────────────────────────────────────────────
        $customersTotal = Customer::count();
        $customersMonth = Customer::whereMonth('created_at', now()->month)
                                  ->whereYear('created_at', now()->year)->count();
        $customersPrev  = Customer::whereMonth('created_at', now()->subMonth()->month)
                                  ->whereYear('created_at', now()->subMonth()->year)->count();

        $subsTotal    = Subscription::count();
        $subsActive   = Subscription::where('status_id', 1)->count();
        $subsExpiring = Subscription::where('status_id', 1)
                            ->where('expiration_data', '>=', now())
                            ->where('expiration_data', '<=', now()->addDays(90))->count();

        $ordersTotal = Order::count();
        $ordersMonth = Order::whereMonth('created_at', now()->month)
                            ->whereYear('created_at', now()->year)->count();
        $ordersPrev  = Order::whereMonth('created_at', now()->subMonth()->month)
                            ->whereYear('created_at', now()->subMonth()->year)->count();

        $estRiskCount = Subscription::withoutGlobalScopes()
            ->where('est_risk', true)
            ->where('environment', session('environment', 'live'))
            ->count();

        $metrics = [
            'customers'              => $customersTotal,
            'customers_month'        => $customersMonth,
            'customers_prev'         => $customersPrev,
            'subscriptions'          => $subsTotal,
            'subscriptions_active'   => $subsActive,
            'subscriptions_expiring' => $subsExpiring,
            'orders'                 => $ordersTotal,
            'orders_month'           => $ordersMonth,
            'orders_prev'            => $ordersPrev,
        ];

        // ── Orders – last 30 days (chart) ────────────────────────────────────
        $ordersRaw = Order::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(29)->startOfDay())
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy(DB::raw('DATE(created_at)'))
            ->pluck('count', 'date')->toArray();

        $orderChartDates = $orderChartData = [];
        for ($i = 29; $i >= 0; $i--) {
            $d = now()->subDays($i);
            $orderChartDates[] = $d->format('M d');
            $orderChartData[]  = (int) ($ordersRaw[$d->format('Y-m-d')] ?? 0);
        }

        // ── Subscriptions created – last 6 months (chart) ───────────────────
        $subStart = now()->subMonths(5)->startOfMonth();
        if (config('database.default') === 'pgsql') {
            $subsRaw = Subscription::selectRaw("TO_CHAR(created_at,'YYYY-MM') as month, COUNT(*) as count")
                ->where('created_at', '>=', $subStart)
                ->groupBy(DB::raw("TO_CHAR(created_at,'YYYY-MM')"))
                ->orderBy(DB::raw("TO_CHAR(created_at,'YYYY-MM')"))
                ->pluck('count', 'month')->toArray();
        } else {
            $subsRaw = Subscription::selectRaw("DATE_FORMAT(created_at,'%Y-%m') as month, COUNT(*) as count")
                ->where('created_at', '>=', $subStart)
                ->groupBy(DB::raw("DATE_FORMAT(created_at,'%Y-%m')"))
                ->orderBy(DB::raw("DATE_FORMAT(created_at,'%Y-%m')"))
                ->pluck('count', 'month')->toArray();
        }

        $subChartLabels = $subChartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $m = now()->subMonths($i);
            $subChartLabels[] = $m->format('M Y');
            $subChartData[]   = (int) ($subsRaw[$m->format('Y-m')] ?? 0);
        }

        // ── Top 5 products by subscription count ────────────────────────────
        $top5Products = Subscription::selectRaw('name, COUNT(id) as count')
            ->whereNotNull('name')->where('name', '!=', '')
            ->groupBy('name')->orderByDesc('count')
            ->limit(5)->pluck('count', 'name')->toArray();

        // ── Subscriptions by status ──────────────────────────────────────────
        $subsByStatus = Subscription::selectRaw('status_id, COUNT(id) as count')
            ->groupBy('status_id')
            ->pluck('count', 'status_id')->toArray();

        // ── Expiring within 90 days ──────────────────────────────────────────
        $expiringSoon = Subscription::with(['customer'])
            ->where('status_id', 1)
            ->where('expiration_data', '>=', now())
            ->where('expiration_data', '<=', now()->addDays(90))
            ->orderBy('expiration_data')->limit(8)->get();

        // ── Recent orders ────────────────────────────────────────────────────
        $recentOrders = Order::with('customer')->latest()->limit(10)->get();

        return view('dashboard', compact(
            'metrics', 'recentOrders', 'userLevel', 'news',
            'estRiskCount', 'expiringSoon',
            'orderChartDates', 'orderChartData',
            'subChartLabels', 'subChartData',
            'top5Products', 'subsByStatus'
        ));
    }

    /**
     * Legacy dashboard entrypoint preserved for reference during migration.
     */
    public function legacyHome()
    {
        return $this->index();
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
