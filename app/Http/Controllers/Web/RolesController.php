<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Services\RoleService;
use Spatie\Permission\Models\Role;

// class RolesController extends Controller
class RolesController extends Controller
{
    protected $roleService;
    public function __construct()
    {
        $this->roleService = new RoleService();
    }
    public function index()
    {
        $roles = $this->roleService->getAllRoles();
        return view('roles.index', compact('roles'));
    }
    public function show($id)
    {
        $role = $this->roleService->getRoleById($id);
        return view('roles.show', compact('role'));
    }

    public function create()
    {
        $permission = $this->roleService->getAllPermissions();
        return view('roles.create', compact('permission'));
    }
    public function store(StoreRoleRequest $request)
    {
        $Role = $this->roleService->createRole($request->validated());
        if (!$Role) {
            return redirect()->back()->withErrors('An error occurred while creating the role.');
        }
        return redirect()->route('roles.index')->with('success', 'role created successfully');
    }
    public function edit(Role $role)
    {
        $permission = $this->roleService->getAllPermissions();
        $role_permissions = $this->roleService->getRoleById($role->id)->permissions->pluck('id')->toArray();

        // return $role_permissions;
        return view('roles.edit', compact('role', 'permission', 'role_permissions'));
    }
    public function update(UpdateRoleRequest $request, $id)
    {
        $role  = $this->roleService->updateRole($id, $request->validated());
        // return $role;
        if (!$role) {
            return redirect()->back()->withErrors('An error occurred while updating the role.');
        }
        return redirect()->route('roles.index')->with('success', 'role updated successfully');
    }

    public function destroy(Role $role)
    {
        if($role->name === 'admin'){
            return redirect()->back()->withErrors('The admin role cannot be deleted.');
        }
        $this->roleService->deleteRole($role);
        return redirect()->route('roles.index')->with('success', 'role deleted successfully');
    }
}
