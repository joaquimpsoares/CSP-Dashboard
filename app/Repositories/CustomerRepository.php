<?php

namespace App\Repositories;

use App\Customer;
use App\Http\Traits\UserTrait;
use App\Repositories\CustomerRepositoryInterface;
use App\Reseller;

/**
 * 
 */
class CustomerRepository implements CustomerRepositoryInterface
{
	
	use UserTrait;

	public function all()
	{
        $user = $this->getUser();

		switch ($this->getUserLevel()) {
            case config('app.super_admin'):

                $customers = Customer::with(['country', 'status' => function ($query) {
					$query->where('name', 'message.active');
				}])
                ->orderBy('company_name')
                ->get()->map->format();
                break;
            
            case config('app.admin'):
                $customers = Customer::with(['country', 'status' => function ($query) {
					$query->where('name', 'message.active');
				}])
                ->orderBy('company_name')
                ->get()->map->format();

                break;
            
            case config('app.provider'):
                $resellers = Reseller::where('provider_id', $user->provider->id)->pluck('id')->toArray();
                
                $customers = Customer::whereHas('resellers', function($query) use  ($resellers) {
                	$query->whereIn('id', $resellers);
                })->with(['country', 'status' => function ($query) {
					$query->where('name', 'message.active');
				}])
                ->orderBy('company_name')->get()->map->format();

                break;
            
            case config('app.reseller'):
                $reseller = $user->reseller;
                $customers = $reseller->customers->map->format();

                break;
            
            case config('app.subreseller'):
                $reseller = $user->reseller;
                $customers = $reseller->customers->format();
                break;
            
            default:
                return abort(403, __('errors.unauthorized_action'));
                
                break;
        }

        return $customers;
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
            
            default:
                return false;
                
                break;
        }
    }

    public function customersOfReseller(Reseller $reseller){

        $customers = $reseller->customers->map->format();

        return $customers;
    }

}