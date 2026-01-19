<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\UserService;

/**
 * This controller manages user-related web requests,
 * including listing, creating, updating, showing, deleting, and restoring users.
 * Class UserController
 * @package App\Http\Controllers\Web
 */
class UserController extends Controller
{
    protected $service;

    /**
     * UserController constructor.
     * Summary of __construct
     * @param UserService $service
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
        $this->middleware('permission:list_user', ['only' => ['index']]);
        $this->middleware('permission:create_user', ['only' => ['create', 'store']]);
        $this->middleware('permission:view_user', ['only' => ['show']]);
        $this->middleware('permission:edit_user', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_user', ['only' => ['destroy']]);
        $this->middleware('permission:soft_delete', ['only' => ['forceDelete','restore','trash']]);
    }

    /**
     * Display a listing of users.
     * Summary of index
     * @return \Illuminate\View\View
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
     * Show the form for creating a new user.
     * Summary of create
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $roles = $this->service->getAllRoles();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     * Summary of store
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
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
     * Display the specified user.
     * Summary of show
     * @param int $id
     * @return \Illuminate\View\View
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
     * Update the specified user in storage.
     * Summary of update
     * @param UserRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
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
     * Remove the specified user from storage.
     * Summary of destroy
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
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
     * Display a listing of trashed users.
     * Summary of trash
     * @return \Illuminate\View\View
     */
    public function trash()
    {
        $users = $this->service->getTrashedUsers();
        return view('users.trash', compact('users'));
    }

    /**
     * Restore the specified trashed user.
     * Summary of restore
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
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
     * Permanently delete the specified trashed user.
     * Summary of forceDelete
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
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
