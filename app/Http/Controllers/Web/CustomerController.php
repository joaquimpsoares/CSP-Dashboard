<?php

namespace App\Http\Controllers\Web;

use App\Customer;
use App\DataTables\CustomerDataTable;
use App\Http\Controllers\Controller;
use App\Reseller;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CustomerDataTable $dataTable) {
        /**
        * Begin of User Level Validation
        */

        $user = \Auth::user();
        
        switch ($user->userLevel->name) {
            case config('app.super_admin'):

                $customers = Customer::with(['country', 'status'])->orderBy('company_name')->get();
                break;
            
            case config('app.admin'):
                $customers = Customer::with(['country', 'status'])->orderBy('company_name')->get();

                break;
            
            case config('app.provider'):
                $resellers = Reseller::where('provider_id', $user->provider->id)->pluck('id')->toArray();
                $customers = Customer::whereHas('resellers', function($query) use  ($resellers) {
                    $query->whereIn('id', $resellers);
                })->with(['country', 'status'])->orderBy('company_name')->get();

                break;
            
            case config('app.reseller'):
                $reseller = $user->reseller;
                $customers = $reseller->customers;

                break;
            
            case config('app.subreseller'):
                $reseller = $user->reseller;
                $customers = $reseller->customers;
                break;
            
            default:
                return abort(403, __('errors.unauthorized_action'));
                
                break;
        }

        /**
        * End of User Level Validation
        */
        
        return view('customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() { }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) { }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer) { }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer) { }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer) { }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer) { }
}
