<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use App\Reseller;
use App\Subscription;
use Illuminate\Http\Request;
use App\Http\Traits\UserTrait;
use App\Http\Traits\ApiResponser;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\ResellerRepositoryInterface;
use App\Repositories\SubscriptionRepositoryInterface;

class SubscriptionsController extends ApiController
{
    use UserTrait, ApiResponser;

    public function index()
    {
        if (Subscription::get() == null) {
            return $this->error('Subscription not found', 401);
        }
        return $this->success([
            'message' => 'All Subscriptions',
            'total' => Subscription::get()->count(),
            'subscriptions' => Subscription::get(),
        ]);
    }

    public function show($id)
    {
        if (Subscription::find($id) == null) {
            return $this->error('Subscription not found', 401);
        }
        return $this->success([
            'message' => 'Subscription',
            'total' => Subscription::where('id',$id)->count(),
            'subscriptions' => Subscription::find($id)->first(),
        ]);
    }
    public function update(Request $request, Subscription $subscription)
    {

        dd( $request->all());
        // $subscription = Subscription::find($id)->first();


        // return $this->success([
        //     'message' => 'Subscription',
        //     'total' => Subscription::where('id',$id)->count(),
        //     'subscriptions' => $subscription,
        // ]);
    }
}
