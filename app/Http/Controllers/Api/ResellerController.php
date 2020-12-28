<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\ResellerRepositoryInterface;
use App\Repositories\SubscriptionRepositoryInterface;

class ResellerController extends Controller
{
    public $countryRules;
    private $subscriptionRepository;
    private $customerRepository;
    private $userRepository;
    private $resellerRepository;

    public function __construct(ResellerRepositoryInterface $resellerRepository, CustomerRepositoryInterface $customerRepository, SubscriptionRepositoryInterface $subscriptionRepository, UserRepositoryInterface $userRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->userRepository = $userRepository;
        $this->resellerRepository = $resellerRepository;

    }

    public function index()
    {
        return $this->resellerRepository->all();
        // return Customer::all();
    }

}
