@extends('layouts.admin')

@section('title', 'Room Details')

@section('content')
<div class="py-6">
    <div class=" mx-auto">

        {{-- Header & Back --}}
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Room Details: #{{ $room->room_number }}</h2>
            <div class="flex gap-3">
                <a href="{{ route('rooms.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium transition flex items-center">
                    &larr; Back to Rooms
                </a>
                @can('room-edit')
                <a href="{{ route('rooms.edit', $room->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                    Edit Room
                </a>
                @endcan
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- 1. Main Info --}}
            <div class="md:col-span-2 bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">Information</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <span class="text-gray-600 font-medium">Room Number:</span>
                        <span class="text-gray-900 font-bold text-lg">#{{ $room->room_number }}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <span class="text-gray-600 font-medium">Type:</span>
                        <span class="text-gray-900">{{ $room->roomType->type ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <span class="text-gray-600 font-medium">Status:</span>
                        @if($room->status == 'available')
                            <span class="px-2 py-1 rounded-full bg-green-100 text-green-800 text-xs font-bold">Available</span>
                        @elseif($room->status == 'occupied')
                            <span class="px-2 py-1 rounded-full bg-orange-100 text-orange-800 text-xs font-bold">Occupied</span>
                        @else
                            <span class="px-2 py-1 rounded-full bg-red-100 text-red-800 text-xs font-bold">Maintenance</span>
                        @endif
                    </div>
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <span class="text-gray-600 font-medium">Price Per Night:</span>
                        <span class="text-gray-900 font-bold">${{ number_format($room->price_per_night) }}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <span class="text-gray-600 font-medium">Floor:</span>
                        <span class="text-gray-900">{{ $room->floor }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 font-medium">View:</span>
                        <span class="text-gray-900">{{ ucfirst($room->view) }}</span>
                    </div>
                </div>
            </div>

            {{-- 2. Images Gallery --}}
            <div class="md:col-span-1 bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">Images</h3>
                </div>
                <div class="p-6">
                    @if($room->images->isNotEmpty())
                        <div class="grid grid-cols-2 gap-2">
                            @foreach($room->images as $image)
                                <a href="{{ asset('storage/' . $image->path) }}" target="_blank" class="block aspect-square rounded-lg overflow-hidden border border-gray-200 hover:opacity-75 transition">
                                    <img src="{{ asset('storage/' . $image->path) }}" alt="Room" class="w-full h-full object-cover">
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-sm text-center py-4">No images available.</p>
                    @endif
                </div>
            </div>

        </div>

        {{-- Delete Button (Bottom) --}}
        @can('room-delete')
        <div class="mt-8 flex justify-end">
            <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this room?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium transition underline">
                    Delete Room Permanently
                </button>
            </form>
        </div>
        @endcan

    </div>
</div>
@endsection
