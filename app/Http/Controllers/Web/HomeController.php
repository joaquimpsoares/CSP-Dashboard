<?php

namespace App\Http\Controllers\Web;

use App\User;
use App\Order;
use Throwable;
use App\Status;
use App\Country;
use App\Customer;
use App\Instance;
use App\Provider;
use App\Reseller;
use Carbon\Carbon;
use App\AzureResource;
use App\OrderProducts;
use App\Models\Activities;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use App\Http\Traits\UserTrait;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\ProviderRepositoryInterface;
use App\Repositories\ResellerRepositoryInterface;
use App\Repositories\SubscriptionRepositoryInterface;
use Tagydes\MicrosoftConnection\Models\Customer as TagydesCustomer;
use Tagydes\MicrosoftConnection\Models\Subscription as TagydesSubscription;
use Tagydes\MicrosoftConnection\Facades\AzureResource as FacadesAzureResource;

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
    public function __construct(ProviderRepositoryInterface $providerRepository, SubscriptionRepositoryInterface $subscriptionRepository,ResellerRepositoryInterface $resellerRepository, CustomerRepositoryInterface $customerRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
        $this->providerRepository = $providerRepository;
        $this->resellerRepository = $resellerRepository;
        $this->customerRepository = $customerRepository;
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
                $countOrders = ($orders->count()-$orderMonth->count());

                $statuses = Status::get();
                $providers = $this->providerRepository->all();
                $customersweek = Customer::whereMonth(
                    'created_at', '=', Carbon::now()->subWeekdays('1')
                )->get();

                $topProducts = OrderProducts::with('Order')->get();
                // dd($topProducts->order);
                // foreach($topProducts as $t){
                    //     dd($t->product->groupBy('name')->get());

                // }


                $topProducts = OrderProducts::with(['Product' => function($query){
                    $query->groupBy('name');
                }])->get();

                // dd($topProducts->product);

                return view('home', compact('providers','orders','countOrders','customersweek','topProducts'));

            break;

            case config('app.admin'):


            break;

            case config('app.provider'):

                $provider_id = Auth::getUser()->provider_id;
                $orders= Order::first();

                // dd($orders);

                $orderMonth = Order::whereMonth(
                    'created_at', '=', Carbon::now()->subMonth()->month
                );
                $countOrders = ($orders->count()-$orderMonth->count());

                $statuses = Status::get();
                $resellers = $this->resellerRepository->all();
                $customersweek = Customer::whereMonth(
                    'created_at', '=', Carbon::now()->subWeekdays('1')
                )->get();

                $topProducts = OrderProducts::with('Order')->get();
                // dd($topProducts->order);
                // foreach($topProducts as $t){
                    //     dd($t->product->groupBy('name')->get());

                // }


                $topProducts = OrderProducts::with(['Product' => function($query){
                    $query->groupBy('name');
                }])->get();


                return view('home', compact('resellers','orders','countOrders','customersweek','topProducts'));

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

            break;

            case config('app.reseller'):


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


                return view('reseller.partials.home', compact('resellers','customers','instance','users',
                'countries','subscriptions','order','statuses','countResellers',
                'countCustomers','countSubscriptions','providers','countries'));

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
// dd($orders->count(),$orderMonth->count());
// dd($countOrders);
// $budget = cache()->remember('azure.budget', 260, function(){

    //     $customer = new TagydesCustomer([
        //         'id' => '4e03835b-242f-441c-9958-ad3e5e05f55d',
        //         'username' => 'bill@tagydes.com',
        //         'password' => 'blabla',
        //         'firstName' => 'Nombre',
        //         'lastName' => 'Apellido',
        //         'email' => 'bill@tagydes.com',
        //         ]);

        //         $subscription = new TagydesSubscription([
            //             'id'            => 'C01AD64D-6D65-45C4-B755-C11BD4F0DA0E',
            //             'orderId'       => "C01AD64D-6D65-45C4-B755-C11BD4F0DA0E",
            //             'offerId'       => "C01AD64D-6D65-45C4-B755-C11BD4F0DA0E",
            //             'customerId'    => "4e03835b-242f-441c-9958-ad3e5e05f55d",
            //             'name'          => "5trvfvczdfv",
            //             'status'        => "5trvfvczdfv",
            //             'quantity'      => "1",
            //             'currency'      => "EUR",
            //     'billingCycle'  => "monthly",
            //     'created_at'    => "5trvfvczdfv",
            //     ]);

            //     try {
                //         return (int) FacadesAzureResource::withCredentials(
                    //             "66127fdf-8259-429c-9899-6ec066ff8915",
                    //             "0.AR8Avm8sxJPBvEysW4TAgCGExd9_EmZZgpxCmJluwGb_iRUfADg.AQABAAAAAAAm-06blBE1TpVMil8KPQ41TGM2nhO8VJjR0mjT74eA5Vtiwae9puUdJV6wXOnCFBXCJaBrg9sTGV1VWMdi_N-zAvh-cM7feaHQFv3j9glW9VTjhfNpeHgBN2B_-j6jUMhrnrwtli972ZGiQGVlkvBaUm3pYnODccLh9cHQmajkSoabxl9tRwJTbu-d0HwYO9qB8KwvibTt8z7TYIwU0-96eDruYNq3CNvU3fOLajnjAq9_wRhqRSGvThIVVXbbxNF6FBK8vyCt4Dr1xzmrD0wJdWJEaJdRYlzTFgtGJnmi85AxTp99mwCL4UfMnx-eQWGCtLy9wTnYBkmsE-QiYyuFkSMUbPzaTEp2KDQKTw0BqrgVuSC9G8lhFyjY2bQZ6d1c25VqWdjtc56wp8rQUaCfIxcYXUckM1xHPeK_aJDnohL1RQIv8PkC1rZyetQ9U8pWiJNHw6ncwDn47qPDEmEWMelVokrk-zNPmIpWOQ7x38b7w06Ycn0dLb2vxNA_yOAT8N_Pp_MO_aAIkNBgm2nYYrkm1TmTH0eUnBu-lDI-IVq7VuALw5OEjsf780cVDb0tGYFRJ9JcZj105e8vYtN-JhzhwERCx6uoMrjFrIumIQC4OIRyYOBdMppmyOD0Yx-0nncRLYZGwr8AlUyeA1M7ysFyCLqE1ppy5rIwXx7PvTTB46_8vQbkX47926rydiHxphHNxIUh7DUsHBHdrp06O_Ib_crCLm9rhSIxmdrGADaF_iLG2lvruUVRMld7Eui7KY2SBlzOkv3aLHccjheF5bUEvjDRGjrI1l31RH3U-gk4BwB0FAnqE640crngFqrYS3my0bTOSs18uTMp8JyPYGhFpL9Mr4ihwxS4N5OjrFQ6hejYMg14wnY52Mcgfy1CQglQPtylU6sv7xA1Rm1cV-VJqqlN4zK8y6hPF230Mf5qSSn11hyk2wG9bISO-c44uzSOYUY81Zm2HkboUgDz4xUEJnQhRdU_7ySuS1KEOMz_I0jzZ6756aWvMNqlKlKXkGw9d4K4AWhrSKYLl8PIN-5gvaBKVl3DKekDdkhqUgW61hjWUFfuBLWOGWC-5oogAA"
                    //             )->budget($customer, $subscription);
                    //         } catch (Throwable $e) {
                        //             report($e);

                        //             return false;
                        //         }

                        //     });


                        //     $costSum = AzureResource::sum('cost');
                        //     $increase = ($budget-$costSum);


                        //     if ($increase == 0.0) {
                            //         // echo 'Divisor is 0';
                            //         $average1 = 0;
                            //     } else {
                                //         $average1 = ($increase/$budget)*100;
                                //     }
                                //     $average = 100-$average1;

