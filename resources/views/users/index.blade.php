@extends('layout.app')

@section('title', 'Users List')

@section('header')
    <div style="padding: 20px; background-color: #f4f4f4; border-bottom: 1px solid #ddd; display: flex; justify-content: space-between; align-items: center;">
        <h2 style="margin: 0; color: #333;">User Management</h2>
        <div>
            @can('create_user')
            <a href="{{ route('users.create') }}" style="background-color: #007bff; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; margin-right: 10px;">+ Add User</a>
            @endcan
            @can('view_user')
            <a href="{{ route('users.trash') }}" style="background-color: #6c757d; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px;">Trash 🗑️</a>
            @endcan
        </div>
    </div>
@endsection

@section('content')
    <div style="margin: 20px;">

        {{-- رسالة النجاح --}}
        @if(session('success'))
            <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px; border: 1px solid #c3e6cb;">
                {{ session('success') }}
            </div>
        @endif

        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; font-family: sans-serif; border-color: #ddd;">
            <thead>
                <tr style="background-color: #f8f9fa; text-align: left;">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td><b>{{ $user->name }}</b></td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @foreach($user->roles as $role)
                                <span style="background-color: #e2e3e5; padding: 3px 8px; border-radius: 10px; font-size: 12px;">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            @can('edit_user')
                            <a href="{{ route('users.edit', $user->id) }}" style="color: #ffc107; text-decoration: none; margin-right: 10px; font-weight: bold;">Edit</a>
                            @endcan
                            @can('delete_user')
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this user?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #dc3545; cursor: pointer; font-weight: bold; text-decoration: underline;">Delete</button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #999;">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
