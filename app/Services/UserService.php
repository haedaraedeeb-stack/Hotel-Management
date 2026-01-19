<?php

namespace App\Services;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * This service handles operations related to users, including CRUD operations,
 * management of soft-deleted records, and role assignments.      
 * Summary of UserService
 * @package App\Services
 */
class UserService
{
    /**
     * Get all users with roles.
     * Summary of getAllUsers
     * @throws \Exception
     * @return \Illuminate\Database\Eloquent\Collection<int, User>
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
     * Summary of getAllRoles
     * @return \Illuminate\Database\Eloquent\Collection<int, Role>
     */
    public function getAllRoles()
    {
        return Role::all();
    }

    /**
     * Create a new user.
     * Summary of createUser
     * @param array $data
     * @throws \Exception
     * @return User
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
     * Summary of getUserById
     * @param mixed $id
     * @throws \Exception
     * @return User|\Illuminate\Database\Eloquent\Collection<int, User>
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
     * Summary of updateUser
     * @param mixed $id
     * @param array $data
     * @throws \Exception
     * @return User|\Illuminate\Database\Eloquent\Collection<int, User>
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
     * Summary of deleteUser
     * @param mixed $id
     * @throws \Exception
     * @return void
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
     * Summary of getTrashedUsers
     * @return \Illuminate\Database\Eloquent\Collection<int, User>
     */
    public function getTrashedUsers()
    {
        return User::onlyTrashed()->get();
    }

    /**
     * Restore a soft-deleted user.
     * Summary of restoreUser
     * @param mixed $id
     * @throws \Exception
     * @return void
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
     * Summary of forceDeleteUser
     * @param mixed $id
     * @throws \Exception
     * @return void
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
