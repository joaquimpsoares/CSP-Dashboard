<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\SubscriptionRepositoryInterface;

class CustomerController extends Controller
{

    public $countryRules;
    private $subscriptionRepository;
    private $customerRepository;
    private $userRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository, SubscriptionRepositoryInterface $subscriptionRepository, UserRepositoryInterface $userRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        return $this->customerRepository->all();
        // return Customer::all();
    }

    public function show($id)
    {
        return Customer::find($id)->format();
    }

    public function store(Request $request)
    {

        return $this->customerRepository->create($request->all());
    }

    public function update(Request $request, $id)
    {
        $Customer = Customer::findOrFail($id);
        $Customer->update($request->all());

        return $Customer;
    }

    public function delete(Request $request, $id)
    {
        $Customer = Customer::findOrFail($id);
        $Customer->delete();

        return 204;
    }
}
