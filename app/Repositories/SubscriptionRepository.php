<?php

namespace App\Repositories;

use App\User;
use App\Customer;
use App\Reseller;
use App\Subscription;
use App\Http\Traits\UserTrait;
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

        switch ($this->getUserLevel()) {
            case config('app.super_admin'):
                $subscriptions = Subscription::with(['customer','products','status'])->
                orderBy('id')
                ->get();
            break;

            case config('app.admin'):
                $subscriptions = Subscription::with(['customer','products','status'])->
                orderBy('id')
                ->get();
            break;

            case config('app.provider'):

                $resellers = Reseller::where('provider_id', $user->provider->id)->pluck('id')->toArray();

                $subscriptions = Subscription::with(['customer','products','status'])->get();

                // $subscriptions = Customer::whereHas('resellers', function($query) use  ($resellers) {
                // 	$query->whereIn('id', $resellers);
                // })->with(['country', 'status' => function ($query) {
				// 	$query->where('name', 'messages.active');
				// }])
                // ->orderBy('company_name')->get();

            break;

            case config('app.reseller'):
                $reseller = $user->reseller;
                $customer = $reseller->customers->pluck('id');
                $subscriptions = Subscription::with(['customer','products','status'])->whereIn('customer_id', $customer)
                ->orderBy('id')->get();
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

    public function subscriptionsOfCustomer(Customer $customer){

        $subscriptions = $customer->subscriptions;

        return $subscriptions;
    }


}
