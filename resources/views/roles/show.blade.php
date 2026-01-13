@extends('layouts.admin')

@section('title', 'Role Details')

@section('content')
<div class="py-6">
    <div class=" mx-auto">

        {{-- Header & Back --}}
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Role Details</h2>
            <div class="flex gap-3">
                <a href="{{ route('roles.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium transition flex items-center">
                    &larr; Back to Roles
                </a>
                <a href="{{ route('roles.edit', $role->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                    Edit Role
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- 1. Main Info --}}
            <div class="md:col-span-1 bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden h-fit">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">Information</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <p class="text-xs text-gray-500 font-bold uppercase">Role Name</p>
                        <p class="text-lg font-bold text-gray-900 mt-1">{{ ucfirst($role->name) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-bold uppercase">Role ID</p>
                        <p class="text-sm font-mono text-gray-700 mt-1">#{{ $role->id }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-bold uppercase">Created At</p>
                        <p class="text-sm text-gray-700 mt-1">{{ $role->created_at->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-bold uppercase">Total Permissions</p>
                        <span class="inline-flex items-center mt-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $role->permissions->count() }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- 2. Permissions List --}}
            <div class="md:col-span-2 bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800">Assigned Permissions</h3>
                    <span class="text-xs text-gray-500 bg-white border px-2 py-1 rounded">{{ $role->permissions->count() }} items</span>
                </div>

                <div class="p-6">
                    @if($role->permissions->isNotEmpty())
                        <div class="flex flex-wrap gap-2">
                            @foreach($role->permissions as $perm)
                                @php
                                    // لون بسيط جداً حسب نوع الصلاحية
                                    $color = 'bg-gray-100 text-gray-700 border-gray-200';
                                    if (Str::contains($perm->name, 'create')) $color = 'bg-green-50 text-green-700 border-green-200';
                                    if (Str::contains($perm->name, 'delete')) $color = 'bg-red-50 text-red-700 border-red-200';
                                    if (Str::contains($perm->name, 'edit'))   $color = 'bg-yellow-50 text-yellow-700 border-yellow-200';
                                @endphp
                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium border {{ $color }}">
                                    {{ $perm->name }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <p>No permissions assigned to this role yet.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        {{-- Delete Action --}}
        <div class="mt-8 flex justify-end">
            <form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this role?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium transition underline">
                    Delete Role Permanently
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
