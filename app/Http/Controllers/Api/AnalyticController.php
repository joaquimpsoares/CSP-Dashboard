<?php

namespace App\Http\Controllers\Api;

ini_set('memory_limit', '1024M');
ini_set('max_execution_time', 30000);



use App\Customer;
use App\Instance;
use App\Subscription;
use App\Models\AzureResource;
use Illuminate\Support\Str;
use App\Http\Traits\UserTrait;
use App\Models\AzurePriceList;
use App\Models\AzureUsageReport;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
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
        ProviderRepositoryInterface $providerRepository
    ) {
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
        $subscriptions = Subscription::where('billing_type', 'usage')->first();

        $resourceName = $this->analyticRepository->getAzureSubscriptions();

        $resourceName->map(function ($item, $key) {
            foreach ($item->azureresources as $resource) {
                $increase = ($item->budget - $item->azureresources->sum('cost'));
                if ($item->budget > '0') {
                    if ($increase !== '0') {
                        $average1 = ($increase / $item->budget) * 100;
                        $item['calculated'] = 100 - $average1;
                    } else {
                        $item['calculated'] = '0';
                    }
                    return $item;
                }
            }
        });

        return $resourceName;
    }


    /**
     *
     */
    public function getAzuredetails(Customer $customer, Subscription $subscription)
    {
        $msId = $customer->microsoftTenantInfo->first()->tenant_id;

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
            'subscription' => $subscription

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateAZURE(Customer $customer, Subscription $subscription)
    {

        $msId = $customer->microsoftTenantInfo->first()->tenant_id;

        $details = $this->analyticRepository->UpdateAZURE($msId, $subscription);

        return redirect()->back()->with('success', ucwords(trans_choice('messages.resouces_updated', 1)));
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
            $instance->external_id,
            $instance->external_token
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


        $budget = cache()->remember('azure.budget', 0, function () {

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
                $instance->external_id,
                $instance->external_token
            )->budget($customer, $subscription);
        });


        $costSum = AzureResource::sum('cost');

        $increase = ($budget - $costSum);
        $average1 = ($increase / $budget) * 100;
        $average = 100 - $average1;

        $customer = Customer::first();


        $data = ([
            'customer' => $customer,
            'average' => (int) $average,
            'costSum' => $costSum,
            'budget'  => $budget
        ]);
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
                $serviceCosts = $customer->map(function ($item, $key) {
                    if ($item->microsoftTenantInfo->first() == null) {
                        return ($serviceCosts = null);
                    } else {
                        $tenant = $item->microsoftTenantInfo->first()->tenant_id;
                        $serviceCosts = $this->CustomerServiceCosts($tenant);

                        return $serviceCosts;
                    }
                });

                $serviceCosts = $serviceCosts->filter(function ($value) {
                    return !is_null($value);
                });

                return view('analytics.licenses', compact('serviceCosts', 'customer'));

                break;

            case config('app.admin'):


                break;

            case config('app.provider'):

                $customer = $this->customerRepository->all();
                $serviceCosts = $customer->map(function ($item, $key) {
                    if ($item['tenant_id'] == null) {
                        return ($serviceCosts = null);
                    }
                    $tenant = $item['tenant_id']->tenant_id;
                    $serviceCosts = $this->CustomerServiceCosts($tenant);
                    return $serviceCosts;
                });

                $serviceCosts = $serviceCosts->filter(function ($value) {
                    return !is_null($value);
                });;

                return view('analytics.licenses', compact('serviceCosts', 'customer'));
                break;

            case config('app.reseller'):

                $customer = $this->customerRepository->all();
                $serviceCosts = $customer->map(function ($item, $key) {
                    if ($item['tenant_id'] == null) {
                        return ($serviceCosts = null);
                    }
                    $tenant = $item['tenant_id']->tenant_id;
                    $serviceCosts = $this->CustomerServiceCosts($tenant);
                    return $serviceCosts;
                });

                $serviceCosts = $serviceCosts->filter(function ($value) {
                    return !is_null($value);
                });;

                return view('analytics.licenses', compact('serviceCosts', 'customer'));

                break;

            case config('app.subreseller'):

                break;

            case config('app.customer'):

                $customer = $this->getUser()->customer->format();

                $tenant = $customer['tenant_id']->tenant_id;
                $serviceCosts = $this->CustomerServiceCosts($tenant);
                return $serviceCosts;

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
    public function CustomerServiceCosts($customer)
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

    public function azurepricelist($id)
    {
        $instance = Instance::find($id);
        dd($instance);

        $resources = FacadesAzureResource::withCredentials(
            $instance->external_id,
            $instance->external_token
        )->azurepricelist();

        $resources->meters->each(function ($resource) {
            $resourceGroup = Str::of($resource->instanceData->resourceUri)->explode('/');
            $resource = AzurePriceList::updateOrCreate([
                'resource_id'           => $resource->id,
                'effectiveDate'         => $resource->effectiveDate,
            ], [
                'name'                   => $resource->name,
                'rates'                  => $resource->rates,
                'tags'                   => $resource->tags,
                'category'               => $resource->category,
                'subcategory'            => $resource->subcategory,
                'region'                 => $resource->region,
                'unit'                   => $resource->unit,
                'includedQuantity'       => $resource->includedQuantity,
            ]);
        });
    }

    public function export(Customer $customer, Subscription $subscription)
    {
        $msId = $customer->microsoftTenantInfo->first()->tenant_id;

        $instance = Instance::where('id', $subscription->instance_id)->first();

        $customer = new TagydesCustomer([
            'id' => $msId,
            'username' => 'bill@tagydes.com',
            'password' => 'blabla',
            'firstName' => 'Nombre',
            'lastName' => 'Apellido',
            'email' => 'bill@tagydes.com',
        ]);


        $subscriptions = new TagydesSubscription([
            'id'            => $subscription->subscription_id,
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


        $pages = FacadesAzureResource::withCredentials($instance->external_id, $instance->external_token)->utilizations($customer, $subscriptions);

        $pages->each(function ($page) use ($subscription) {
            $page->items->each(function ($resource) use ($subscription) {
                $resourceGroup = Str::of($resource->instanceData->resourceUri)->explode('/');

                // $price = AzurePriceList::updateOrCreate(
                //     [
                //         'resource_id'   => $resource->resource->id,
                //     ],[
                //         'rates' => "[0]"
                //     ])->first('rates');

                Log::info($resource->resource->id);

                // $cost = (json_encode($price->rates[0])*$resource->quantity);

                $resource = AzureUsageReport::updateOrCreate([
                    'subscription_id'       => $subscription->id,
                    'resource_name'         => $resource->resource->name,
                    'name'                  => $resourceGroup[8] ?? null,
                    'resource_id'           => $resource->resource->id,
                    'resource_group'        => $resourceGroup[4],
                ], [
                    'usageStartTime'        => $resource->usageStartTime,
                    'usageEndTime'          => $resource->usageEndTime,
                    'resource_location'     => $resource->instanceData->location,
                    'resource_category'     => $resource->resource->category,
                    'resource_subcategory'  => $resource->resource->subcategory,
                    'resource_region'       => $resource->resource->region,
                    'unit'                  => $resource->unit,
                    "resourceType"          => $resource->instanceData->additionalInfo->toArray()['resourceType'] ?? null,
                    "usageResourceKind"     => $resource->instanceData->additionalInfo->toArray()['usageResourceKind'] ?? null,
                    "dataCenter"            => $resource->instanceData->additionalInfo->toArray()['dataCenter'] ?? null,
                    "networkBucket"         => $resource->instanceData->additionalInfo->toArray()['networkBucket'] ?? null,
                    "pipelineType"          => $resource->instanceData->additionalInfo->toArray()['pipelineType'] ?? null,
                    'quantity'              => $resource->quantity,
                    // 'cost'                  => (json_encode($price->rates[0])*$resource->quantity) ?? '0'
                    ]);
                    $price = AzurePriceList::where('resource_id', $resource->resource_id)->first();
                    $price = $resource->quantity*$price->rates[0];
                    $resource->update(['cost' => $price]);
                    Log::channel('azure')->info('updated '.$resource->resource_name. ' With price '. $price);
                });
            });
    }

    // public function azurereport(Subscription $subscription)
    // {


        // $reports = AzureUsageReport::where('subscription_id', $subscription->id)->groupBy('resource_id')->get();

        // $reports->map(function($item, $key) {
        //     $azurepricelist = AzurePriceList::where('resource_id', $item->resource_id)->get('rates');
        //     if ($azurepricelist->first()){
        //         $item['cost'] = $item->quantity+$azurepricelist->first()->rates[0];
        //     }
        //     $item->cost;
        //     $item->save();
        //     return $item;
        // });


        // $top5Q = AzureUsageReport::groupBy('resource_group')->where('subscription_id', $subscription->id)->selectRaw('sum(cost) as sum, resource_group, resource_category')->orderBy('sum', 'DESC')->limit(5)->get()->toArray();
        // $resourceGroups = AzureUsageReport::where('subscription_id', $subscription->id)->groupBy('usageStartTime')->pluck('resource_group');
        // $categories = AzureUsageReport::where('subscription_id', $subscription->id)->groupBy('usageStartTime')->pluck('resource_category');
        // $subcategories = AzureUsageReport::where('subscription_id', $subscription->id)->groupBy('usageStartTime')->pluck('resource_subcategory');
        // $region = AzureUsageReport::where('subscription_id', $subscription->id)->groupBy('resource_region')->pluck('resource_region');


        // return view('analytics.azurereports', [
        //     'reports' => $reports,
        //     'top5Q' => $top5Q,
        //     'resourceGroups' => $resourceGroups,
        //     'categories' => $categories,
        //     'subcategories' => $subcategories,
        //     'region' => $region,
        //     'subscription' => $subscription,
        // ]);
        // return view('analytics.azurereports', compact('subscription'));
    // }
}
