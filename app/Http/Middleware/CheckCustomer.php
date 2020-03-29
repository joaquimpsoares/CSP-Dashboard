<?php

namespace App\Http\Middleware;

use App\Http\Traits\UserTrait;
use Closure;

class CheckCustomer
{

    use UserTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $this->getUser();

        $customer = $request->route('customer');
        
        switch ($user->userLevel->name) {
            case config('app.super_admin'):
                break;
            
            case config('app.admin'):
                break;
            
            case config('app.provider'):
                
                $customers = $user->provider->getMyCustomersId();
                if (!in_array($customer->id, $customers)) 
                    return abort(403, __('errors.unauthorized_action'));

                break;
            
            case config('app.reseller'):
                $resellers = $customer->getMyResellersId();
                
                if (!in_array($user->reseller->id, $resellers))
                    return abort(403, __('errors.unauthorized_action'));

                break;
            
            case config('app.subreseller'):
                $resellers = $customer->getMyResellersId();
                
                if (!in_array($user->reseller->id, $resellers))
                    return abort(403, __('errors.unauthorized_action'));

                break;
            
            default:
                return abort(403, __('errors.unauthorized_action'));
                break;
        }

    

        return $next($request);
    }
}
