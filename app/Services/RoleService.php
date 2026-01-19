<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * This service handles operations related to roles, including creating, updating, deleting operations and permission management.
 * Summary of RoleService
 * @package App\Services
 */
class RoleService
{
    /**
     * Retrieve all roles
     * Summary of getAllRoles
     * @return \Illuminate\Database\Eloquent\Collection<int, Role>
     */
    public function getAllRoles()
    {
        return Role::select('id', 'name')->get();
    }

    /**
     * Retrieve a role by its ID with permissions
     * Summary of getRoleById
     * @param mixed $id
     * @return Role|\Illuminate\Database\Eloquent\Collection<int, Role>
     */
    public function getRoleById($id)
    {
        try {
            $role = Role::with('permissions')->findOrFail($id);
            return $role;
        } catch (\Exception $e) {
            log('Error fetching role by ID: ' . $e->getMessage());
            throw $e; // Rethrow for now
        }
    }

    /**
     * Create a new role with permissions
     * Summary of createRole
     * @param array $data
     * @return bool|Role|\Spatie\Permission\Contracts\Role
     */
    public function createRole(array $data)
    {
        try {
            DB::beginTransaction();
            $role = Role::create(['name' => $data['name']]);
            $role->syncPermissions($data['permission']);
            DB::commit();
            return $role;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating role: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update an existing role and its permissions
     * Summary of updateRole
     * @param mixed $id
     * @param array $data
     */
    public function updateRole($id, array $data)
    {
        try {
            DB::beginTransaction();
            $role = Role::findOrFail($id);
            $role->update(['name' => $data['name'] ?? $role->name]);
            if (isset($data['permission'])) {
                $role->syncPermissions($data['permission']);
            }
            DB::commit();
            return $role;
        } catch (\Exception $e) {
            DB::rollBack();
            log::error('Error updating role: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete a role
     * Summary of deleteRole
     * @param Role $role
     * @return bool
     */
    public function deleteRole(Role $role)
    {
        try {
            $role->delete();
        } catch (\Exception $e) {
            Log::error('Error deleting role: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Retrieve all permissions
     * Summary of getAllPermissions
     * @return \Illuminate\Database\Eloquent\Collection<int, Permission>
     */
    public function getAllPermissions()
    {
        return Permission::select('id', 'name')->get();
    }
}
