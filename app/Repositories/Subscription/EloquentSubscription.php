<?php

namespace App\Repositories\Subscription;

use Carbon\Carbon;
use DB;
use Illuminate\Database\SQLiteConnection;
use App\Subscription;
use App\Support\Enum\SubscriptionStatus;


class EloquentSubscription implements SubscriptionRepository
{
    // protected $reseller;

    // public function __construct(Reseller $reseller)
    // {
    //     $this->reseller = $reseller;
    // }

    public function all()
    {
        $this->subscription->all();
    }

    public function countsubscriptions()
    {
        return Subscription::count();
    }

    public function getOwner($id){

       return DB::table('subscriptions')->where('customer_id', $id)->get();
    }

    // public function status($id)
    // {
    //     $subscription = $this->find($id);

    //     $subscription->status = $subscription->isActive() ? SubscriptionStatus::INACTIVE : SubscriptionStatus::ACTIVE;

    //     $subscription->update();
    //     return $subscription;
    // }

    public function create(array $data)
    {
        return Reseller::create($data);
    }

    public function update($id, array $data)
    {

        $reseller = $this->find($id);

        $reseller->update($data);

        return $reseller;
    }

    public function delete($id)
    {
        return $this->reseller->destroy($id);
    }

    public function find($id)
    {
        // if (null == $reseller = $this->reseller->find($id)) {
        //     throw new ModelNotFoundException("Reseller not found");
        // }
        // return $reseller;
        return Reseller::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function paginate($perPage, $search = null, $status = null, $customer = null, $branch_id = null)
    {
        $query = Subscription::query();

        //$query->where('role_id', $status);

        if ($status) {
            $query->where('status', $status);
        }

        if ($branch_id) {
            $query->where('branch_id', $branch_id);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('company_name', "like", "%{$search}%");
            });
        }

        if ($customer) {

            $customer_subscription = DB::table('subscriptions')->where('customer_id', $customer)->get();
            if($customer_subscription->first()){
                $query->where('id', $customer_subscription->first()->customer_id);
            }
        }

        $result = $query->orderBy('id', 'desc')
            ->paginate($perPage);

        if ($search) {
            $result->appends(['search' => $search]);
        }

        // if ($status) {
        //     $result->appends(['status' => $status]);
        // }

        return $result;
    }

}
