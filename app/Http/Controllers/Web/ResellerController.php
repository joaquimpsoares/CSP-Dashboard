<?php

namespace App\Http\Controllers\Web;

use App\User;
use App\Status;
use App\Country;
use App\Customer;
use App\Reseller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\ResellerRepositoryInterface;
use App\Repositories\SubscriptionRepositoryInterface;



class ResellerController extends Controller
{
    
    private $resellerRepository;
    private $customerRepository;
    private $subscriptionRepository;
    
    
    public function __construct(ResellerRepositoryInterface $resellerRepository, CustomerRepositoryInterface $customerRepository, SubscriptionRepositoryInterface $subscriptionRepository)
    {
        $this->resellerRepository = $resellerRepository;
        $this->customerRepository = $customerRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        
    }
    
    
    public function getCustomersFromReseller(Reseller $reseller) {
        dd($reseller);
    }
    
    
    public function index()
    {
        
        $resellers = $this->resellerRepository->all();        
        
        return view('reseller.index', compact('resellers'));
        
    }
    
    
    public function create() {

        $countries = Country::get();
        $statuses = Status::get();
        
        return view('reseller.create', compact('countries', 'statuses'));
     }
    
    
    public function store(Request $request) {

    $this->validator($request->all())->validate();

    try {
    DB::beginTransaction();

    $reseller =  Reseller::create([
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
        'provider_id' => $reseller->id,
        'email' => $request['email'],
        'user_level_id' => 3,
        'password' => Hash::make(Str::random(20)),
        'status_id' => $request->status,
        'notify' => $request['sendInvitation'] ?? false,
        ]);
        
        // $priceList = PriceList::create([
        //     'name' => 'Price List - ' . $provider->company_name,
        //     'description' => 'Default Provider Price List'
        //     ]);
            
        //     $provider->priceList()->associate($priceList);
        //     $provider->save();
            
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
    
    
    public function show(Reseller $reseller) { 
        
        $countries = Country::get();
        
        $customers = new Collection();
        foreach ($reseller as $resellers){
            $reseller = Reseller::find($reseller['id']);
            $customers = $customers->merge($this->customerRepository->customersOfReseller($reseller));
            foreach ($customers as $customer){
                $customer = Customer::find($customer['id']);
                $subscriptions = $this->subscriptionRepository->subscriptionsOfCustomer($customer);
            }
        }
        
            
            return view('reseller.show', compact('reseller','customers', 'countries', 'subscriptions'));
        }
        
        
        public function edit(Reseller $reseller) { 
            
        }
        
        
        public function update(Request $request, Reseller $reseller) 
        {
            $this->validator($request->all())->validate();
            
            $reseller = Reseller::findOrFail($reseller->id);
            
            $reseller->company_name         = $request->input('company_name');
            $reseller->nif                  = $request->input('nif');
            $reseller->country_id           = $request->input('country_id');
            $reseller->address_1            = $request->input('address_1');
            $reseller->address_2            = $request->input('address_2');
            $reseller->city                 = $request->input('city');
            $reseller->state                = $request->input('state');
            $reseller->postal_code          = $request->input('postal_code');
            
            $reseller->save();
            
            return redirect()->back()->with(['alert' => 'success', 'message' => trans('messages.Reseller Updated successfully')]);
            
        }
        
        
        public function destroy(Reseller $reseller) { }
        
        public function getPriceList(Reseller $reseller)
        {
            
            $priceLists = [];
            
            $priceLists[] = $reseller->priceList;
            
            $customers = $reseller->customers()->with('priceList')->get();
            
            foreach ($customers as $customer) {
                if (!in_array($customer->priceList, $priceLists))
                $priceLists[] = $customer->priceList;
            }
            
            return view('priceList.index', compact('priceLists'));
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
                ]);
            }  
        }
