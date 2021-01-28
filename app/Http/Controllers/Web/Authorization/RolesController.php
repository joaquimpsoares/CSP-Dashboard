<?php

namespace App\Http\Controllers\Web\Authorization;

use Cache;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\CreateRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Permission;
use App\Repositories\User\UserRepository;
use App\Role;


/**
 * Class RolesController
 * @package Vanguard\Http\Controllers
 */
class RolesController extends Controller
{

    /**
     * Display page with all available roles.
     *
     * @return Factory|View
     */
    public function index()
    {

        $permissions = Permission::get();
        return view('role.index', ['roles' => Role::withCount('users')->get()],['permissions' => $permissions]);
    }

    /**
     * Display form for creating new role.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('role.add-edit', ['edit' => false]);
    }

    /**
     * Store newly created role to database.
     *
     * @param CreateRoleRequest $request
     * @return mixed
     */
    public function store(CreateRoleRequest $request)
    {

        $this->roles->create($request->all());

        return redirect()->route('roles.index')
            ->withSuccess(__('Role created successfully.'));
    }

    /**
     * Display for for editing specified role.
     *
     * @param Role $role
     * @return Factory|View
     */
    public function edit(Role $role)
    {
        return view('role.add-edit', [
            'role' => $role,
            'edit' => true
        ]);
    }

    /**
     * Update specified role with provided data.
     *
     * @param Role $role
     * @param UpdateRoleRequest $request
     * @return mixed
     */
    public function update(Role $role, UpdateRoleRequest $request)
    {
        $this->roles->update($role->id, $request->all());

        return redirect()->route('roles.index')
            ->withSuccess(__('Role updated successfully.'));
    }

    /**
     * Remove specified role from system.
     *
     * @param Role $role
     * @param UserRepository $userRepository
     * @return mixed
     */
    public function destroy(Role $role, UserRepository $userRepository)
    {
        if (! $role->removable) {
            throw new NotFoundHttpException;
        }

        $userRole = $this->roles->findByName('User');

        $userRepository->switchRolesForUsers($role->id, $userRole->id);

        $this->roles->delete($role->id);

        Cache::flush();

        return redirect()->route('roles.index')
            ->withSuccess(__('Role deleted successfully.'));
    }
}
