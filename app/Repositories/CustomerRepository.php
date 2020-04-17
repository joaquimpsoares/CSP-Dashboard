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
                $customers = $reseller->customers->format();

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
}