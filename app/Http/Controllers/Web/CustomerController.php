<?php

namespace App\Http\Controllers\Web;

use App\Country;
use App\Customer;
use App\Reseller;
use App\Http\Requests\Request;
use App\Support\Enum\CustomerStatus;
use App\Repositories\Country\CountryRepository;
use App\Repositories\CustomerRepositoryInterface;


class CustomerController extends Controller
{
    
    private $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
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

        return view('customer.show', compact('customer','countries'));
        
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
