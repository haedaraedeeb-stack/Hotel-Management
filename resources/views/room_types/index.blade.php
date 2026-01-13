@extends('layouts.admin')

@section('title', 'Room Types')

@section('content')
    <div class="py-6">
        <div class="mx-auto sm:px-6 lg:px-8">

            {{-- Header Section --}}
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Room Types List</h2>
                    <p class="text-sm text-gray-500 mt-1">Manage your hotel room categories and pricing.</p>
                </div>

                @can('create room_types')
                    <a href="{{ route('room_types.create') }}"
                        class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white font-medium text-sm rounded-lg shadow-md hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 transition transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create New Type
                    </a>
                @endcan
            </div>


            {{-- Flash Message --}}
            @if (session('success'))
                <div
                    class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-md shadow-sm flex justify-between items-center">
                    <div class="flex">
                        <svg class="h-6 w-6 text-green-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                    <button onclick="this.parentElement.remove()"
                        class="text-green-500 hover:text-green-700">&times;</button>
                </div>
            @endif

            {{-- Cards Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach ($roomTypes as $type)
                    <div
                        class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition duration-300 flex flex-col h-full">

                        {{-- Image Area --}}
                        <div class="h-48 w-full bg-gray-100 relative group overflow-hidden">
                            @if ($type->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $type->images->first()->path) }}" alt="{{ $type->type }}"
                                    class="w-full h-full object-cover transition duration-500 group-hover:scale-105">

                                {{-- Image Count Badge --}}
                                @if ($type->images->count() > 1)
                                    <span
                                        class="absolute top-3 right-3 bg-black/50 text-white text-xs px-2 py-1 rounded-full backdrop-blur-sm flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        +{{ $type->images->count() - 1 }}
                                    </span>
                                @endif
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400 bg-gray-50">
                                    <span class="text-sm font-medium">No Image</span>
                                </div>
                            @endif
                        </div>

                        {{-- Card Body --}}
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="text-xl font-bold text-gray-900">{{ $type->type }}</h3>
                                <span
                                    class="bg-green-100 text-green-800 text-sm font-bold px-2.5 py-0.5 rounded border border-green-200">
                                    ${{ number_format($type->base_price, 0) }}
                                </span>
                            </div>

                            <p class="text-gray-600 text-sm mb-4 line-clamp-2 flex-1">
                                {{ $type->description }}
                            </p>

                            {{-- Services Tags --}}
                            @if ($type->services->isNotEmpty())
                                <div class="mb-4">
                                    <span
                                        class="text-xs font-semibold text-gray-500 uppercase tracking-wider block mb-2">Includes:</span>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($type->services->take(3) as $service)
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                                                {{ $service->name }}
                                            </span>
                                        @endforeach
                                        @if ($type->services->count() > 3)
                                            <span class="text-xs text-gray-500 pt-1">+{{ $type->services->count() - 3 }}
                                                more</span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Card Footer (Actions) --}}
                        @canany(['view room_types', 'edit room_types', 'delete room_types'])
                            @can('view room_types')
                                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-between items-center">
                                    <a href="{{ route('room_types.show', $type->id) }}"
                                        class="text-sm font-medium text-indigo-600 hover:text-indigo-800 hover:underline">
                                        View Details
                                    </a>
                                @endcan
                                <div class="flex items-center gap-3">
                                    @can('edit room_types')
                                        <a href="{{ route('room_types.edit', $type->id) }}"
                                            class="p-2 text-gray-500 hover:text-indigo-600 hover:bg-gray-200 rounded-full transition"
                                            title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                    @endcan
                                    @can('delete room_types')
                                        <form action="{{ route('room_types.destroy', $type->id) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Are you sure you want to delete this type?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-full transition"
                                                title="Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endcan

                                </div>
                            </div>
                        @endcanany
                    </div>
                @endforeach
            </div>

            {{-- Empty State --}}
            @if ($roomTypes->isEmpty())
                <div class="text-center py-12 bg-white rounded-lg border border-dashed border-gray-300 mt-6">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        aria-hidden="true">
                        <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No room types</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new room category.</p>
                    <div class="mt-6">
                        <a href="{{ route('room_types.create') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Create New Type
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
