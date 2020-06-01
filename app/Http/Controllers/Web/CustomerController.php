<?php

namespace App\Http\Controllers\Web;

use App\Country;
use App\Customer;
use App\Reseller;
use App\Http\Requests\Request;
use Illuminate\Support\Collection;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\SubscriptionRepositoryInterface;



class CustomerController extends Controller
{
    private $subscriptionRepository;
    private $customerRepository;
    
    public function __construct(CustomerRepositoryInterface $customerRepository, SubscriptionRepositoryInterface $subscriptionRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        
    }
    
    public function index(Customer $customer) {
        
        $customers = $this->customerRepository->all();
                
        return view('customer.index', compact('customers'));
    }
    
    
    public function create(Customer $customer){
        
        
        return view('customer.create', compact('customer'));
        
    }
    
    public function store(Request $request) { }
    
    
    public function show(Customer $customer) {
        
        $countries = Country::get();
        
        $customer = Customer::find($customer['id']);
        
        $subscriptions = $this->subscriptionRepository->subscriptionsOfCustomer($customer);
        
        return view('customer.show', compact('customer','countries','subscriptions'));
        
    }
    
    
    public function edit(Customer $customer) { }
    
    
    public function update(Request $request, Customer $customer) { }
    
    
    public function destroy(Customer $customer) { }
    
    public function getPriceList($customer)
    {
        
        $customer = Customer::with('priceList')->where('id', $customer)->first();
        dd($customer);
    }
    
    public function getMainUser(Customer $customer)
    {
        /* Check if can buy to this customer */
        if (!$this->customerRepository->canInteractWithCustomer($customer)) {
            return abort(401);
        }
        /* End Check */
        
        $user = $customer->users()->first()->format();
        
        return $user;
    }
}
