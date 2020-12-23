<?php

namespace App\Repositories;

use App\User;
use App\Provider;
use App\Reseller;
use App\UserLevel;
use Illuminate\Support\Str;
use App\Http\Traits\UserTrait;
use Illuminate\Support\Facades\Hash;
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
            $users = User::with(['provider','status','customer','reseller','country' => function ($query) {
                $query->where('name', 'messages.active');
            }])
            ->orderBy('username')
            ->get();
            break;

            case config('app.admin'):
            $users = User::with(['provider','status','customer','reseller','country' => function ($query) {
                $query->where('name', 'messages.active');
            }])
            ->orderBy('username')
            ->get();
            break;

            case config('app.provider'):

            $provider = $user->provider;
            $users = $provider->users()->with('status')->get();

            break;

            case config('app.reseller'):
            $reseller = $user->reseller;
            $users = $reseller->users()->with('status')->get();
            break;

            case config('app.subreseller'):
            $reseller = $user->reseller;
            $users = $reseller->users()->with('status')->get();
            break;

            default:
            return abort(403, __('errors.unauthorized_action'));

            break;
        }

        return $users;
    }

    public function create($user = null, $type = null, $model = null) {

        // dd($type);
        if (!empty($user) && !empty($type) && !empty($model)) {

            $user = [
                'email' => $user['email'],
                'password' => Hash::make(Str::random(20)),
                'status_id' => $user['status_id'],
                'notify' => $user['sendInvitation'] ?? false,
            ];

            switch ($type) {
                case 'Super Admin':

                    $user['user_level_id'] = 1;

                    $newUser = User::create($user);

                    $newUser->assignRole(config('app.super_admin'));

                    break;
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

            return $newUser;

        }
    }



}
