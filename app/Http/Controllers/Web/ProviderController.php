<?php

namespace App\Http\Controllers\Web;

use App\Country;
use App\Customer;
use App\Http\Controllers\Controller;
use App\Instance;
use App\Provider;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\ProviderRepositoryInterface;
use App\Repositories\ResellerRepositoryInterface;
use App\Reseller;
use App\Status;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
        $statuses = Status::get();
        
        return view('provider.create', compact('countries', 'statuses'));
    }    
    
    public function register()
    {
        return view('provider.register');
    }    
    
    public function show(Provider $provider)
    {
        $resellers = $this->resellerRepository->resellersOfProvider($provider);
        
        $instance = Instance::first();
        
        $customers = new Collection();
        
        foreach ($resellers as $reseller){
            $reseller = Reseller::find($reseller['id']);
            $customers = $customers->merge($this->customerRepository->customersOfReseller($reseller));
            
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
            'company_name' => ['required', 'string', 'regex:/^[a-zA-Z]+$/u', 'max:255'],
            'nif' => ['required', 'string', 'regex:/^[0-9A-Za-z.\-_:]+$/', 'max:20'],
            'address_1' => ['required', 'string', 'max:255'],
            'country_id' => ['required', 'integer', 'min:1'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'regex:/^[0-9A-Za-z.\-]+$/', 'max:255'],
            'status' => ['required', 'integer', 'exists:statuses,id'],
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

            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
            if ($e->errorInfo[1] == 1062) {
                $errorMessage = "message.userAlreadExists";
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
                    //
    }


    public function destroy(Provider $provider)
    {
                    //
    }
}
