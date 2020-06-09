<?php

namespace App\Http\Controllers\Web;

use App\AzureResource;
use App\User;
use App\Order;
use App\Status;
use App\Country;
use App\Customer;
use App\Instance;
use App\Provider;
use App\Reseller;
use App\PriceList;
use App\OrderProducts;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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
    
    private $providerRepository;
    private $resellerRepository;
    private $customerRepository;
    private $subscriptionRepository;
    private $orderRepository;
    
    
    public function __construct(ProviderRepositoryInterface $providerRepository, ResellerRepositoryInterface $resellerRepository, CustomerRepositoryInterface $customerRepository, SubscriptionRepositoryInterface $subscriptionRepository, OrderRepositoryInterface $orderRepository)
    {
        $this->providerRepository = $providerRepository;
        $this->resellerRepository = $resellerRepository;
        $this->customerRepository = $customerRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->orderRepository = $orderRepository;
        
        
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
    
    public function index()
    {
  
        $countries = Country::all();
        $providers = $this->providerRepository->all();

        return view('provider.index', compact('providers','countries'));
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

        // $budget = cache()->remember('azure.budget', 60, function(){
            
        //     $customer = new TagydesCustomer([
        //         'id' => 'd9b842d6-aa51-44ca-a77c-f7d20411b942',
        //         'username' => 'bill@tagydes.com',
        //         'password' => 'blabla',
        //         'firstName' => 'Nombre',
        //         'lastName' => 'Apellido',
        //         'email' => 'bill@tagydes.com',
        //         ]);
                
        // $subscription = new TagydesSubscription([
        //     'id'            => 'C01AD64D-6D65-45C4-B755-C11BD4F0DA0E',
        //     'orderId'       => "C01AD64D-6D65-45C4-B755-C11BD4F0DA0E",
        //     'offerId'       => "C01AD64D-6D65-45C4-B755-C11BD4F0DA0E",
        //     'customerId'    => "d9b842d6-aa51-44ca-a77c-f7d20411b942",
        //     'name'          => "5trvfvczdfv",
        //     'status'        => "5trvfvczdfv",
        //     'quantity'      => "1",
        //     'currency'      => "EUR",
        //     'billingCycle'  => "monthly",
        //     'created_at'    => "5trvfvczdfv",
        //     ]);
            
        //     return (int) FacadesAzureResource::withCredentials(
        //         "66127fdf-8259-429c-9899-6ec066ff8915",
        //         "0.AR8Avm8sxJPBvEysW4TAgCGExd9_EmZZgpxCmJluwGb_iRUfALw.AQABAAAAAABeAFzDwllzTYGDLh_qYbH8FeLygiGNRfXCDRnVOpN62d3xlNaszrjSyFT8UzPwsgm61N1OPMy7_thY22wjSIGjYMMpOmPc4gyuRHYyFjJY6LJTpupg2mPir6TqiEfQWC2-sAJM1IGSP-Slfd2ngy-SkPwHWOIOefRKNwoP7mTUHf4ywRaw30vS0QGHtOdF6-PERdTryy2mKxb86r9OEAmnQQbcfIg2mrtqYyK0BWaJUYxBD8ULxo-acgArcZKC4vPYh-Z-qtOCdI2-NcOq47aCqQnNwiUiz5TMJ3WV1guDcfTarmxiBE2JbnS6-FxggqDNoVh13q2TcxZcfMwaN2fGR_z_q1HDJvMJZJTmbbpf8_Dh1Ls1vOEriEIzGykyyUT0zKFEMVau1z77leEEuMhx0E5YUHJUu8KPgXnCXIwo9wUfWP3pet67wmHd9lnMpoXDbdIb2LzCcuRE-jJzWjap5BL4rb-H0uyMev-4AwgUO4ud1QYD93uyIDuOOezBjfDENB-a-2iOIimQ2x-mwgP0g8tCdngg9qetEsX3mHSc7EB5eeS4vEQTmvcEazKoGtSWwcpX9rcBbiapbEBgWMTQ9BFo_SXxEtdoQdO2W1HtTaBmVLnjZjf4AqE8Uv9A7EAmyB7xGW-a04aL0qfT_wy2hTxZNpY0QFIJ4O1EvZxRZg2VNgZha3AHnEPg7hhqbhBnO48kyo6ENtsVLipB_SwU-HcFRUECp_q2v5DAp27Tjz69vcnOJve0VLr-g49MKsXubspL5OvvjJKJMtg3UcF5m8yJsqlTojkpgKCF94_W6_PNFwLLjvBw6C3vPSml7Nz9ejZUmECiyEJlpBrEf0NUl7cLOfa833cW92GTWCg49pMqC_g8mForzHTHCsHLaOXN68d-oH9w_jdzqaecR9tht84kBL-YgUhs4QIIV1HKE4CjGT4Ahuapk0vGJxsDQvIvPvgcTpra-X1Stu3sm6FflIvDw2CHj5XA8TJ6suBWOBJlL0vj0tnsRj41H12n09T-F0Su3aiSBcxJ4APCG9U2IAA"
        //         )->budget($customer, $subscription);
        //     });


        $countries = Country::all();
        $resellers = $this->resellerRepository->resellersOfProvider($provider);
        $customers = new Collection();
        
        foreach ($resellers as $reseller){
            $reseller = Reseller::find($reseller['id']);
            $customers = $customers->merge($this->customerRepository->customersOfReseller($reseller));
        }


        // $costSum = AzureResource::sum('cost');
        // $increase = ($budget-$costSum);
        // $average1 = ($increase/$budget)*100;
        // $average = 100-$average1;


        
        $instance = Instance::first();
        
        $order = OrderProducts::get();
                        
        $users = User::where('provider_id', $provider->id)->get();
        
        $subscriptions = $this->providerRepository->getSubscriptions($provider);
        
        return view('provider.show', compact('provider', 'resellers', 'customers', 'instance', 'users','countries', 'subscriptions','order'));
    }
    
    public function edit(Provider $provider)
    {
        
        $countries = Country::all();
        return view('provider.edit', compact('countries'));
    }
    
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'company_name' => ['required', 'string', 'regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/', 'max:255'],
            'nif' => ['required', 'string', 'regex:/^[0-9A-Za-z.\-_:]+$/', 'max:20'],
            'address_1' => ['required', 'string', 'max:255'],
            'country_id' => ['required', 'integer', 'min:1'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'regex:/^[0-9A-Za-z.\-]+$/', 'max:255'],
            // 'status' => ['required', 'integer', 'exists:statuses,id'],
            'sendInvitation' => ['nullable', 'integer'],
            ]);
        }     
        
    public function store(Request $request)
    {

    $this->validator($request->all())->validate();

    try {
    DB::beginTransaction();

    $provider =  Provider::create([
        'company_name' => $request['company_name'],
        'nif' => $request['nif'],
        'country_id' => $request['country_id'],
        'address_1' => $request['address_1'],
        'address_2' => $request['address_2'],
        'city' => $request['city'],
        'state' => $request['state'],
        'postal_code' => $request['postal_code'],
        'status_id' => $request['status']
        ]);
    
    User::create([
        'provider_id' => $provider->id,
        'email' => $request['email'],
        'user_level_id' => 3,
        'password' => Hash::make(Str::random(20)),
        'status_id' => $request->status,
        'notify' => $request['sendInvitation'] ?? false,
        ]);
        
        $priceList = PriceList::create([
            'name' => 'Price List - ' . $provider->company_name,
            'description' => 'Default Provider Price List'
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
            return redirect()->route('provider.index')
            ->with([
                'alert' => 'danger', 
                'message' => trans('messages.Provider Created unsuccessfully') . " (" . trans($errorMessage) . ")."
                ]);
            }
            
            return redirect()->route('provider.index')->with(['alert' => 'success', 'message' => trans('messages.Provider Created successfully')]);
            
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
    }
