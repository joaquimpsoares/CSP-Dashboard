<?php

namespace App\Repositories;

use App\Customer;
use App\Http\Traits\UserTrait;
use App\Repositories\CustomerRepositoryInterface;
use Illuminate\Http\Request;
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
                
                $customers = Customer::with(['country', 'status'])
                ->orderBy('company_name')
                ->get()->map->format();

            break;
            
            case config('app.admin'):
                $customers = Customer::with(['country', 'status'])
                ->orderBy('company_name')
                ->get()->map->format();
                
            break;
            
            case config('app.provider'):
                $resellers = Reseller::where('provider_id', $user->provider->id)->pluck('id')->toArray();
                
                $customers = Customer::whereHas('resellers', function($query) use  ($resellers) {
                    $query->whereIn('id', $resellers);
                })->with(['country'])
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
    public function create($validate)
    {
        $newCustomer =  Customer::create([
            'company_name' => $validate['company_name'],
            'nif' => $validate['nif'],
            'country_id' => $validate['country_id'],
            'address_1' => $validate['address_1'],
            'address_2' => $validate['address_2'],
            'city' => $validate['city'],
            'state' => $validate['state'],
            'postal_code' => $validate['postal_code'],
            'status_id' => $validate['status_id']
            ]);
            
            return $newCustomer;
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
            'status_id' => $validate['status_id']
        ]);
        return $updateCustomer;

        // $updateCustomer =  Customer::store([
        //     'company_name' => $validate['company_name'],
        //     'nif' => $validate['nif'],
        //     'country_id' => $validate['country_id'],
        //     'address_1' => $validate['address_1'],
        //     'address_2' => $validate['address_2'],
        //     'city' => $validate['city'],
        //     'state' => $validate['state'],
        //     'postal_code' => $validate['postal_code'],
        //     'status_id' => $validate['status_id']
        //     ]);
            
            
            // return $updateCustomer;
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