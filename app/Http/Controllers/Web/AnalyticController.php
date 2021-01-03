<?php

namespace App\Http\Controllers\web;

use App\Customer;
use App\Instance;
use App\Reseller;
use Carbon\Carbon;
use App\Subscription;
use App\AzureResource;
use App\MicrosoftTenantInfo;
use App\Http\Traits\UserTrait;
use App\Mail\ScheduleNotifyAzure;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Request;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\AnalyticRepositoryInterface;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\ProviderRepositoryInterface;
use App\Repositories\ResellerRepositoryInterface;
use App\Repositories\SubscriptionRepositoryInterface;
use Tagydes\MicrosoftConnection\Models\Customer as TagydesCustomer;
use Tagydes\MicrosoftConnection\Facades\Customer as MicrosoftCustomer;
use Tagydes\MicrosoftConnection\Models\Subscription as TagydesSubscription;
use Tagydes\MicrosoftConnection\Facades\AzureResource as FacadesAzureResource;
// use Tagydes\MicrosoftConnection\Repositories\AzureResource\RestV1AzureResourceRepository;

class AnalyticController extends Controller
{
    use UserTrait;

    private $resellerRepository;

    public function __construct(
        AnalyticRepositoryInterface $analyticRepository,
        ResellerRepositoryInterface $resellerRepository,
        OrderRepositoryInterface $orderRepository,
        CustomerRepositoryInterface $customerRepository,
        SubscriptionRepositoryInterface $subscriptionRepository,
        ProviderRepositoryInterface $providerRepository)
        {
            $this->analyticRepository = $analyticRepository;
            $this->resellerRepository = $resellerRepository;
            $this->customerRepository = $customerRepository;
            $this->subscriptionRepository = $subscriptionRepository;
            $this->providerRepository = $providerRepository;
            $this->orderRepository = $orderRepository;
        }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $resourceName = Subscription::where('billing_type', 'usage')
        ->join('azure_resources', 'azure_resources.subscription_id', '=', 'subscriptions.subscription_id')
        ->join('customers', 'subscriptions.customer_id', '=', 'customers.id')
        ->selectRaw('subscriptions.name as subsname, customers.company_name as customername,sum(cost) as sum, subscriptions.budget as budget, subscriptions.id as subscription_id, customers.id as customer_id')
        ->orderBy('sum', 'DESC')->paginate('10');


        // $resourceName = AzureResource::groupBy('azure_resources.subscription_id')
        // ->join('subscriptions', 'azure_resources.subscription_id', '=', 'subscriptions.id')
        // ->join('customers', 'subscriptions.customer_id', '=', 'customers.id')
        // ->selectRaw('subscriptions.name as subsname, customers.company_name as customername,sum(cost) as sum, subscriptions.budget as budget, subscriptions.id as subscription_id, customers.id as customer_id')
        // ->orderBy('sum', 'DESC')->paginate('10');

        $resourceName->map(function($item, $key) {
            if ($item != '0') {
                $item['calculated']=($item->sum)*100/$item->budget;
            } else {
                $item['calculated'] = '0';
            }
            return $item;
        });

        return view('analytics.azure', [
            'resourceName' => $resourceName,
            ]);
        }


    /**
    *
    */
    Public function getAzuredetails(Customer $customer, Subscription $subscription)
    {
        $msId= $customer->microsoftTenantInfo->first()->tenant_id;


        $details = $this->analyticRepository->all($msId, $subscription);

        return view('analytics.azuredetails', [
            'average' => $details->average,
            'query' => $details->query,
            'category' => $details->category,
            'top10q' =>  $details->top10q,
            'sum' =>  $details->sum,
            'total' =>  $details->total,
            'budgetAndTotal' => $details->budgetAndTotal,
            'budget' =>  $details->budget,
            'date' =>  $details->date,
            'dateupdated' =>  $details->dateupdated,
            'resourceName' => $details->resourceName,
            'average' =>     $details->average,
            'resourcet5Name' => $details->resourcet5Name,
            'top10C' =>  $details->top10C,
            'top10S' =>  $details->top10S,

            ]);
    }

     /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function updateAZURE(Customer $customer, Subscription $subscription)
    {

        $msId= $customer->microsoftTenantInfo->first()->tenant_id;

        $details = $this->analyticRepository->UpdateAZURE($msId, $subscription);

    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function edit(Request $request)
    {

        $subscriptions = Subscription::select('instance_id')->first();

        $instance = Instance::where('id', 1)->first();

        $value = $request->budget;
        $customer = new TagydesCustomer([
            'id' => '4e03835b-242f-441c-9958-ad3e5e05f55d',
            'username' => 'bill@tagydes.com',
            'password' => 'blabla',
            'firstName' => 'Nombre',
            'lastName' => 'Apellido',
            'email' => 'bill@tagydes.com',
            ]);

        $result = FacadesAzureResource::withCredentials(
            $instance->external_id,$instance->external_token
            )->changeBudget($customer, $value);

            $budget = $result;

            return back()->with(compact('budget'));
        }


    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show()
    {

        $subscriptions = Subscription::select('instance_id')->first();


        $budget = cache()->remember('azure.budget', 0, function(){

        $customer = new TagydesCustomer([
            'id' => '4e03835b-242f-441c-9958-ad3e5e05f55d',
            'username' => 'bill@tagydes.com',
            'password' => 'blabla',
            'firstName' => 'Nombre',
            'lastName' => 'Apellido',
            'email' => 'bill@tagydes.com',
            ]);

        $subscription = new TagydesSubscription([
            'id'            => 'C01AD64D-6D65-45C4-B755-C11BD4F0DA0E',
            'orderId'       => "C01AD64D-6D65-45C4-B755-C11BD4F0DA0E",
            'offerId'       => "C01AD64D-6D65-45C4-B755-C11BD4F0DA0E",
            'customerId'    => "4e03835b-242f-441c-9958-ad3e5e05f55d",
            'name'          => "5trvfvczdfv",
            'status'        => "5trvfvczdfv",
            'quantity'      => "1",
            'currency'      => "EUR",
            'billingCycle'  => "monthly",
            'created_at'    => "5trvfvczdfv",
            ]);

        $instance = Instance::where('id', 4)->first();
        return (int) FacadesAzureResource::withCredentials(
            $instance->external_id,$instance->external_token
            )->budget($customer, $subscription);
        });


        $costSum = AzureResource::sum('cost');
        // $costSum = "500";

        $increase = ($budget-$costSum);
        $average1 = ($increase/$budget)*100;
        $average = 100-$average1;

        $customer = Customer::first();


        $data = ([
            'customer'=> $customer,
            'average' => (int) $average,
            'costSum' => $costSum,
            'budget'  => $budget
            ]);

            // if ($average > 80) {
                //     Mail::to('joaquim.soares@tagydes.com')->send(new ScheduleNotifyAzure($data));

                //     return redirect('analytics')
                //         ->with('messa.ge', 'Thanks for your message. We\'ll be in touch.');
                // }else{
                    // }

    }




    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function licenses()
    {

        switch ($this->getUserLevel()) {
            case config('app.super_admin'):

        $customer = Customer::all();
        $serviceCosts = $customer->map(function($item, $key) {
            if($item->microsoftTenantInfo->first() == null){
                return ($serviceCosts = null);
            }else{
                $tenant = $item->microsoftTenantInfo->first()->tenant_id;
                $serviceCosts = $this->CustomerServiceCosts($tenant);

                return $serviceCosts;
            }
        });

        $serviceCosts = $serviceCosts->filter(function ($value) { return !is_null($value); });

        return view('analytics.licenses', compact('serviceCosts', 'customer'));

        break;

        case config('app.admin'):


            break;

            case config('app.provider'):

                $customer = $this->customerRepository->all();
                $serviceCosts = $customer->map(function($item, $key) {
                    if($item['tenant_id'] == null){
                        return ($serviceCosts = null);
                    }
                    $tenant = $item['tenant_id']->tenant_id;
                    $serviceCosts = $this->CustomerServiceCosts($tenant);
                    return $serviceCosts;
                });

                $serviceCosts = $serviceCosts->filter(function ($value) { return !is_null($value); });;

                return view('analytics.licenses', compact('serviceCosts', 'customer'));
                break;

                case config('app.reseller'):

                    $customer = $this->customerRepository->all();
                    $serviceCosts = $customer->map(function($item, $key) {
                        if($item['tenant_id'] == null){
                            return ($serviceCosts = null);
                        }
                        $tenant = $item['tenant_id']->tenant_id;
                        $serviceCosts = $this->CustomerServiceCosts($tenant);
                        return $serviceCosts;
                    });

                    $serviceCosts = $serviceCosts->filter(function ($value) { return !is_null($value); });;

                    return view('analytics.licenses', compact('serviceCosts', 'customer'));

                    break;

                    case config('app.subreseller'):

                        break;

                        case config('app.customer'):

                $customer = $this->getUser()->customer->format();

                // $serviceCosts = $customer->map(function($item, $key) {
                    //     if($item['tenant_id'] == null){
                        //         return ($serviceCosts = null);
                        //     }
                        $tenant = $customer['tenant_id']->tenant_id;
                        $serviceCosts = $this->CustomerServiceCosts($tenant);
                        return $serviceCosts;


                        // $serviceCosts = $serviceCosts->filter(function ($value) { return !is_null($value); });;

                        // return view('analytics.licenses', compact('serviceCosts', 'customer'));

                        break;

                        default:
                        return abort(403, __('errors.unauthorized_action'));


                    }


                }

/**
* Undocumented function
*
* @param [type] $customer
* @return void
*/
Public function CustomerServiceCosts($customer)
{


    $instance = session()->get('instance_id');
    $instance = Instance::where('id', '3')->first();

    try {
        $customer = new TagydesCustomer([
            'id' => $customer,
            'username' => 'bill@tagydes.com',
            'password' => 'blabla',
            'firstName' => 'Nombre',
            'lastName' => 'Apellido',
            'email' => 'bill@tagydes.com',
            ]);
            $resources = MicrosoftCustomer::withCredentials($instance->external_id, $instance->external_token)->serviceCosts($customer);

            return $resources;

        } catch (\Throwable $th) {

        }
    }
}
