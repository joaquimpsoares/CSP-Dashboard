<?php

namespace App\Http\Controllers\Web;

use App\User;
use App\Status;
use App\Country;
use App\Customer;
use App\Instance;
use App\Provider;
use App\Reseller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\ProviderRepositoryInterface;
use App\Repositories\ResellerRepositoryInterface;

class ProviderController extends Controller
{
    
    private $providerRepository;
    private $resellerRepository;
    private $customerRepository;

    public function __construct(ProviderRepositoryInterface $providerRepository, ResellerRepositoryInterface $resellerRepository, CustomerRepositoryInterface $customerRepository)
    {
        $this->providerRepository = $providerRepository;
        $this->resellerRepository = $resellerRepository;
        $this->customerRepository = $customerRepository;

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
        $providers = $this->providerRepository->all();
        return view('provider.index', compact('providers'));
    }
    

    public function create()
    {
        $countries = Country::get();
        $status = Status::get();

        return view('provider.create', compact('countries', 'status'));
    }    
    
    public function register()
    {
        return view('provider.register');
    }    
    
    public function show(Provider $provider)
    {
        $resellers = $this->resellerRepository->resellersOfProvider($provider);

        $instance = Instance::first();
        
        $customers = [];

        foreach ($resellers as $reseller){
            $reseller = Reseller::find($reseller['id']);
            $customers[] = $this->customerRepository->customersOfReseller($reseller);

        }

        // dd($customers); 

    return view('provider.show', compact('provider', 'resellers', 'customers', 'instance'));
    }
    
    public function edit(Provider $provider)
    {
        return view('provider.register');
    }
    
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'company_name' => ['required', 'string', 'max:255'],
            'nif' => ['required', 'string', 'max:255'],
            'address_1' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],



            ]);
        }     
    
    public function store(Request $request)
    {

        // dd($request['country']);
        //  dd($request->all());
        
        $this->validator($request->all())->validate();


        $provider =  Provider::create([
            'company_name' => $request['company_name'],
            'nif' => $request['nif'],
            'country_id' => $request['country'],
            'address_1' => $request['address_1'],
            'address_2' => $request['address_2'],
            'city' => $request['city'],
            'state' => $request['state'],
            'postal_code' => $request['postal_code'],
            'status_id' => $request['status']
            ]);


            // 'first_name' => ['required', 'string', 'max:255'],
            // 'last_name' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
        // $user =  User::create([
        //     'first_name' => $request['first_name'],
        //     'last_name' => $request['last_name'],
        //     'email' => $request['email'],
        //     'username' => $request['email'],
        //     'user_level_id' => '3',
        //     'status' => 'Unconfirmed',
        //     'password' => Hash::make($request['password']),
        //     ]);

 

            // dd($user);
                
            return redirect()->route('home')->with(['alert' => 'success', 'message' => trans('messages.Provider Created successfully    ')]);
                
            }
            
            
            
            
            public function update(Request $request, Provider $provider)
            {
                //
            }
            
            
            public function destroy(Provider $provider)
            {
                //
            }
        }
