<?php

namespace App\Services;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserService
{
    /**
     * Get all users with roles.
     */
    public function getAllUsers()
    {
        try {
            return User::with('roles')->get();
        } catch (\Exception $e) {
            throw new \Exception("Failed to get users");
        }
    }

    /**
     * Get all roles.
     */
    public function getAllRoles()
    {
        return Role::all();
    }

    /**
     * Create a new user.
     */
    public function createUser(array $data)
    {
        try {
            $data['password'] = bcrypt($data['password']);
            $user = User::create($data);
            $user->assignRole($data['role']);
            return $user;
        } catch (\Exception $e) {
            throw new \Exception("Failed to create user");
        }
    }

    /**
     * Get user by ID.
     */
    public function getUserById($id)
    {
        try {
            return User::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new \Exception("User not found");
        }
    }

    /**
     * Update user data.
     */
    public function updateUser($id, array $data)
    {
        try {
            $user = User::findOrFail($id);

            if (!empty($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            } else {
                unset($data['password']);
            }

            $user->update($data);
            $user->syncRoles([$data['role']]);

            return $user;

        } catch (ModelNotFoundException $e) {
            throw new \Exception("User not found");
        } catch (\Exception $e) {
            throw new \Exception("Failed to update user");
        }
    }

    /**
     * Soft delete a user.
     */
    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
        } catch (\Exception $e) {
            throw new \Exception("Failed to delete user");
        }
    }

    /**
     * Get all soft-deleted users.
     */
    public function getTrashedUsers()
    {
        return User::onlyTrashed()->get();
    }

    /**
     * Restore a soft-deleted user.
     */
    public function restoreUser($id)
    {
        try {
            $user = User::withTrashed()->findOrFail($id);
            $user->restore();
        } catch (\Exception $e) {
            throw new \Exception("Failed to restore user");
        }
    }

    /**
     * Permanently delete a user.
     */
    public function forceDeleteUser($id)
    {
        try {
            $user = User::withTrashed()->findOrFail($id);
            $user->forceDelete();
        } catch (\Exception $e) {
            throw new \Exception("Failed to permanently delete user");
        }
    }
}
