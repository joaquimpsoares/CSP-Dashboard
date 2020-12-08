<?php

namespace App\Http\Controllers\Web;

use App\Customer;
use App\Provider;

use App\Reseller;
use App\Scopes\ProviderScope;
use App\Http\Traits\UserTrait;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\ProviderRepositoryInterface;
use App\Repositories\ResellerRepositoryInterface;
use Doctrine\Inflector\Rules\Substitutions;

class HomeController extends Controller
{

    use UserTrait;

    private $providerRepository;
    private $resellerRepository;
    private $customerRepository;
    private $userRepository;



    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct(ProviderRepositoryInterface $providerRepository, ResellerRepositoryInterface $resellerRepository, CustomerRepositoryInterface $customerRepository)
    {
        $this->providerRepository = $providerRepository;
        $this->resellerRepository = $resellerRepository;
        $this->customerRepository = $customerRepository;
        $this->middleware('auth');
    }

    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */
    public function index()
    {

        // $user = $this->getUser();

        $resellers = Reseller::withoutGlobalScope(ProviderScope::class)->get();
        $providers = Provider::withoutGlobalScope(ProviderScope::class)->get();
        $customers = Customer::withoutGlobalScope(ProviderScope::class)->get();
        // $subscriptions = Substitutions::withoutGlobalScope(ProviderScope::class)->get();


        return view('home', compact('resellers', 'providers', 'customers'));
    }

}
