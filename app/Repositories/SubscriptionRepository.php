<?php

namespace App\Repositories;

use App\User;
use App\Customer;
use App\Reseller;
use App\Subscription;
use App\Http\Traits\UserTrait;
use Illuminate\Support\Collection;
use App\Repositories\SubscriptionRepositoryInterface;



/**
*
*/
class SubscriptionRepository implements SubscriptionRepositoryInterface
{

    use UserTrait;

    public function all()
    {
        $user = $this->getUser();
        $subscriptions = null;

        switch ($this->getUserLevel()) {
            case config('app.super_admin'):
                $subscriptions = Subscription::with(['customer','products','status'])->
                orderBy('id')
                ->paginate(10);
            break;

            case config('app.admin'):
                $subscriptions = Subscription::with(['customer','products','status'])->
                orderBy('id')
                ->paginate(10);
            break;

            case config('app.provider'):
                $reseller =$user->provider->resellers;


                foreach ($reseller as $resellers){

                    $reseller = Reseller::find($resellers['id']);
                    $customers = $this->customersOfReseller($reseller);
                    $subscriptions = $customers->flatMap(function ($values) {
                        $customer = Customer::find($values['id']);
                        $subscriptions = $this->subscriptionsOfCustomer($customer);
                        return $subscriptions;
                    });
                    return $subscriptions;
                }
            break;

            case config('app.reseller'):
                $reseller = $user->reseller;
                $customer = $reseller->customers->pluck('id');
                $subscriptions = Subscription::with(['customer','products','status'])->whereIn('customer_id', $customer)
                ->orderBy('id')->paginate(10);
            break;

            case config('app.subreseller'):
                $reseller = $user->reseller;
                $customer = $reseller->customers->pluck('id');
                $subscriptions = Customer::with(['customer','products','status'])->whereHas('resellers', function($query) use  ($customer) {
                	$query->whereIn('id', $customer);
                })->with(['country', 'status' => function ($query) {
					$query->where('name', 'messages.active');
				}])
                ->orderBy('company_name')->get();
            break;
            case config('app.customer'):
                $reseller = $user->customer;
                $subscriptions = $reseller->subscriptions;
            break;

            default:
            return abort(403, __('errors.unauthorized_action'));

        break;
    }

    return $subscriptions;
    }




    public function customersOfReseller(Reseller $reseller)
    {

        $customers = $reseller->customers->map->format();

        return $customers;
    }


    public function subscriptionsOfCustomer(Customer $customer){

        $subscriptions = $customer->subscriptions;

        return $subscriptions;
    }

    public function paginate($perPage, $search = null, $customer = null)
    {

        $query = Subscription::query();

        if ($customer) {
            $customer = Customer::where('company_name',"like", "%{$customer}%")->first();
        if ($customer) {
            $query->with('customer')->where('customer_id', $customer->id);
            }
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', "like", "%{$search}%");
                $q->orWhere('billing_period', 'like', "%{$search}%");
            });
        }

        $result = $query->orderBy('id', 'desc')
            ->paginate($perPage);

        if ($search) {
            $result->appends(['search' => $search]);
        }

        if ($customer) {
            $result->appends(['customer' => $customer]);
        }

        return $result;
    }

    public function paginateProvider($perPage, $search = null, $searchcustomer = null, $provider)
    {
        $query = Subscription::query();

        $resellers= $provider->resellers;

		foreach ($resellers as $reseller){
            $customers=$reseller->customers;
			foreach($customers as $customer)
			{
                if ($searchcustomer) {
                    $searchcustomer = Customer::where('company_name',"like", "%{$searchcustomer}%")->first();
                    if ($searchcustomer) {
                        $query->where('customer_id', $searchcustomer->id);
                    }
                }

                if ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->orwhere('name', "like", "%{$search}%");
                        $q->orWhere('billing_period', 'like', "%{$search}%");
                    });
                }
                $result = $query
                ->orwhere('customer_id', $customer->id)
                ->orderBy('id', 'desc')
                ->paginate($perPage);
			}
        }

        if ($search) {
            $result->appends(['search' => $search]);
        }

        if ($searchcustomer) {
            $result->appends(['customer' => $searchcustomer]);
        }
        return $result;

    }

}
