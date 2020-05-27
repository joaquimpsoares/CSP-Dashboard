<?php

namespace App\Http\Controllers\Web;

use App\Customer;
use App\Provider;
use App\Reseller;
use App\Subscription;
use Illuminate\Http\Request;
use App\Http\Traits\UserTrait;
use App\Http\Controllers\Controller;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\ProviderRepositoryInterface;
use App\Repositories\ResellerRepositoryInterface;
use App\Repositories\SubscriptionRepositoryInterface;



class SubscriptionController extends Controller
{

    use UserTrait;
    private $subscriptionRepository;
    private $providerRepository;
    private $resellerRepository;
    private $customerRepository;


    public function __construct(ResellerRepositoryInterface $resellerRepository, CustomerRepositoryInterface $customerRepository,SubscriptionRepositoryInterface $subscriptionRepository, ProviderRepositoryInterface $providerRepository)
    {
        $this->resellerRepository = $resellerRepository;
        $this->customerRepository = $customerRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->providerRepository = $providerRepository;
    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscriptions = [];
        switch ($this->getUserLevel()) {
            case 'Provider':
                $provider = $this->getUser()->provider;
                $subscriptions = $this->listFromProvider($provider);
            break;
            case 'Reseller':
                $reseller = $this->getUser()->reseller;
                $subscriptions = $this->listFromReseller($reseller);
            break;
            case 'Customer':
                $customer = $this->getUser()->customer;
                $subscriptions = $this->listFromCustomer($customer);
            break;
            
            default:
                # code...
                break;
        }

        return view('subscriptions.index', compact('subscriptions'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function show(Subscription $subscription)
    {
        dd($this->getUserLevel());

        $subscriptions = [];
        switch ($this->getUserLevel()) {
            case 'Customer':
                # code...
                break;
            
            default:
                # code...
                break;
        }

        return view('subscriptions.list', compact('subscriptions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscription $subscriptions)
    {

        $subscription = Subscription::where('id', 610000)->first();

        return view('subscriptions.edit', compact('subscription'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscription $subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
    {
        //
    }

    public function listFromProvider(Provider $provider)
    {
        $subscriptions = $this->providerRepository->getSubscriptions($provider);

        return $subscriptions;
    }

    public function listFromReseller(Reseller $reseller)
    {
        $subscriptions = $this->resellerRepository->getSubscriptions($reseller);

        return $subscriptions;
    }

    public function listFromCustomer(Customer $customer)
    {
        $subscriptions = $this->customerRepository->getSubscriptions($customer);

        return $subscriptions;
    }
}
