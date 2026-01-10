@extends('layouts.admin')

@section('title', 'Deleted Services')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto">

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Deleted Services (Trash)
            </h2>
            <a href="{{ route('serv.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium transition">
                &larr; Back to Services
            </a>
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
                    <thead class="bg-red-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-red-800 uppercase tracking-wider">#</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-red-800 uppercase tracking-wider">Service Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-red-800 uppercase tracking-wider">Deleted At</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-red-800 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($services as $service)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>

                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-800">
                                    {{ $service->name }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-red-500 font-medium">
                                    {{ $service->deleted_at->format('M d, Y h:i A') }}
                                </td>

                              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
    @can('restore services')
        <form action="{{ route('serv.restore', $service->id) }}" method="POST" class="inline-block mr-2">
            @csrf
            @method('PATCH')
            <button type="submit" class="text-green-600 hover:text-green-900 transition flex items-center gap-1 float-right">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Restore
            </button>
        </form>
    @endcan

    @can('force delete services')
        <form action="{{ route('serv.forceDelete', $service->id) }}" method="POST" class="inline-block" onsubmit="return confirm('WARNING: This action cannot be undone!');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 hover:text-red-900 transition flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Delete
            </button>
        </form>
    @endcan
</td>
</tr>
@empty
<tr>
    <td colspan="4" class="px-6 py-10 text-center text-gray-500">
        <div class="flex flex-col items-center">
            <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            <p>Trash is empty.</p>
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