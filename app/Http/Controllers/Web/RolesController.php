<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Services\RoleService;
use Spatie\Permission\Models\Role;


/**
 * This controller manages role-related web requests,
 * including listing, creating, updating, showing, and deleting roles.
 * Class RolesController
 * @package App\Http\Controllers\Web
 */
class RolesController extends Controller
{
    protected $roleService;

    /**
     * RolesController constructor.
     * Summary of __construct
     * @return void
     */
    public function __construct()
    {
        $this->roleService = new RoleService();
        $this->middleware('permission:role-list', ['only' => ['index']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-show', ['only' => ['show']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of roles.
     * Summary of index
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $roles = $this->roleService->getAllRoles();
        return view('roles.index', compact('roles'));
    }

    /**
     * Display the specified role.
     * Summary of show
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $role = $this->roleService->getRoleById($id);
        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for creating a new role.
     * Summary of create
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $permission = $this->roleService->getAllPermissions();
        return view('roles.create', compact('permission'));
    }
    
    /**
     * Store a newly created role in storage.
     * Summary of store
     * @param StoreRoleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRoleRequest $request)
    {
        $Role = $this->roleService->createRole($request->validated());
        if (!$Role) {
            return redirect()->back()->withErrors('An error occurred while creating the role.');
        }
        return redirect()->route('roles.index')->with('success', 'role created successfully');
    }

    /**
     * Show the form for editing the specified role.
     * Summary of edit
     * @param Role $role
     * @return \Illuminate\View\View
     */
    public function edit(Role $role)
    {
        $permission = $this->roleService->getAllPermissions();
        $role_permissions = $this->roleService->getRoleById($role->id)->permissions->pluck('id')->toArray();

        // return $role_permissions;
        return view('roles.edit', compact('role', 'permission', 'role_permissions'));
    }

    /**
     * Update the specified role in storage.
     * Summary of update
     * @param UpdateRoleRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRoleRequest $request, $id)
    {
        $role  = $this->roleService->updateRole($id, $request->validated());
        // return $role;
        if (!$role) {
            return redirect()->back()->withErrors('An error occurred while updating the role.');
        }
        return redirect()->route('roles.index')->with('success', 'role updated successfully');
    }

    /**
     * Remove the specified role from storage.
     * Summary of destroy
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Role $role)
    {
        if($role->name === 'admin'){
            return redirect()->back()->withErrors('The admin role cannot be deleted.');
        }
        $this->roleService->deleteRole($role);
        return redirect()->route('roles.index')->with('success', 'role deleted successfully');
    }
}
