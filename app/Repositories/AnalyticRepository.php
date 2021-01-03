<?php

namespace App\Repositories;

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
use App\Repositories\AnalyticRepositoryInterface;

/**
*
*/
class AnalyticRepository implements AnalyticRepositoryInterface
{

    use UserTrait;

    public function all($customer_id, Subscription $subscription)
    {

        $query = AzureResource::groupBy('category')->selectRaw('sum(cost) as sum, category')->orderBy('sum', 'DESC')->get()->toArray();
        $top10Q = AzureResource::groupBy('category')->selectRaw('sum(cost) as sum, category')->orderBy('sum', 'DESC')->limit(10)->get()->toArray();
        $msdate = AzureResource::select('azure_updated_at')->first();
        $dateupdated = AzureResource::select('updated_at')->first();
        $resourceName = AzureResource::groupBy('name')->selectRaw('sum(cost) as sum, name, category, subcategory')->orderBy('sum', 'DESC')->get();
        $resourcet5Name = AzureResource::groupBy('name')->selectRaw('sum(cost) as sum, name, category, subcategory')->orderBy('sum', 'DESC')->limit(5)->get();

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

        // $user = Subscription::find($subscription->subscription_id);
        // dd($user);

        // $user->budget = $budget;

        $subscription->save();

        // $subscription = Subscription::findorfail($subscription->subscription_id);
        // dd($subscription);



        $costSum = AzureResource::sum('cost');

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


    public function UpdateAZURE($customer_id, Subscription $subscription)
    {


        $subscriptions = Subscription::select('instance_id')->first();

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



        $resources->each(function($resource) use($subscription){
            AzureResource::updateOrCreate([
                'azure_id' => $resource->id,
                'subscription_id' => $subscription->id
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

            return redirect()->back()->with('success', 'Resources Updated succesfully');
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


    public function canInteractWithCustomer(Customer $customer)
    {

            $user = $this->getUser();

            switch ($this->getUserLevel()) {
                case config('app.super_admin'):
                    return true;
                break;

                case config('app.admin'):
                    return true;
                break;

                case config('app.provider'):

                break;

                case config('app.reseller'):
                    $reseller = $user->reseller;
                    return $reseller->customers->contains($customer->id);
                break;

                case config('app.subreseller'):

                break;

                case config('app.customer'):
                    return in_array($user->id, $customer->users->pluck('id')->toArray());
                break;

                default:
                return false;

            break;
        }
    }

    public function customersOfReseller(Reseller $reseller)
    {

        $customers = $reseller->customers->map->format();

        return $customers;
    }

    public function ResellerOfcustomer(Customer $customer)
    {

        $reseller = $customer->resellers;

        return $reseller;
    }

    public function getSubscriptions(Customer $customer)
    {

        $subscriptions= $customer->subscriptions;

        return $subscriptions;

    }
}
