<?php

namespace App\Http\Controllers\Web\Authorization;

use Exception;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Permission\CreatePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class PermissionsController
 * @package Vanguard\Http\Controllers
 */
class PermissionsController extends Controller
{
    /**
     * @var RoleRepository
     */
    private $roles;
    /**
     * @var PermissionRepository
     */
    private $permissions;

    /**
     * PermissionsController constructor.
     * @param RoleRepository $roles
     * @param PermissionRepository $permissions
     */
    // public function __construct(RoleRepository $roles, PermissionRepository $permissions)
    // {
    //     $this->roles = $roles;
    //     $this->permissions = $permissions;
    // }

    /**
     * Displays the page with all available permissions.
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('permission.index', [
            'roles' => Role::get(),
            'permissions' => Permission::get()
        ]);
    }

    /**
     * Displays the form for creating new permission.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('permission.add-edit', ['edit' => false]);
    }

    /**
     * Store permission to database.
     *
     * @param CreatePermissionRequest $request
     * @return mixed
     */
    public function store(Request $request){

        Permission::create([
            'name' => $request->name,
            'guard_name' => "web"
            ]
        );

        return redirect()->route('permissions.index')
            ->withSuccess(__('Permission created successfully.'));
    }

    /**
     * Displays the form for editing specific permission.
     *
     * @param Permission $permission
     * @return Factory|View
     */
    public function edit(Permission $permission)
    {
        return view('permission.add-edit', [
            'edit' => true,
            'permission' => $permission
        ]);
    }

    /**
     * Update specified permission.
     *
     * @param Permission $permission
     * @param UpdatePermissionRequest $request
     * @return mixed
     */
    public function update(Permission $permission, Request $request)
    {
        $this->permissions->update($permission->id, $request->all());

        return redirect()->route('permissions.index')
            ->withSuccess(__('Permission updated successfully.'));
    }

    /**
     * Destroy the permission if it is removable.
     *
     * @param Permission $permission
     * @return mixed
     * @throws Exception
     */
    public function destroy(Permission $permission)
    {
        if (! $permission->removable) {
            throw new NotFoundHttpException;
        }

        $this->permissions->delete($permission->id);

        return redirect()->route('permissions.index')
            ->withSuccess(__('Permission deleted successfully.'));
    }
}
