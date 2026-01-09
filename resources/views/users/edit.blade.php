@extends('layout.app')

@section('title', 'Edit User')

@section('header')
    <div style="padding: 20px; background-color: #f4f4f4; border-bottom: 1px solid #ddd;">
        <h1 style="margin: 0; color: #333;">Edit User: {{ $user->name }}</h1>
        <a href="{{ route('users.index') }}" style="text-decoration: none; color: #007bff; font-size: 14px;">&larr; Back to Users List</a>
    </div>
@endsection

@section('content')
    <div style="max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; font-family: sans-serif;">

        @if ($errors->any())
            <div style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 15px;">
                <ul>
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif
        
        @can('edit_user')
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold;">Name:</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required style="width: 100%; padding: 8px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold;">Email:</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required style="width: 100%; padding: 8px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold;">New Password (Optional):</label>
                <input type="password" name="password" placeholder="Leave blank to keep current password" style="width: 100%; padding: 8px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: bold;">Role:</label>
                <select name="role" required style="width: 100%; padding: 8px;">
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="text-align: right;">
                <button type="submit" style="background-color: #ffc107; color: black; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-size: 16px;">Update User</button>
            </div>
        </form>
        @endcan
    </div>
@endsection
