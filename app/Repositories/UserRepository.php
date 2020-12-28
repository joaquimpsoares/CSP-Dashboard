<?php

namespace App\Repositories;

use App\Role;
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


        $role = Role::find($user['role_id']);
        $type= Role::find($user['role_id'])->name;

        // dd($type);

        if (!empty($user) && !empty($type) && !empty($model)) {

            $user = [
                'email' => $user['email'],
                'name' => $user['name'],
                'last_name' => $user['last_name'],
                'address' => $user['address'],
                // 'city' => $user['city'],
                // 'postal_code' => $user['postal_code'],
                'phone' => $user['phone'],
                'country_id' => $user['country_id'],
                'socialite_id' => $user['socialite_id'],
                'password' => Hash::make($user['password']),
                'user_level_id' => $user['role_id'],
                'notify' => $user['sendInvitation'] ?? false,
                'status_id' => $user['status'],
            ];
            // dd($type);

            switch ($type) {
                case 'Super Admin':

                    $newUser = User::create($user);

                    $newUser->assignRole($role->name);

                    break;
                case 'Provider':

                    $user['provider_id'] = $model->id;

                    $newUser = User::create($user);

                    $newUser->assignRole($role->name);

                    // dd($newUser);

                    break;

                case 'reseller':
                    dd('here');

                    $resellerLevel = UserLevel::where('name', config('app.reseller'))->first();
                    $user['user_level_id'] = $resellerLevel->id;

                    $user['reseller_id'] = $model->id;

                    $newUser = User::create($user);

                    $newUser->assignRole($role->name);

                    break;

                case 'customer':
                    dd('here');

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
