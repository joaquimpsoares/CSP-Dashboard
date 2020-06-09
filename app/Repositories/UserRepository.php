<?php

namespace App\Repositories;

use App\Http\Traits\UserTrait;
use App\Repositories\UserRepositoryInterface;
use App\Reseller;
use App\User;
use App\UserLevel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

    public function create($user = null, $type = null, $model = null) {

        if (!empty($user) && !empty($type) && !empty($model)) {
            $user = [
                'email' => $user['email'],
                'password' => Hash::make(Str::random(20)),
                'status_id' => $user['status_id'],
                'notify' => $user['sendInvitation'] ?? false,
            ];

            switch ($type) {
                case 'provider':
                    $providerLevel = UserLevel::where('name', config('app.provider'))->first();
                    $user['user_level_id'] = $providerLevel->id;

                    $user['provider_id'] = $model->id;

                    $newUser = User::create($user);
                    
                    $newUser->assignRole(config('app.provider'));

                    break;

                case 'reseller':
                    $resellerLevel = UserLevel::where('name', config('app.reseller'))->first();
                    $user['user_level_id'] = $resellerLevel->id;

                    $user['reseller_id'] = $model->id;

                    $newUser = User::create($user);
                    
                    $newUser->assignRole(config('app.reseller'));

                    break;

                case 'customer':
                    $customerLevel = UserLevel::where('name', config('app.customer'))->first();
                    $user['user_level_id'] = $customerLevel->id;

                    $user['customer_id'] = $model->id;

                    $newUser = User::create($user);
                    
                    $newUser->assignRole(config('app.customer'));

                    break;
                
                default:
                    # code...
                    break;
            }
            
        }
    }

    

}