<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Country;
use App\Customer;
use App\Subscription;
use Illuminate\Http\Request;
use App\Http\Traits\UserTrait;
use App\Http\Traits\ApiResponser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\ApiController;

class CustomerController extends ApiController
{
    use UserTrait, ApiResponser;

    public function index() {
        if (Customer::get() == null) {
            return $this->error('Customer not found', 401);
        }
        return $this->success([
            'message' => 'All customers',
            'total' => Customer::get()->count(),
            'customers' => Customer::all(),
        ]);
    }

    public function show(Customer $customer) {
        if ($customer == null) {
            return $this->error('Customer not found', 401);
        }

        return $this->success([
            'message' => 'Customer',
            'total' => Customer::where('id',$customer->id)->count(),
            'customer' => $customer,
        ]);
    }
    
    public function customerSubscription(Customer $customer) {
        if (Customer::find($customer) == null) {
            return $this->error('Customer not found', 401);
        }

        return $this->success([
            'message' => 'Customer Subscriptions',
            'total' => Customer::find($customer->id)->first()->subscriptions->count(),
            'subscriptions' => $customer->subscriptions,
        ]);
    }

    public function customerSubscriptionID(Customer $customer, $subscriptionid) {
        if (Customer::find($customer->id) == null) {
            return $this->error('Customer not found', 401);
        }elseif(Customer::find($customer->id)->subscriptions->find($subscriptionid) == null){
            return $this->error('Subscription not found', 401);
        }
        return $this->success([
            'message' => 'Customer Subscriptions',
            'total' => Customer::find($customer->id)->subscriptions->where('id', $subscriptionid)->count(),
            'subscription' => $customer->subscriptions->where('id',$subscriptionid),
        ]);
        return ;
    }

    
    public function store(Request $request){

    $user = $this->getUser();

    $country_id = Country::where('name', $request->country)->first();
    try {
        DB::beginTransaction();
        $newCustomer =  Customer::create([
            'company_name'  => $request->company_name,
            'address_1'     => $request->address_1,
            'address_2'     => $request->address_2,
            'country_id'    => $country_id->id,
            'city'          => $request->city,
            'state'         => $request->state,
            'nif'           => $request->nif,
            'postal_code'   => $request->postal_code,
            'status_id'     => 1
            ]);

            $newCustomer->save();
            $newCustomer->resellers()->attach($user->reseller->id);


        $user = User::create ([
            'email'             => $request->email,
            'name'              => $request->name,
            'last_name'         => $request->last_name,
            'address'           => $request->address,
            'phone'             => $request->phone,
            'country_id'        => $country_id->id,
            'socialite_id'      => $request->socialite_id,
            'password'          => Hash::make($request->password),
            'user_level_id'     => 6,
            'notify'            => $request->sendInvitation ?? false,
            'status_id'         => 1,
            'customer_id'       => $newCustomer->id,
            ]);

            $user->assignRole(config('app.customer'));
            $user->save();

            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
            if ($e->errorInfo[1] == 1062) {
                $e = "errors.user_already_exists";
            } else {
                $this->messageText = $e->getMessage();
                session()->flash('danger', $this->messageText );
            }

        }
        return  response()->json([$newCustomer, $user], 201);


    }

    public function update(Request $request, $id)
    {
        $Customer = Customer::findOrFail($id);
        $Customer->update($request->all());

        return $Customer;
    }

    public function delete(Request $request, $id)
    {
        $Customer = Customer::findOrFail($id);
        $Customer->delete();

        return 204;
    }
}
