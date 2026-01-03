<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RoleService
{

    public function getAllRoles()
    {
        return Role::select('id', 'name')->get();
    }

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

    public function deleteRole(Role $role)
    {
        try {
            $role->delete();
        } catch (\Exception $e) {
            Log::error('Error deleting role: ' . $e->getMessage());
            return false;
        }
    }

    public function getAllPermissions()
    {
        return Permission::select('id', 'name')->get();
    }
}
