<?php

namespace App\Http\Controllers\Web;

use App\Role;
use App\User;
use App\Models\Status;
use App\Country;
use App\Instance;
use App\Provider;
use App\Reseller;
use App\PriceList;
use App\OrderProducts;
use Illuminate\Http\Request;
use App\Http\Traits\ActivityTrait;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\ProviderRepositoryInterface;
use App\Repositories\ResellerRepositoryInterface;
use App\Repositories\SubscriptionRepositoryInterface;


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
        $countries = Country::pluck( 'name','id');
        $statuses = Status::pluck( 'name','id');
        $roles = Role::pluck( 'name','id');

        return view('provider.create', compact('countries', 'statuses','roles'));
    }

    public function register()
    {
        return view('provider.register');
    }

    public function show(Provider $provider)
    {

        $statuses = Status::get();


        $countries = Country::all();
        $resellers = $this->resellerRepository->resellersOfProvider($provider);
        $customers = new Collection();

        foreach ($resellers as $reseller){
            $reseller = Reseller::find($reseller['id']);
            $customers = $customers->merge($this->customerRepository->customersOfReseller($reseller));
        }

        $instance = Instance::first();

        $order = OrderProducts::get();

        $users = User::where('provider_id', $provider->id)->paginate(10);

        $subscriptions = $this->providerRepository->getSubscriptions($provider);
        $countCustomers =  $customers->count();
        $countSubscriptions = $subscriptions->count();

        return view('provider.show', compact('provider','resellers','customers','instance','users',
        'countries','subscriptions','order','statuses',
        'countCustomers','countSubscriptions'));
    }

    public function edit(Provider $provider)
    {
        // provider/{provider}/edit
        $countries = Country::pluck('name', 'id');

        return view('provider.edit-v2', compact('provider', 'countries'));
    }



    public function store(Request $request)
    {

    $validate = $this->validator($request->all())->validate();

    try {
        DB::beginTransaction();

        $provider = $this->providerRepository->create($validate);

        $this->userRepository->create($validate, 'provider', $provider);

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
                $errorMessage = $e->getMessage();
            }
            return redirect()->back()->with('danger', $errorMessage );

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

        }


        protected function validator(array $data)
        {
            return Validator::make($data, [
                'company_name'      => ['required', 'string', 'regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/', 'max:255'],
                'nif'               => ['required', 'string', 'regex:/^[0-9A-Za-z.\-_:]+$/', 'max:20'],
                'country_id'        => ['required', 'integer', 'min:1'],
                'address_1'         => ['required', 'string', 'max:255'],
                'address_2'         => ['nullable', 'string', 'max:255'],
                'city'              => ['required', 'string', 'max:255'],
                'state'             => ['required', 'string', 'max:255'],
                'postal_code'       => ['required', 'string', 'regex:/^[0-9A-Za-z.\-]+$/', 'max:255'],
                'role_id'           => ['required', 'integer', 'exists:roles,id'],
                'status'            => ['required', 'integer', 'exists:statuses,id'],
                'name'              => ['required', 'string', 'max:255'],
                'last_name'         => ['required', 'string', 'max:255'],
                'socialite_id'      => ['nullable', 'string', 'max:255'],
                'phone'             => ['required', 'string', 'max:20'],
                'address'           => ['required', 'string', 'max:255'],
                'email'             => ['required', 'email', 'max:255'],
                'sendInvitation'    => ['nullable', 'integer'],
                'password'          => ['required', 'string', 'max:255'],
                ]);
            }
        }
