<?php

namespace App\Http\Middleware;

use App\Http\Traits\UserTrait;
use Closure;

class CheckReseller
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

        $reseller = $request->route('reseller');
        

        if ( $user->userLevel->name !== config('app.super_admin') && $user->userLevel->name !== config('app.super_admin') ) {

            switch ($user->userLevel->name) {
                case config('app.admin'):
                    break;
                
                case config('app.provider'):
                    $check = $reseller->provider_id === $user->provider->id;
                    
                    if (!$check)
                        return abort(403, __('errors.unauthorized_action'));

                    break;
                
                case config('app.reseller'):
                    $check = $reseller->id === $user->reseller->id;
                    if (!$check)
                        return abort(403, __('errors.unauthorized_action'));

                    break;
                
                case config('app.subreseller'):
                    $check = $reseller->id === $user->reseller->id;
                    if (!$check)
                        return abort(403, __('errors.unauthorized_action'));
                    break;
                
                default:
                    return abort(403, __('errors.unauthorized_action'));
                    break;
            }

        }

        return $next($request);
    }
}
