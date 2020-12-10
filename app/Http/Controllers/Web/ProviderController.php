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
use App\PriceList;
use App\AzureResource;
use App\OrderProducts;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Traits\ActivityTrait;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\ProviderRepositoryInterface;
use App\Repositories\ResellerRepositoryInterface;
use App\Repositories\SubscriptionRepositoryInterface;
use Tagydes\MicrosoftConnection\Models\Customer as TagydesCustomer;
use Tagydes\MicrosoftConnection\Models\Subscription as TagydesSubscription;
use Tagydes\MicrosoftConnection\Facades\AzureResource as FacadesAzureResource;


class ProviderController extends Controller
{

    use ActivityTrait;
    private $providerRepository;
    private $resellerRepository;
    private $customerRepository;
    private $userRepository;
    private $subscriptionRepository;
    private $orderRepository;


    public function __construct(ProviderRepositoryInterface $providerRepository, ResellerRepositoryInterface $resellerRepository, CustomerRepositoryInterface $customerRepository, SubscriptionRepositoryInterface $subscriptionRepository, OrderRepositoryInterface $orderRepository, UserRepositoryInterface $userRepository)
    {
        $this->providerRepository = $providerRepository;
        $this->resellerRepository = $resellerRepository;
        $this->customerRepository = $customerRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
    }


    public function getPriceList(Provider $provider)
    {
        $resellers = $provider->resellers()->with('priceList')->get();

        $priceLists = [];
        foreach ($resellers as $reseller) {
            if (!in_array($reseller->priceList, $priceLists))
            $priceLists[] = $reseller->priceList;
        }

        return view('priceList.index', compact('priceLists'));

    }

    public function index(Provider $provider)
    {

        $statuses = Status::get();

        $countries = Country::all();
        $resellers = $this->resellerRepository->resellersOfProvider($provider);
        $customers = new Collection();

        foreach ($resellers as $reseller){
            $reseller = Reseller::find($reseller['id']);
            $customers = $customers->merge($this->customerRepository->customersOfReseller($reseller));
        }

        $reseller = Reseller::get();

        $instance = Instance::first();

        $order = OrderProducts::get();

        $users = User::where('provider_id', $provider->id)->first();

        $subscriptions = $this->providerRepository->getSubscriptions($provider);
        $countCustomers =  $customers->count();
        $countSubscriptions = $subscriptions->count();

        $countries = Country::all();
        $providers = $this->providerRepository->all();

        return view('provider.index', compact('provider','resellers','customers','instance','users',
        'countries','subscriptions','order','statuses',
        'countCustomers','countSubscriptions','providers',));

    }


    public function create()
    {
        $countries = Country::get();
        $statuses = Status::get();

        return view('provider.create', compact('countries', 'statuses'));
    }

    public function register()
    {
        return view('provider.register');
    }

    public function show(Provider $provider)
    {



    // $budget = cache()->remember('azure.budget', 260, function(){

    //     $customer = new TagydesCustomer([
    //         'id' => '4e03835b-242f-441c-9958-ad3e5e05f55d',
    //         'username' => 'bill@tagydes.com',
    //         'password' => 'blabla',
    //         'firstName' => 'Nombre',
    //         'lastName' => 'Apellido',
    //         'email' => 'bill@tagydes.com',
    //         ]);

    //     $subscription = new TagydesSubscription([
    //         'id'            => 'C01AD64D-6D65-45C4-B755-C11BD4F0DA0E',
    //         'orderId'       => "C01AD64D-6D65-45C4-B755-C11BD4F0DA0E",
    //         'offerId'       => "C01AD64D-6D65-45C4-B755-C11BD4F0DA0E",
    //         'customerId'    => "4e03835b-242f-441c-9958-ad3e5e05f55d",
    //         'name'          => "5trvfvczdfv",
    //         'status'        => "5trvfvczdfv",
    //         'quantity'      => "1",
    //         'currency'      => "EUR",
    //         'billingCycle'  => "monthly",
    //         'created_at'    => "5trvfvczdfv",
    //         ]);

    //         try {
    //             return (int) FacadesAzureResource::withCredentials(
    //                 "66127fdf-8259-429c-9899-6ec066ff8915",
    //                 "0.AR8Avm8sxJPBvEysW4TAgCGExd9_EmZZgpxCmJluwGb_iRUfADg.AQABAAAAAAAm-06blBE1TpVMil8KPQ41TGM2nhO8VJjR0mjT74eA5Vtiwae9puUdJV6wXOnCFBXCJaBrg9sTGV1VWMdi_N-zAvh-cM7feaHQFv3j9glW9VTjhfNpeHgBN2B_-j6jUMhrnrwtli972ZGiQGVlkvBaUm3pYnODccLh9cHQmajkSoabxl9tRwJTbu-d0HwYO9qB8KwvibTt8z7TYIwU0-96eDruYNq3CNvU3fOLajnjAq9_wRhqRSGvThIVVXbbxNF6FBK8vyCt4Dr1xzmrD0wJdWJEaJdRYlzTFgtGJnmi85AxTp99mwCL4UfMnx-eQWGCtLy9wTnYBkmsE-QiYyuFkSMUbPzaTEp2KDQKTw0BqrgVuSC9G8lhFyjY2bQZ6d1c25VqWdjtc56wp8rQUaCfIxcYXUckM1xHPeK_aJDnohL1RQIv8PkC1rZyetQ9U8pWiJNHw6ncwDn47qPDEmEWMelVokrk-zNPmIpWOQ7x38b7w06Ycn0dLb2vxNA_yOAT8N_Pp_MO_aAIkNBgm2nYYrkm1TmTH0eUnBu-lDI-IVq7VuALw5OEjsf780cVDb0tGYFRJ9JcZj105e8vYtN-JhzhwERCx6uoMrjFrIumIQC4OIRyYOBdMppmyOD0Yx-0nncRLYZGwr8AlUyeA1M7ysFyCLqE1ppy5rIwXx7PvTTB46_8vQbkX47926rydiHxphHNxIUh7DUsHBHdrp06O_Ib_crCLm9rhSIxmdrGADaF_iLG2lvruUVRMld7Eui7KY2SBlzOkv3aLHccjheF5bUEvjDRGjrI1l31RH3U-gk4BwB0FAnqE640crngFqrYS3my0bTOSs18uTMp8JyPYGhFpL9Mr4ihwxS4N5OjrFQ6hejYMg14wnY52Mcgfy1CQglQPtylU6sv7xA1Rm1cV-VJqqlN4zK8y6hPF230Mf5qSSn11hyk2wG9bISO-c44uzSOYUY81Zm2HkboUgDz4xUEJnQhRdU_7ySuS1KEOMz_I0jzZ6756aWvMNqlKlKXkGw9d4K4AWhrSKYLl8PIN-5gvaBKVl3DKekDdkhqUgW61hjWUFfuBLWOGWC-5oogAA"
    //                 )->budget($customer, $subscription);
    //             } catch (Throwable $e) {
    //                 report($e);

    //                 return false;
    //             }

    //         });


    //         $costSum = AzureResource::sum('cost');
    //         $increase = ($budget-$costSum);


    //         if ($increase == 0.0) {
    //             // echo 'Divisor is 0';
    //             $average1 = 0;
    //         } else {
    //             $average1 = ($increase/$budget)*100;
    //         }
    //         $average = 100-$average1;


        $statuses = Status::get();


        $countries = Country::all();
        $resellers = $this->resellerRepository->resellersOfProvider($provider);
        $customers = new Collection();

        foreach ($resellers as $reseller){
            $reseller = Reseller::find($reseller['id']);
            $customers = $customers->merge($this->customerRepository->customersOfReseller($reseller));
        }
        // $countResellers = $reseller->count();

        $instance = Instance::first();

        $order = OrderProducts::get();

        $users = User::where('provider_id', $provider->id)->get();

        $subscriptions = $this->providerRepository->getSubscriptions($provider);
        $countCustomers =  $customers->count();
        $countSubscriptions = $subscriptions->count();

        return view('provider.show', compact('provider','resellers','customers','instance','users',
        'countries','subscriptions','order','statuses',
        'countCustomers','countSubscriptions'));
    }

    public function edit(Provider $provider)
    {

        $countries = Country::all();
        return view('provider.edit', compact('countries'));
    }



    public function store(Request $request)
    {

        // dd($request->all());

    $validate = $this->validator($request->all())->validate();

    try {
        DB::beginTransaction();

        $provider = $this->providerRepository->create($validate);

        $this->userRepository->create($validate, 'provider', $provider);
        // dd($user);

        $priceList = PriceList::create([
            'name' => 'Price List - ' . $provider->company_name,
            'description' => 'Default Provider Price List' . $provider->company_name
            ]);

            $provider->priceList()->associate($priceList);
            $provider->save();
            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
            if ($e->errorInfo[1] == 1062) {
                $errorMessage = "message.user_already_exists";
            } else {
                $errorMessage = "message.error";
            }
            return redirect()->back()->with('danger', ucwords(trans_choice($errorMessage, 1)) );

        }
        return redirect()->route('provider.index')->with('success', ucwords(trans_choice('messages.provider_created_successfully', 1)) );

    }


    public function update(Request $request, Provider $provider)
    {

        $this->validator($request->all())->validate();

        $provider = Provider::findOrFail($provider->id);

        $provider->company_name         = $request->input('company_name');
        $provider->nif                  = $request->input('nif');
        $provider->country_id           = $request->input('country_id');
        $provider->address_1            = $request->input('address_1');
        $provider->address_2            = $request->input('address_2');
        $provider->city                 = $request->input('city');
        $provider->state                = $request->input('state');
        $provider->postal_code          = $request->input('postal_code');

        $provider->save();

        return redirect()->back()->with(['alert' => 'success', 'message' => trans('messages.Provider Updated successfully')]);


            }


        public function destroy(Provider $provider)
        {
            //
        }


        protected function validator(array $data)
        {
            return Validator::make($data, [
                'company_name' => ['required', 'string', 'regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/', 'max:255'],
                'nif' => ['required', 'string', 'regex:/^[0-9A-Za-z.\-_:]+$/', 'max:20'],
                'email' => ['nullable', 'email', 'max:255'],
                'address_1' => ['required', 'string', 'max:255'],
                'address_2' => ['nullable', 'string', 'max:255'],
                'country_id' => ['required', 'integer', 'min:1'],
                'city' => ['required', 'string', 'max:255'],
                'state' => ['required', 'string', 'max:255'],
                'postal_code' => ['required', 'string', 'regex:/^[0-9A-Za-z.\-]+$/', 'max:255'],
                'status_id' => ['required', 'integer', 'exists:statuses,id'],
                'sendInvitation' => ['nullable', 'integer'],
                ]);
            }
        }
