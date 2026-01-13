<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\UserService;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->middleware('role:admin|manager');
        $this->service = $service;
    }

    /**
     * Display all users.
     */
    public function index()
    {
        try {
            $users = $this->service->getAllUsers();
            return view('users.index', compact('users'));
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Show create user page.
     */
    public function create()
    {
        $roles = $this->service->getAllRoles();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a new user.
     */
    public function store(UserRequest $request)
    {
        try {
            $this->service->createUser($request->validated());
            return redirect()->route('users.index')->with('success', 'User created successfully');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Show edit user page.
     */
    public function edit($id)
    {
        try {
            $user = $this->service->getUserById($id);
            $roles = $this->service->getAllRoles();
            return view('users.edit', compact('user', 'roles'));
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Update user data.
     */
    public function update(UserRequest $request, $id)
    {
        try {
            $this->service->updateUser($id, $request->validated());
            return redirect()->route('users.index')->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Delete user.
     */
    public function destroy($id)
    {
        try {
            $this->service->deleteUser($id);
            return redirect()->route('users.index')->with('success', 'User deleted successfully');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Show trash page.
     */
    public function trash()
    {
        $users = $this->service->getTrashedUsers();
        return view('users.trash', compact('users'));
    }

    /**
     * Restore user.
     */
    public function restore($id)
    {
        try {
            $this->service->restoreUser($id);
            return redirect()->route('users.trash')->with('success', 'User restored successfully');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Permanently delete user.
     */
    public function forceDelete($id)
    {
        try {
            $this->service->forceDeleteUser($id);
            return redirect()->route('users.trash')->with('success', 'User permanently deleted');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
