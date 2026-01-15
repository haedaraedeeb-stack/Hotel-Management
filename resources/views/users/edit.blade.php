@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
    <div class="py-6">
        <div class=" mx-auto">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Edit User: {{ $user->name }}</h2>
                <a href="{{ route('users.index') }}"
                    class="text-indigo-600 hover:text-indigo-800 text-sm font-medium transition">
                    &larr; Back to Users
                </a>
            </div>

            {{-- Form Card --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-8">
                    @can('edit_user')
                        <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PUT')

                            {{-- Name --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    New Password <span class="text-gray-400 font-normal">(Optional)</span>
                                </label>
                                <input type="password" name="password" placeholder="Leave blank to keep current password"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Role --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                                <select name="role" required
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-white">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Actions --}}
                            <div class="flex items-center justify-end pt-4 border-t border-gray-100">
                                <a href="{{ route('users.index') }}"
                                    class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 mr-3 transition">
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-md transition transform hover:-translate-y-0.5">
                                    Update Changes
                                </button>
                            </div>

                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
