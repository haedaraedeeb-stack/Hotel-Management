@extends('layouts.admin')

@section('title', 'Edit Room')

@section('content')
<div class="py-6">
    <div class=" mx-auto">

        {{-- Header & Back --}}
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Edit Room: #{{ $room->room_number }}</h2>
            <div class="flex gap-3">
                <a href="{{ route('rooms.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium transition flex items-center">
                    &larr; Back to Rooms
                </a>
                @can('room-show')
                <a href="{{ route('rooms.show', $room->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition">
                    View Details
                </a>
                @endcan
            </div>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-8">

                {{-- Errors --}}
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded text-red-700 text-sm">
                        <p class="font-bold mb-1">Please fix the following errors:</p>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                @endif
                    @can('room-edit')
                <form action="{{ route('rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data" id="roomForm" class="space-y-8">
                    @csrf
                    @method('PUT')

                    {{-- 1. Room Details Section --}}
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-100 pb-2 mb-4">Room Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Room Number --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Room Number</label>
                                <input type="text" name="room_number" value="{{ old('room_number', $room->room_number) }}" required
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition">
                            </div>

                            {{-- Type --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Room Type</label>
                                <select name="room_type_id" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-white">
                                    @foreach($roomtypes as $type)
                                        <option value="{{ $type->id }}" {{ old('room_type_id', $room->room_type_id) == $type->id ? 'selected' : '' }}>
                                            {{ $type->type }} - ${{ number_format($type->base_price) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Status --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-white">
                                    <option value="available" {{ old('status', $room->status) == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="occupied" {{ old('status', $room->status) == 'occupied' ? 'selected' : '' }}>Occupied</option>
                                    <option value="maintenance" {{ old('status', $room->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                </select>
                            </div>

                            {{-- Price --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Price Per Night</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" name="price_per_night" value="{{ old('price_per_night', $room->price_per_night) }}" required step="0.01"
                                        class="pl-7 w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition">
                                </div>
                            </div>

                            {{-- Floor --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Floor</label>
                                <select name="floor" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-white">
                                    @for($i = 1; $i <= 20; $i++)
                                        <option value="{{ $i }}" {{ old('floor', $room->floor) == $i ? 'selected' : '' }}>Floor {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            {{-- View --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">View</label>
                                <select name="view" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-white">
                                    <option value="sea" {{ old('view', $room->view) == 'sea' ? 'selected' : '' }}>Sea View</option>
                                    <option value="city" {{ old('view', $room->view) == 'city' ? 'selected' : '' }}>City View</option>
                                    <option value="garden" {{ old('view', $room->view) == 'garden' ? 'selected' : '' }}>Garden View</option>
                                    <option value="pool" {{ old('view', $room->view) == 'pool' ? 'selected' : '' }}>Pool View</option>
                                    <option value="other" {{ old('view', $room->view) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- 2. Images Section --}}
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-100 pb-2 mb-4">Manage Images</h3>

                        {{-- Existing Images --}}
                        @if($room->images->count() > 0)
                            <div class="mb-6">
                                <p class="text-sm font-medium text-gray-600 mb-3">Existing Images (Select to Delete):</p>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    @foreach($room->images as $image)
                                        <div class="relative group aspect-square rounded-lg overflow-hidden border border-gray-200">
                                            <img src="{{ asset('storage/' . $image->path) }}" class="w-full h-full object-cover">

                                            <div class="absolute top-2 right-2">
                                                <input type="checkbox" name="images_to_delete[]" value="{{ $image->id }}"
                                                    class="h-5 w-5 text-red-600 rounded border-gray-300 focus:ring-red-500 cursor-pointer shadow-sm">
                                            </div>
                                            <div class="absolute bottom-0 inset-x-0 bg-black/60 text-white text-xs text-center py-1 opacity-0 group-hover:opacity-100 transition">
                                                Delete?
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Upload New --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Upload New Images</label>
                            <input type="file" name="new_images[]" multiple
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-gray-300 rounded-lg cursor-pointer bg-white">
                            <p class="text-xs text-gray-500 mt-1">Leave empty if you don't want to add new images.</p>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center justify-end pt-6 border-t border-gray-100 gap-3">
                        <a href="{{ route('rooms.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                            Cancel
                        </a>
                        <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-md transition transform hover:-translate-y-0.5">
                            Update Room
                        </button>
                    </div>

                </form>
                @endcan
            </div>
        </div>

    </div>
</div>
@endsection
