@extends('layouts.admin')

@section('title', 'Add Room')

@section('content')
    <div class="py-6">
        <div class="max-w-3xl mx-auto">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Add New Room</h2>
                <a href="{{ route('rooms.index') }}"
                    class="text-indigo-600 hover:text-indigo-800 text-sm font-medium transition">
                    &larr; Back to List
                </a>
            </div>

            {{-- Form Card --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-8">

                    {{-- Errors --}}
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded text-red-700 text-sm">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @can('room-create')
                        <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data"
                            class="space-y-6">
                            @csrf

                            {{-- Room Number & Type --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Room Number</label>
                                    <input type="text" name="room_number" value="{{ old('room_number') }}" required
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Room Type</label>
                                    <select name="room_type_id" required
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-white">
                                        <option value="">Select Type</option>
                                        @foreach ($roomtypes as $type)
                                            <option value="{{ $type->id }}"
                                                {{ old('room_type_id') == $type->id ? 'selected' : '' }}>
                                                {{ $type->type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Status & Price --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                    <select name="status" required
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-white">
                                        <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available
                                        </option>
                                        <option value="occupied" {{ old('status') == 'occupied' ? 'selected' : '' }}>Occupied
                                        </option>
                                        <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>
                                            Maintenance</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Price Per Night</label>
                                    <input type="number" name="price" value="{{ old('price_per_night') }}" required
                                        step="0.01"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>

                            {{-- Floor & View --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Floor</label>
                                    <select name="floor" required
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-white">
                                        @for ($i = 1; $i <= 20; $i++)
                                            <option value="{{ $i }}" {{ old('floor') == $i ? 'selected' : '' }}>
                                                Floor {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">View</label>
                                    <select name="view"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-white">
                                        <option value="sea">Sea View</option>
                                        <option value="city">City View</option>
                                        <option value="garden">Garden View</option>
                                        <option value="pool">Pool View</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Images --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Upload Images</label>
                                <input type="file" name="images[]" multiple
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-gray-300 rounded-lg">
                            </div>

                            {{-- Actions --}}

                                <div class="flex items-center justify-end pt-4 border-t border-gray-100">
                                    <a href="{{ route('rooms.index') }}"
                                        class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 mr-3 transition">
                                        Cancel
                                    </a>

                                <button type="submit"
                                    class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-md transition transform hover:-translate-y-0.5">
                                    Save Room
                                </button>
                            </div>

                        </form>
                    @else
                        <div class="p-4 bg-yellow-50 border-l-4 border-yellow-500 text-yellow-700">
                            You do not have permission to create rooms.
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
