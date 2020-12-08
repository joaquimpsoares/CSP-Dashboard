<?php

namespace App\Http\Middleware;

use App\Http\Traits\UserTrait;
use Closure;

class CheckProvider
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
        $userLevel = $this->getUserLevel();
        $provider = $request->route('provider');

        if ( $user->userLevel->name !== config('app.super_admin') && $user->userLevel->name !== config('app.super_admin') ) {

            switch ($userLevel) {
                case config('app.admin'):
                    break;
                
                case config('app.provider'):

                    $check = $provider->id === $user->provider->id;
                    
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
