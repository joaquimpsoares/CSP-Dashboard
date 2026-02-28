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
    // public function index()
    // {
    //     return view('analytics.azure');
    // }

    // public function updatepricesinreports(){
    //     // $resource = AzureUsageReport::get();

    //     $teste = DB::table('azure_usage_reports')
    //     ->lazyById()->each(function ($resource) {
    //         DB::table('azure_price_lists')
    //         ->where('resource_id',$resource->resource_id)->first();
    //     });
    //     dd($teste);
    //     // $resource->each(function ($price) {
    //     //     $cost= AzurePriceList::where('resource_id',$price->resource_id)->first();
    //     //     Log::channel('azure')->info('This price ' .$cost->resource_id.' for resource '.$price->resource_id.' name '.$price->name. ' has this cost ' .$cost->rates[0]);
    //     //     $cost = ($price->quantity*$cost->rates[0]);
    //     //     $update = $price->update(['cost' => $price->quantity*$cost->rates[0]]);
    //     // });
    // }

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
        // Azure Resource API not yet implemented in MicrosoftCspConnection module.
        Log::warning('AnalyticController::edit() — AzureResource API not yet implemented.');
        return back()->with('danger', 'Azure budget management is not available.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        // Azure Resource API not yet implemented in MicrosoftCspConnection module.
        Log::warning('AnalyticController::show() — AzureResource API not yet implemented.');
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
    /**
     * Service costs API not yet implemented in MicrosoftCspConnection module.
     * Returns null — views must handle null gracefully.
     */
    public function CustomerServiceCosts($customer)
    {
        Log::warning('AnalyticController::CustomerServiceCosts() — service costs API not yet implemented.', [
            'customer' => is_string($customer) ? $customer : (is_object($customer) ? $customer->id : null),
        ]);
        return null;
    }

    /**
     * Azure price list API not yet implemented in MicrosoftCspConnection module.
     */
    public function azurepricelist()
    {
        Log::warning('AnalyticController::azurepricelist() — AzureResource API not yet implemented.');
    }

    /**
     * Azure utilization export not yet implemented in MicrosoftCspConnection module.
     */
    public function export(Customer $customer, Subscription $subscription)
    {
        Log::warning('AnalyticController::export() — AzureResource API not yet implemented.');
        return redirect()->back()->with('danger', 'Azure usage export is not available.');
    }
}
