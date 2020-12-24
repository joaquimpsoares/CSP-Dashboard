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
        ResellerRepositoryInterface $resellerRepository,
        OrderRepositoryInterface $orderRepository,
        CustomerRepositoryInterface $customerRepository,
        SubscriptionRepositoryInterface $subscriptionRepository,
        ProviderRepositoryInterface $providerRepository)
    {
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


        $query = AzureResource::groupBy('category')->selectRaw('sum(cost) as sum, category')->orderBy('sum', 'DESC')->get()->toArray();
        $top10Q = AzureResource::groupBy('category')->selectRaw('sum(cost) as sum, category')->orderBy('sum', 'DESC')->limit(10)->get()->toArray();
        $msdate = AzureResource::select('azure_updated_at')->first();
        $dateupdated = AzureResource::select('updated_at')->first();
        $resourceName = AzureResource::groupBy('name')->selectRaw('sum(cost) as sum, name, category, subcategory')->orderBy('sum', 'DESC')->get();
        $resourcet5Name = AzureResource::groupBy('name')->selectRaw('sum(cost) as sum, name, category, subcategory')->orderBy('sum', 'DESC')->limit(5)->get();
        // $date = AzureResource::selectRaw('DATE_FORMAT(azure_updated_at, "%d-%b-%Y") as date')->first();


        $category = array_column($query, 'category');
        $sum = array_column($query, 'sum');

        $top10C = array_column($top10Q, 'category');
        $top10S = array_column($top10Q, 'sum');


        // TODO: cache key should be dynamic by customer
        $budget = cache()->remember('azure.budget', 0, function(){

        $customer = new TagydesCustomer([
            'id' => '3bd72a86-a8ea-44a6-a899-f3cccbedf027',
            'username' => 'bill@tagydes.com',
            'password' => 'blabla',
            'firstName' => 'Nombre',
            'lastName' => 'Apellido',
            'email' => 'bill@tagydes.com',
            ]);

        $subscription = new TagydesSubscription([
            'id'            => '3159263E-B866-40ED-AB54-FD68638C9193',
            'orderId'       => "C01AD64D-6D65-45C4-B755-C11BD4F0DA0E",
            'offerId'       => "C01AD64D-6D65-45C4-B755-C11BD4F0DA0E",
            'customerId'    => "3bd72a86-a8ea-44a6-a899-f3cccbedf027",
            'name'          => "5trvfvczdfv",
            'status'        => "5trvfvczdfv",
            'quantity'      => "1",
            'currency'      => "EUR",
            'billingCycle'  => "monthly",
            'created_at'    => "5trvfvczdfv",
            ]);


        $subscriptions = Subscription::where('instance_id', '3')->first();


        $instance = Instance::where('id', $subscriptions->instance_id)->first();
        return (int) FacadesAzureResource::withCredentials(
            $instance->external_id,$instance->external_token
            )->budget($customer, $subscription);
        });

        $costSum = AzureResource::sum('cost');
        $costSum = "3000";

        $budget = "1000";

        $increase = ($budget-$costSum);


        if($increase !== 0){
            $average1 = ($increase/$budget)*100;
            $average = 100-$average1;

        return view('analytics.azure', [
            'category' => json_encode($category, JSON_NUMERIC_CHECK),
            'query' => $query,
            'top10q'=> collect($top10Q),
            'sum' => json_encode($sum, JSON_NUMERIC_CHECK),
            'total' => $costSum,
            'budgetAndTotal' => json_encode([$budget, $budget - $costSum ], JSON_NUMERIC_CHECK),
            'budget' => $budget,
            'date' => $msdate,
            'dateupdated' => $dateupdated,
            'resourceName' => $resourceName,
            'average' => (int) $average,
            'resourcet5Name' => $resourcet5Name,
            'top10C' => json_encode($top10C, JSON_NUMERIC_CHECK),
            'top10S' => json_encode($top10S, JSON_NUMERIC_CHECK)
            ]);
        }



    return view('analytics.azure', [
        'category' => json_encode($category, JSON_NUMERIC_CHECK),
        'query' => json_encode($query, JSON_NUMERIC_CHECK),
        'top10q'=> json_encode($top10Q, JSON_NUMERIC_CHECK),
        'sum' => json_encode($sum, JSON_NUMERIC_CHECK),
        'total' => $costSum,
        'budgetAndTotal' => json_encode([$budget, $budget - $costSum ], JSON_NUMERIC_CHECK),
        'budget' => $budget,
        'date' => $msdate,
        'dateupdated' => $dateupdated,
        'resourceName' => $resourceName,
        'average' => (int) ['0'],
        'resourcet5Name' => $resourcet5Name,
        'top10C' => json_encode($top10C, JSON_NUMERIC_CHECK),
        'top10S' => json_encode($top10S, JSON_NUMERIC_CHECK)
        ]);
    }


    /**
    *
    */
    Public function UpdateAZURE()
    {
        $subscriptions = Subscription::select('instance_id')->first();

            $instance = Instance::where('id', 4)->first();

        $customer = new TagydesCustomer([
            'id' => 'd163a580-2fe2-4f80-ba11-88d166109503',
            'username' => 'bill@tagydes.com',
            'password' => 'blabla',
            'firstName' => 'Nombre',
            'lastName' => 'Apellido',
            'email' => 'bill@tagydes.com',
            ]);

        $subscription = new TagydesSubscription([
            'id'            => '0ABBD8ED-CDB8-4C3C-B1A3-8415F82F7D7A',
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


            $subscriptions = Subscription::select('instance_id')->first();


            $instance = Instance::where('id', $subscriptions->instance_id)->first();

        $resources = FacadesAzureResource::withCredentials(
            $instance->external_id,$instance->external_token
            )->all($customer, $subscription);


        $resources->each(function($resource){
            AzureResource::updateOrCreate([
                'azure_id' => $resource->id
            ], [
                'name' => $resource->name,
                'category' => $resource->category,
                'unit' => $resource->unit,
                'subcategory' => $resource->subcategory,
                'currency' => $resource->currencyLocale,
                'cost' => $resource->totalCost,
                'used' => $resource->quantityUsed,
                'azure_updated_at' => Carbon::parse($resource->lastModifiedDate),
                ]);
            });
        return back()->withInput();
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
            //         ->with('message', 'Thanks for your message. We\'ll be in touch.');
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
