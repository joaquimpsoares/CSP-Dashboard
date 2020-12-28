<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use App\Reseller;
use App\Subscription;
use Illuminate\Http\Request;
use App\Http\Traits\UserTrait;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\ResellerRepositoryInterface;
use App\Repositories\SubscriptionRepositoryInterface;

class SubscriptionsController extends Controller
{

    use UserTrait;

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
        $user = $this->getUser();

        switch ($this->getUserLevel()) {
            case config('app.super_admin'):
                $subscriptions = Subscription::all();
            break;

            case config('app.admin'):
                $subscriptions = Subscription::with(['customer','products','status'])->
                orderBy('id')
                ->get();
            break;

            case config('app.provider'):

                $resellers = Reseller::where('provider_id', $user->provider->id)->pluck('id')->toArray();

                $subscriptions = Subscription::all();


            break;

            case config('app.reseller'):
                $reseller = $user->reseller;
                $customer = $reseller->customers->pluck('id');
                $subscriptions = Subscription::with(['customer','products','status'])->whereIn('customer_id', $customer)
                ->orderBy('id')->paginate(10);
            break;

            case config('app.subreseller'):
                $reseller = $user->reseller;
                $customer = $reseller->customers->pluck('id');
                $subscriptions = Customer::with(['customer','products','status'])->whereHas('resellers', function($query) use  ($customer) {
                	$query->whereIn('id', $customer);
                })->with(['country', 'status' => function ($query) {
					$query->where('name', 'messages.active');
				}])
                ->orderBy('company_name')->get();
            break;
            case config('app.customer'):
                $reseller = $user->customer;
                $subscriptions = $reseller->subscriptions;
            break;

            default:
            return abort(403, __('errors.unauthorized_action'));

        break;
    }

    return $subscriptions;
    }
}
