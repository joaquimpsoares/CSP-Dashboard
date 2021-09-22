<?php

namespace App\Http\Controllers\web;

ini_set('memory_limit', '4024M');
ini_set('max_execution_time', 30000);



use App\Customer;
use App\Instance;
use App\Subscription;
use Illuminate\Support\Str;
use App\Models\AzureResource;
use App\Http\Traits\UserTrait;
use App\Models\AzurePriceList;
use App\Models\AzureUsageReport;
use Illuminate\Support\Facades\DB;
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
        return view('analytics.azure');
    }

    public function updatepricesinreports(){
        // $resource = AzureUsageReport::get();

        $teste = DB::table('azure_usage_reports')
        ->lazyById()->each(function ($resource) {
            DB::table('azure_price_lists')
            ->where('resource_id',$resource->resource_id)->first();
        });
        dd($teste);
        // $resource->each(function ($price) {
        //     $cost= AzurePriceList::where('resource_id',$price->resource_id)->first();
        //     Log::channel('azure')->info('This price ' .$cost->resource_id.' for resource '.$price->resource_id.' name '.$price->name. ' has this cost ' .$cost->rates[0]);
        //     $cost = ($price->quantity*$cost->rates[0]);
        //     $update = $price->update(['cost' => $price->quantity*$cost->rates[0]]);
        // });
    }

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


    public function azurepricelist()
    {
        $instance = Instance::where('id', 1)->first();
        $resources = FacadesAzureResource::withCredentials(
            $instance->external_id,
            $instance->external_token
        )->azurepricelist();
        $resources->meters->each(function ($resource) {
            $resourceGroup = Str::of($resource->instanceData->resourceUri)->explode('/');
            $resource = AzurePriceList::updateOrCreate([
                'resource_id'           => $resource->id,
            ], [
                'rates'                  => $resource->rates,
                'effectiveDate'          => $resource->effectiveDate,
                'name'                   => $resource->name,
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
                $price = AzurePriceList::where('resource_id', $resource->resource->id)->first();
                Log::channel('azure')->info('for this resource id '.$resource->resource->id. ' this price ' . $resource->prices  );
                $cost = (json_encode($price->rates[0])*$resource->quantity);
                Log::channel('azure')->info('for this resource id we calculated this much '.$cost);

                $resource = AzureUsageReport::updateOrCreate([
                    'subscription_id'       => $subscription->id,
                    'resource_id'           => $resource->resource->id,
                    'usageStartTime'        => $resource->usageStartTime,
                    'usageEndTime'          => $resource->usageEndTime,
                    'resource_group'        => $resourceGroup[4],
                    'resource_location'     => $resource->instanceData->location,
                    'resource_name'         => $resource->resource->name,
                    'resource_category'     => $resource->resource->category,
                    'resource_subcategory'  => $resource->resource->subcategory,
                    'resource_region'       => $resource->resource->region,
                    'unit'                  => $resource->unit,
                    'name'                  => $resourceGroup[8] ?? null,
                    "resourceType"          => $resource->instanceData->additionalInfo->toArray()['resourceType'] ?? null,
                    "usageResourceKind"     => $resource->instanceData->additionalInfo->toArray()['usageResourceKind'] ?? null,
                    "dataCenter"            => $resource->instanceData->additionalInfo->toArray()['dataCenter'] ?? null,
                    "networkBucket"         => $resource->instanceData->additionalInfo->toArray()['networkBucket'] ?? null,
                    "pipelineType"          => $resource->instanceData->additionalInfo->toArray()['pipelineType'] ?? null,
                ], [
                    'quantity'              => $resource->quantity,
                    'cost'                  => $cost ?? [0]
                ]);
            });
        });
    }
}
