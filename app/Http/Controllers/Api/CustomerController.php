<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Country;
use App\Customer;
use App\Reseller;
use Illuminate\Http\Request;
use App\Http\Traits\UserTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\ApiController;


class CustomerController extends ApiController
{
    use UserTrait;



    public function index()
    {
        $customers = Customer::get();
        // $user = $this->getUser();

        // switch ($this->getUserLevel()) {
        //     case config('app.super_admin'):

        //         $customers = Customer::with(['country', 'status', 'subscriptions'])
        //         ->orderBy('company_name')
        //         ->get();

        //     break;

        //     case config('app.admin'):
        //         $customers = Customer::with(['country', 'status'])
        //         ->orderBy('company_name')
        //         ->get();

        //     break;

        //     case config('app.provider'):
        //         $resellers = Reseller::where('provider_id', $user->provider->id)->pluck('id')->toArray();

        //         $customers = Customer::whereHas('resellers', function($query) use  ($resellers) {
        //             $query->whereIn('id', $resellers);
        //         })->with(['country', 'status', 'subscriptions'])
        //         ->orderBy('company_name');

        //     break;

        //     case config('app.reseller'):
        //         $reseller = $user->reseller;
        //         $customers = $reseller->customers;
        //     break;

        //     case config('app.subreseller'):
        //         $reseller = $user->reseller;
        //         $customers = $reseller->customers;
        //     break;

        //     default:
        //     return abort(403, __('errors.unauthorized_action'));

        // break;
        //     }
    return $customers;


    }

    public function show($id)
    {
        return Customer::find($id)->format();
    }

    public function store(Request $request)
    {

        // return $request->only([
        //     'email', 'password', 'username', 'first_name', 'last_name',
        //     'phone', 'address', 'country_id', 'birthday', 'role_id'
        // ]);
        // return $request->all();
            // return $request->all();
            // return $country_id;
            // $request->address_1,
            // $request->address_2,
            // $country_id,
            // $request->city,
            // $request->state,
            // $request->nif,
            // $request->postal_code);
            $user = $this->getUser();

            $country_id = Country::where('name', $request->country)->first();

            // return $country_id->id;

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
            $newCustomer->resellers()->attach($request->reseller_id);


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
