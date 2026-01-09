@extends('layouts.admin')

@section('title', 'Edit Role')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto">

        {{-- Header & Back --}}
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Edit Role: {{ $role->name }}</h2>
            <a href="{{ route('roles.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium transition flex items-center">
                &larr; Back to Roles
            </a>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-8">

                {{-- Errors --}}
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded text-red-700 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('roles.update', $role->id) }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')

                    {{-- Role Name --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Role Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}" required
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    {{-- Permissions Section --}}
                    <div>
                        <div class="flex justify-between items-center mb-4 border-b border-gray-100 pb-2">
                            <label class="block text-lg font-semibold text-gray-800">Manage Permissions</label>

                            {{-- Select All Checkbox --}}
                            <label class="inline-flex items-center cursor-pointer text-sm text-gray-600 hover:text-indigo-600">
                                <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 h-4 w-4 mr-2">
                                Select All Permissions
                            </label>
                        </div>

                        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                            {{-- Permissions Grid --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach($permission as $perm)
                                    <label class="inline-flex items-center cursor-pointer group p-2 hover:bg-white rounded-lg transition border border-transparent hover:border-gray-200">
                                        <input type="checkbox" name="permission[]" value="{{ $perm->name }}"
                                            class="permission-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 h-4 w-4 mt-0.5"
                                            {{ in_array($perm->id, $role_permissions) ? 'checked' : '' }}>

                                        <span class="ml-2 text-sm text-gray-700 group-hover:text-indigo-700 break-all select-none">
                                            {{ $perm->name }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center justify-end pt-6 border-t border-gray-100 gap-3">
                        <a href="{{ route('roles.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-md transition transform hover:-translate-y-0.5">
                            Update Role
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

{{-- Script for Select All --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.permission-checkbox');

        // Initial check: If all checkboxes are checked, check "Select All"
        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
        selectAll.checked = allChecked;

        // Toggle all
        selectAll.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        // Update "Select All" based on individual clicks
        checkboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                selectAll.checked = allChecked;
            });
        });
    });
</script>
@endsection
