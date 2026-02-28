<?php

namespace App\Repositories;

use App\Customer;
use App\Instance;
use App\Reseller;
use Carbon\Carbon;
use App\Subscription;
use App\Models\AzureResource;
use App\Http\Traits\UserTrait;
use Illuminate\Support\Facades\DB;
use App\Repositories\AnalyticRepositoryInterface;
use Illuminate\Support\Facades\Log;
// AzureResource API removed — Tagydes\MicrosoftConnection no longer available.

/**
*
*/
class AnalyticRepository implements AnalyticRepositoryInterface
{

    use UserTrait;

    public function getAzureSubscriptions()
    {
        $user = $this->getUser();

        switch ($this->getUserLevel()) {
            case config('app.super_admin'):

                $azure = Subscription::where('billing_type', 'usage')->paginate(10);

            break;

            case config('app.provider'):

                $resellers = Reseller::where('provider_id', $user->provider->id)->pluck('id')->toArray();

                $customer = Customer::whereHas('resellers', function($query) use ($resellers) {
                    $query->whereIn('id', $resellers);
                })->pluck('id')->toArray();

                $azure = Subscription::with(['customer', 'products', 'status'])
                    ->where('billing_type', 'usage')
                    ->whereIn('customer_id', $customer)
                    ->orderBy('id')
                    ->paginate(10);

            break;

            case config('app.reseller'):
                $reseller = $user->reseller;
                $customer = $reseller->customers->pluck('id');
                $azure = Subscription::with(['customer','products','status'])->where('billing_type', 'usage')->whereIn('customer_id', $customer)
                ->orderBy('id')->paginate(10);
            break;

            case config('app.customer'):
                $customer = $user->customer;
                $azure = Subscription::where('customer_id', $customer->id)->where('billing_type', 'usage')->paginate(10);
            break;


            default:
            return abort(403, __('errors.unauthorized_action'));

        break;


        }

        return $azure;
    }


    public function all($customer_id, Subscription $subscription)
    {
        $query          = AzureResource::groupBy('category')->where('subscription_id', $subscription->id)->selectRaw('sum(cost) as sum, category')->orderBy('sum', 'DESC')->get()->toArray();
        $top10Q         = AzureResource::groupBy('category')->where('subscription_id', $subscription->id)->selectRaw('sum(cost) as sum, category')->orderBy('sum', 'DESC')->limit(10)->get()->toArray();
        $msdate         = AzureResource::select('azure_updated_at')->where('subscription_id', $subscription->id)->first();
        $dateupdated    = AzureResource::select('updated_at')->where('subscription_id', $subscription->id)->first();
        $resourceName   = AzureResource::groupBy('name')->where('subscription_id', $subscription->id)->selectRaw('sum(cost) as sum, name, category, subcategory')->orderBy('sum', 'DESC')->get();
        $resourcet5Name = AzureResource::groupBy('name')->where('subscription_id', $subscription->id)->selectRaw('sum(cost) as sum, name, category, subcategory')->orderBy('sum', 'DESC')->limit(5)->get();
        $category       = array_column($query, 'category');
        $sum            = array_column($query, 'sum');
        $top10C         = array_column($top10Q, 'category');
        $top10S         = array_column($top10Q, 'sum');

        // AzureResource budget API not available — use stored budget from local DB.
        $budget  = (int) ($subscription->budget ?? 0);
        $costSum = AzureResource::where('subscription_id', $subscription->id)->sum('cost');
        $increase = ($budget - $costSum);
        if ($increase !== 0 && $budget > 0) {
            $average1 = ($increase / $budget) * 100;
            $average  = 100 - $average1;
        } else {
            $average = 0;
        }

        return view('analytics.azure', [
            'category'       => json_encode($category, JSON_NUMERIC_CHECK),
            'query'          => $query,
            'top10q'         => collect($top10Q),
            'sum'            => json_encode($sum, JSON_NUMERIC_CHECK),
            'total'          => $costSum,
            'budgetAndTotal' => json_encode([$budget, $budget - $costSum], JSON_NUMERIC_CHECK),
            'budget'         => $budget,
            'date'           => $msdate,
            'dateupdated'    => $dateupdated,
            'resourceName'   => $resourceName,
            'average'        => (int) $average,
            'resourcet5Name' => $resourcet5Name,
            'top10C'         => json_encode($top10C, JSON_NUMERIC_CHECK),
            'top10S'         => json_encode($top10S, JSON_NUMERIC_CHECK),
        ]);
    }

    public function importBudget($customer_id, Subscription $subscription)
    {
        // AzureResource budget API not yet implemented in MicrosoftCspConnection module.
        Log::warning('AnalyticRepository::importBudget() — AzureResource budget API not yet implemented.', [
            'customer_id'     => $customer_id,
            'subscription_id' => $subscription->id,
        ]);
        return 0;
    }


    public function UpdateAZURE($customer_id, Subscription $subscriptions)
    {
        // AzureResource utilization API not yet implemented in MicrosoftCspConnection module.
        Log::warning('AnalyticRepository::UpdateAZURE() — AzureResource utilization API not yet implemented.', [
            'customer_id'     => $customer_id,
            'subscription_id' => $subscriptions->id,
        ]);
    }

    public function update($customer, $validate)
    {

        $customer = Customer::find($customer->id);


        $updateCustomer = $customer->update([
            'company_name' => $validate['company_name'],
            'nif' => $validate['nif'],
            'country_id' => $validate['country_id'],
            'address_1' => $validate['address_1'],
            'address_2' => $validate['address_2'],
            'city' => $validate['city'],
            'state' => $validate['state'],
            'postal_code' => $validate['postal_code'],
            'status' => $validate['status']
        ]);
        return $updateCustomer;

    }




}
