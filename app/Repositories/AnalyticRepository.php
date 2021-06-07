<?php

namespace App\Repositories;

use App\Customer;
use App\Instance;
use App\Reseller;
use Carbon\Carbon;
use App\Subscription;
use App\AzureResource;
use App\Http\Traits\UserTrait;
use App\Repositories\AnalyticRepositoryInterface;
use Tagydes\MicrosoftConnection\Models\Customer as TagydesCustomer;
use Tagydes\MicrosoftConnection\Models\Subscription as TagydesSubscription;
use Tagydes\MicrosoftConnection\Facades\AzureResource as FacadesAzureResource;

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

                $customer = Customer::whereHas('resellers', function($query) use  ($resellers) {
                    $query->whereIn('id', $resellers);
                })->with(['country'])
                ->orderBy('company_name')->get()->map->format();
                $azure = Subscription::with(['customer','products','status'])->where('billing_type', 'usage')->whereIn('customer_id', $customer)
                ->orderBy('id')->paginate(10);

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

        $query = AzureResource::groupBy('category')->where('subscription_id', $subscription->id)->selectRaw('sum(cost) as sum, category')->orderBy('sum', 'DESC')->get()->toArray();
        $top10Q = AzureResource::groupBy('category')->where('subscription_id', $subscription->id)->selectRaw('sum(cost) as sum, category')->orderBy('sum', 'DESC')->limit(10)->get()->toArray();
        $msdate = AzureResource::select('azure_updated_at')->where('subscription_id', $subscription->id)->first();
        $dateupdated = AzureResource::select('updated_at')->where('subscription_id', $subscription->id)->first();
        $resourceName = AzureResource::groupBy('name')->where('subscription_id', $subscription->id)->selectRaw('sum(cost) as sum, name, category, subcategory')->orderBy('sum', 'DESC')->get();
        $resourcet5Name = AzureResource::groupBy('name')->where('subscription_id', $subscription->id)->selectRaw('sum(cost) as sum, name, category, subcategory')->orderBy('sum', 'DESC')->limit(5)->get();
        $category = array_column($query, 'category');
        $sum = array_column($query, 'sum');
        $top10C = array_column($top10Q, 'category');
        $top10S = array_column($top10Q, 'sum');

        // TODO: cache key should be dynamic by customer
        $budget = cache()->remember('azure.budget', 0, function() use($customer_id, $subscription){

        $instance = Instance::where('id', $subscription->instance_id)->first();

        $customer = new TagydesCustomer([
            'id' => $customer_id,
            'username' => 'bill@tagydes.com',
            'password' => 'blabla',
            'firstName' => 'Nombre',
            'lastName' => 'Apellido',
            'email' => 'bill@tagydes.com',
            ]);

        $subscription = new TagydesSubscription([
            'id'            => $subscription->subscription_id,
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

        return (int) FacadesAzureResource::withCredentials(
            $instance->external_id,$instance->external_token
            )->budget($customer, $subscription);

        });

        $subscription->budget = $budget;
        $subscription->save();
        $budget = $subscription->budget;

        $costSum = AzureResource::where('subscription_id', $subscription->id)->sum('cost');

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

    public function importBudget($customer_id, Subscription $subscription){

        $budget = cache()->remember('azure.budget', 0, function() use($customer_id,$subscription){

            $customer = new TagydesCustomer([
                'id' => $customer_id,
                'username' => 'bill@tagydes.com',
                'password' => 'blabla',
                'firstName' => 'Nombre',
                'lastName' => 'Apellido',
                'email' => 'bill@tagydes.com',
                ]);

            $subscription = new TagydesSubscription([
                'id'            => $subscription->subscription_id,
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


            $instance = Instance::where('id', $subscription->instance_id)->first();

            return (int) FacadesAzureResource::withCredentials(
                $instance->external_id,$instance->external_token
                )->budget($customer, $subscription);
            });

    }


    public function UpdateAZURE($customer_id, Subscription $subscriptions)
    {
        $instance = Instance::where('id', $subscriptions->instance_id)->first();

        $customer = new TagydesCustomer([
            'id' => $customer_id,
            'username' => 'bill@tagydes.com',
            'password' => 'blabla',
            'firstName' => 'Nombre',
            'lastName' => 'Apellido',
            'email' => 'bill@tagydes.com',
            ]);

        $subscription = new TagydesSubscription([
            'id'            => $subscriptions->subscription_id,
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


        $resources = FacadesAzureResource::withCredentials(
            $instance->external_id,$instance->external_token
            )->all($customer, $subscription);

        $resources->each(function($resource) use($subscriptions){
            $resource = AzureResource::updateOrCreate([
                'subscription_id' => $subscriptions->id,
                'azure_id' => $resource->meterId,
            ], [
                'name' => $resource->meterName,
                'category' => $resource->category,
                'unit' => $resource->unit,
                'subcategory' => $resource->subcategory,
                'currency' => $resource->currencyLocale,
                'cost' => $resource->totalCost,
                'used' => $resource->quantityUsed,
                'azure_updated_at' => Carbon::parse($resource->lastModifiedDate),
                ]);
                if ($resource->wasRecentlyCreated){
                    $subscriptions->azureresources()->attach($resource->id);
                }
            });

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
