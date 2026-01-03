<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::with('roles')->get();
            return view('users.index', compact('users'));
        } catch (\Exception $e) {
            return back()->withErrors('فشل في جلب المستخدمين');
        }
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(UserRequest $request)
    {
        try {
            $data = $request->validated();
            $data['password'] = bcrypt($data['password']);
            $user = User::create($data);
            $user->assignRole($data['role']);
            return redirect()->route('users.index')->with('success','تم إنشاء المستخدم');
        } catch (\Exception $e) {
            return back()->withErrors('فشل في إنشاء المستخدم');
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('users.edit', compact('user','roles'));
    }

    public function update(UserRequest $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $data = $request->validated();
            if (!empty($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            } else {
                unset($data['password']);
            }
            $user->update($data);
            $user->syncRoles([$data['role']]);
            return redirect()->route('users.index')->with('success','تم تعديل المستخدم');
        } catch (ModelNotFoundException $e) {
            return back()->withErrors('المستخدم غير موجود');
        } catch (\Exception $e) {
            return back()->withErrors('فشل في تعديل المستخدم');
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete(); // SoftDelete
            return redirect()->route('users.index')->with('success','تم حذف المستخدم');
        } catch (\Exception $e) {
            return back()->withErrors('فشل في حذف المستخدم');
        }
    }

    // صفحة المهملات
    public function trash()
    {
        $users = User::onlyTrashed()->get();
        return view('users.trash', compact('users'));
    }

    public function restore($id)
    {
        try {
            $user = User::withTrashed()->findOrFail($id);
            $user->restore();
            return redirect()->route('users.trash')->with('success','تم استرجاع المستخدم');
        } catch (\Exception $e) {
            return back()->withErrors('فشل في الاسترجاع');
        }
    }

    public function forceDelete($id)
    {
        try {
            $user = User::withTrashed()->findOrFail($id);
            $user->forceDelete();
            return redirect()->route('users.trash')->with('success','تم حذف المستخدم نهائياً');
        } catch (\Exception $e) {
            return back()->withErrors('فشل في الحذف النهائي');
        }
    }
}
