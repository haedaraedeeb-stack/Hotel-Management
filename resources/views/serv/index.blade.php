@extends('layouts.admin')

@section('title', 'Services List')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto">

        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Services Management</h2>
                <p class="text-sm text-gray-500 mt-1">Manage hotel amenities and link them to room types.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('serv.trash') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Trash
                </a>
                <a href="{{ route('serv.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition shadow-md">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Add Service
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded shadow-sm flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-400 hover:text-green-600">&times;</button>
            </div>
        @endif

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Linked To</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($services as $service)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-bold text-gray-800">{{ $service->name }}</span>
                                </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 max-w-xs truncate" title="{{ $service->description }}">
    {{ $service->description ?? '-' }}
</td>

<td class="px-6 py-4 whitespace-nowrap">
    <div class="flex flex-wrap gap-1">
        @forelse($service->roomTypes as $roomType)
            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                {{ $roomType->type }}
            </span>
        @empty
            <span class="text-xs text-gray-400 italic">Not linked</span>
        @endforelse
    </div>
</td>

<td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
    @can('edit services')
        <a href="{{ route('serv.edit', $service->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-4 transition">Edit</a>
    @endcan

    @can('delete services')
        <form action="{{ route('serv.destroy', $service->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to move this service to trash?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 hover:text-red-900 transition">Delete</button>
        </form>
    @endcan
</td>
</tr>
@empty
<tr>
    <td colspan="5" class="px-6 py-10 text-center text-gray-500">
        <div class="flex flex-col items-center">
            <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            <p>No services found. Start by adding one.</p>
        </div>
    </td>
</tr>
@endforelse
</tbody>
</table>
</div>
</div>
</div>
</div>
@endsection