<?php

namespace App\Repositories;

use App\User;
use App\Reseller;
use App\Http\Traits\UserTrait;
use App\Repositories\UserRepositoryInterface;

/**
 * 
 */
class UserRepository implements UserRepositoryInterface
{
	
	use UserTrait;

	public function all()
	{
        $user = $this->getUser();


		switch ($this->getUserLevel()) {
            case config('app.super_admin'):
                $users = User::with(['country' => function ($query) {
                    $query->where('name', 'message.active');
				}])
                ->orderBy('username')
                ->get();
            break;
            
            case config('app.admin'):
                $users = User::with(['country' => function ($query) {
                    $query->where('name', 'message.active');
				}])
                ->orderBy('username')
                ->get();
            break;
            
            case config('app.provider'):
                $resellers = Reseller::where('provider_id', $user->provider->id)->pluck('id')->toArray();
                
                $users = User::whereHas('resellers', function($query) use  ($resellers) {
                    $query->whereIn('id', $resellers);
                })->with(['country' => function ($query) {
                    $query->where('name', 'message.active');
				}])
                ->orderBy('username')->toSql();

                dd($users);
            break;
            
            case config('app.reseller'):
                $reseller = $user->reseller;
                $users = $reseller->users()->get();
                break;
            
            case config('app.subreseller'):
                $reseller = $user->reseller;
                $users = $reseller->users()->get();
                break;
            
            default:
                return abort(403, __('errors.unauthorized_action'));
                
                break;
        }

        return $users;
    }

    

}