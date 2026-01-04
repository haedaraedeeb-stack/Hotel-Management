@extends('layout.app') {{-- أو اسم ملف اللايوت تبعك --}}

@section('title', 'Create New User')

@section('header')
    <div style="padding: 20px; background-color: #f4f4f4; border-bottom: 1px solid #ddd;">
        <h1 style="margin: 0; color: #333;">Create New User</h1>
        <a href="{{ route('users.index') }}" style="text-decoration: none; color: #007bff; font-size: 14px;">&larr; Back to Users List</a>
    </div>
@endsection

@section('content')
    <div style="max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; font-family: sans-serif;">

        {{-- عرض الأخطاء --}}
        @if ($errors->any())
            <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                <strong>Oops! Something went wrong:</strong>
                <ul style="margin: 5px 0 0 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            {{-- الاسم --}}
            <div style="margin-bottom: 15px;">
                <label for="name" style="display: block; font-weight: bold; margin-bottom: 5px;">Full Name:</label>
                <input type="text" name="name" id="name" required value="{{ old('name') }}"
                       style="width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            {{-- البريد الإلكتروني --}}
            <div style="margin-bottom: 15px;">
                <label for="email" style="display: block; font-weight: bold; margin-bottom: 5px;">Email Address:</label>
                <input type="email" name="email" id="email" required value="{{ old('email') }}"
                       style="width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            {{-- كلمة المرور --}}
            <div style="margin-bottom: 15px;">
                <label for="password" style="display: block; font-weight: bold; margin-bottom: 5px;">Password:</label>
                <input type="password" name="password" id="password" required
                       style="width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            {{-- الدور --}}
            <div style="margin-bottom: 20px;">
                <label for="role" style="display: block; font-weight: bold; margin-bottom: 5px;">Role:</label>
                <select name="role" id="role" required
                        style="width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; background-color: white;">
                    <option value="" disabled selected>Select a Role...</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                    @endforeach
                </select>
            </div>

            {{-- زر الحفظ --}}
            <div style="text-align: right;">
                <button type="submit"
                        style="background-color: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-size: 16px;">
                    Save User
                </button>
            </div>

        </form>
    </div>
@endsection
