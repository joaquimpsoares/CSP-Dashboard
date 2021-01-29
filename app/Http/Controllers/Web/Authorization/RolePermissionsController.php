<?php

namespace App\Http\Controllers\Web\Authorization;

use App\Role;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\Role\PermissionsUpdated;
use Illuminate\Support\Facades\DB;

/**
 * Class RolePermissionsController
 * @package Vanguard\Http\Controllers
 */
class RolePermissionsController extends Controller
{


    /**
     * Update permissions for each role.
     *
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request)
    {
        $roles = $request->get('roles');

        $allRoles = DB::table('roles')->pluck('id')->all();

        foreach ($allRoles as $roleId) {
            $permissions = Arr::get($roles, $roleId, []);
            collect($permissions);
            dd(collect($roles));
            collect($roles->dd())->syncPermissions($permissions);
        }

        event(new PermissionsUpdated);

        return redirect()->route('permissions.index')
            ->withSuccess(__('Permissions saved successfully.'));
    }
}
