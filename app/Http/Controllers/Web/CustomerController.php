<?php

namespace App\Http\Controllers\Web;

use App\Customer;
use App\Reseller;
use App\Http\Requests\Request;
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

    
    public function create() { }

    
    public function store(Request $request) { }

    
    public function show(Customer $customer) { }

    
    public function edit(Customer $customer) { }

    
    public function update(Request $request, Customer $customer) { }

    
    public function destroy(Customer $customer) { }

    public function getPriceList($customer)
    {

        $customer = Customer::with('priceList')->where('id', $customer)->first();
        dd($customer);
    }
}
